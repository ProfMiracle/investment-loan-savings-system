<?php


namespace App\Http\Controllers;


use App\Autosave;
use App\AutosavePlan;
use App\CardAuthorization;
use App\CronHolder;
use App\Deposit;
use App\GatewayCurrency;
use App\Http\Controllers\Gateway\PaymentController;
use App\SavingPlans;
use App\SavingReason;
use App\SavingsTempDump;
use App\SavingsWallet;
use App\Targetsave;
use App\TimeSetting;
use App\Trx;
use App\UserWallet;
use App\Vaultsave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class SavingsController extends Controller
{
    public function initiateFirstHandshake(Request $request)
    {
        $user = Auth::user();
        $return = Autosave::create([
            'user_id'=>$user->id,
            'user_email'=>$user->email,
            'amount'=>$request->amount,
            'interval'=>$request->interval,
            'duration'=>$request->duration
        ]);
        session()->put('indirect_i', $return->id);
        session()->put('indirect', $return);
        return redirect()->route('user.deposit');
        //return (new PaymentController())->deposit(true);
    }

    public function savings()
    {
        $data['page_title'] = "Savings Plan";
        $data['plans'] = SavingPlans::all();
        return view(activeTemplate() . 'savings', $data);
    }

    public function sortPlanByType(Request $request)
    {
        $permitted_types = ['autosave', 'vault', 'targetsave'];
        if (in_array($request->plan, $permitted_types))
        {
            $reasons = SavingReason::all();
            $page_title = 'Start '.ucfirst($request->plan).' Plan';
            $type = $request->plan;
            return view(activeTemplate() . 'user.savings.startsave', compact( 'page_title', 'type', 'reasons'));
        }else{
            return redirect()->back()->with('error', 'invalid saving type');
        }
    }

    public function userGetHistory(Request $request)
    {
        $check = ['vault', 'targetsave', 'autosave'];
        if (isset($request->type) && in_array($request->type, $check))
        {
            $page_title = ucfirst($request->type)." Savings History";
            $empty_message = 'No history found.';
            if ($request->type == 'vault')
            {
                $model = new Vaultsave();
            }
            if ($request->type == 'targetsave')
            {
                $model = new Targetsave();
            }
            if ($request->type == 'autosave')
            {
                $model = new Autosave();
            }
            $type = $request->type;
            $history = $model->where('user_id', Auth::id())->where('status', '!=', 0)->latest()->paginate(20);
            return view(activeTemplate() . 'user.savings.userhistory', compact('page_title', 'empty_message', 'history', 'type'));
        }else{
            $page_title = "Savings History";
            $plans = SavingPlans::all();
            return view(activeTemplate() . 'user.savings.history',compact('plans', 'page_title'));
        }
    }

    public function breakSavings(Request $request)
    {
        if ($request->type == 'vault')
        {
            $model = Vaultsave::find($request->id);
        }
        if ($request->type == 'targetsave')
        {
            $model = Targetsave::find($request->id);
        }
        if ($request->type == 'autosave')
        {
            $model = Autosave::find($request->id);
        }
        /**
         * first i get the data required to compute the penalty
         * then i compute penalty, credit the user and stop the savings
         */
        $admin_decision = SavingPlans::where('type', $request->type)->first();

        $amount_to_subtract = $model->accumulated;

        $card_authorization = CardAuthorization::where('user_id', Auth::id())
            ->where('for', $request->type)
            ->where('for_id', $model->id)->first();

        //we set the accumulated in the model save table to zero as we as it's status
        $model->accumulated = 0;
        $model->status = 2;
        $model->save();

        if ($request->type != 'vault')
        {
            //we stop the cron job from running
            $cron = CronHolder::where('user_id', Auth::id())
                ->where('authorization', $card_authorization->id)->first();
            if ($cron)
            {
                $cron->status = 2;
                $cron->save();
            }
        }

        //implement the amount to subtract on money
        $final_amount = $amount_to_subtract + ($amount_to_subtract * ($admin_decision->penalty/100));

        //here we deduct the value from the save column of wallet
        $swallet = SavingsWallet::where('user_id', Auth::id())
            ->where('type', $request->type)->first();
        $swallet->balance = $swallet->balance - $final_amount;
        $swallet->save();

        //here we send money to the user's interest wallet
        $pay_amount = $amount_to_subtract - ($amount_to_subtract * ($admin_decision->penalty/100));

        $wallet = UserWallet::where('type', 'interest_wallet')->where('user_id', Auth::id())->first();
        $wallet->balance = $wallet->balance + $pay_amount;
        $wallet->save();

        return back()->withNotify(['success', 'The operation was successful']);
    }

    public function confirmsave(Request $request)
    {
        /**
         * send the data out to tne confirmation route
         */
        $type = $request->input('type');
        $data['name'] = $request->input('name')??NULL;
        $data['end'] = $request->input('end')??NULL;
        $data['how'] = $request->input('how')??NULL;
        $data['type'] = $request->input('type')??NULL;
        $data['when'] = $request->input('when')??NULL;
        $data['start'] = $request->input('start')??NULL;
        $data['amount'] = $request->input('amount')??NULL;
        $data['reason'] = $request->input('reason')??NULL;
        $data['target'] = $request->input('target')??NULL;
        $data['method'] = $request->input('method')??NULL;
        $reason = SavingReason::find($request->input('reason'))->reason;
        $page_title = 'Confirm savings';

        /**
         * create th transaction hash for savings plan and tore savings data in the
         * savings plan table with the transaction hash
         */
        $trx = getTrx();

        SavingsTempDump::create([
            'trx'=>$trx,
            'type'=>$type,
            'data'=>json_encode($data)
        ]);

        if ($request->input('type') == 'vault' && $request->input('method') != 'card')
        {
            $user = Auth::user();
            if ($request->input('method') == 'deposit')
            {
                $wallet = SavingsWallet::where('user_id', $user->id)
                    ->where('type', 'deposit')->first();
                if (isset($wallet->balance) && $wallet->balance >= $request->input('amount'))
                {
                    $wallet->balance = $wallet->balance-$request->input('amount');
                }else{
                    return back()->with(['error', 'insufficient funds']);
                }
            }

            if ($request->input('method') == 'interest')
            {
                $wallet = SavingsWallet::where('user_id', $user->id)
                    ->where('type', 'interest')->first();
                if (isset($wallet->balance) && $wallet->balance >= $request->input('amount'))
                {
                    $wallet->balance = $wallet->balance-$request->input('amount');
                }else{
                    return back()->with(['error', 'insufficient funds']);
                }
            }

            Vaultsave::create([
                'user_id'=>$user->id,
                'name'=>$data['name'],
                'method'=>$data['method'],
                'amount'=>$data['amount'],
                'email'=>$user->email,
                'end'=>$data['end'],
                'reason'=>$data['reason'],
                'accumulated'=>$data['amount'],
            ]);
            /**
             * here we will add to the user's autosave balance
             */
            $checkIfBalanceExist = SavingsWallet::getBalance($user->id, 'vault');

            if (!isset($checkIfBalanceExist->balance))
            {
                SavingsWallet::create([
                    'user_id'=>$user->id,
                    'type'=>'vault',
                    'balance'=>$data['amount']
                ]);
            }else{
                $s = SavingsWallet::find($checkIfBalanceExist->id);
                $s->balance = $checkIfBalanceExist->balance + $data['amount'];
                $s->save();
            }
            /**
             * here we notify the user that his/her autosave has kicked off
             */
            $notify[] = ['success', 'Deposit Successful'];
            return back()->with($notify);
        }

        /**
         * if the payment method is card it should proceed to this page
         */
        return view(activeTemplate().'user.savings.confirmsave', compact('data', 'type','page_title', 'reason', 'trx'));
    }

    public function addCard(Request $request)
    {
        $_d = SavingsTempDump::where('trx', $request->trx)->where('type', $request->plan)->first();
        $d = json_decode($_d->data);

        /**
         * handle paystack payment send out,
         */

        $user = auth()->user();

        $now = \Carbon\Carbon::now();
        if (session()->has('req_time') && $now->diffInSeconds(\Carbon\Carbon::parse(session('req_time'))) <= 2) {
            $notify[] = ['error', 'Please wait a moment, processing your deposit'];
            return redirect()->route('payment.preview')->withNotify($notify);
        }
        session()->put('req_time', $now);

        $gateway = GatewayCurrency::where('method_code', 107)->first();

        if (!$gateway) {
            $notify[] = ['error', 'Invalid Gateway'];
            return back()->withNotify($notify);
        }

        /*if ($gateway->min_amount > $request->amount || $gateway->max_amount < $request->amount) {
            $notify[] = ['error', 'Please Follow Deposit Limit'];
            return back()->withNotify($notify);
        }*/

        $charge = formatter_money($gateway->fixed_charge + ($d->amount * $gateway->percent_charge / 100));

        $payable = formatter_money($d->amount + $charge);

        $final_amo = formatter_money($payable /$gateway->rate);

        $depo['user_id'] = $user->id;
        $depo['method_code'] = $gateway->method_code;
        $depo['method_currency'] = strtoupper($gateway->currency);
        $depo['amount'] = $d->amount;
        $depo['charge'] = $charge;
        $depo['rate'] = $gateway->rate;
        $depo['final_amo'] = formatter_money($final_amo);
        $depo['btc_amo'] = 0;
        $depo['btc_wallet'] = "";
        $depo['trx'] = $_d->trx;
        $depo['try'] = 0;
        $depo['status'] = 0;
        $depo['savings'] =  1;

        $data = Deposit::create($depo);

        $paystackAcc = json_decode($gateway->parameter);
        //dd($paystackAcc);
        $send['key'] = $paystackAcc->public_key;
        $send['email'] = Auth::user()->email;
        $send['amount'] = $data->final_amo * 100;
        $send['currency'] = $data->method_currency;
        $send['ref'] = $data->trx;
        $send['view'] = 'payment.g107';
        $send['savings'] = $data->savings;
        $send['is_card'] = $d->type == 'autosave'||'targetsave';
        //return json_encode($send);

        $page_title = 'Payment Confirm';

        return view(activeTemplate() . 'user.savings.pay', compact('send', 'page_title','data'));
    }

    public function verifyPayment(Request $request)
    {

        $request->validate([
            'reference' => 'required',
        ]);

        $track = $request->reference;
        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        $savingsDump = SavingsTempDump::where('trx', $track)->first();

        $paystackAcc = json_decode($data->gateway_currency()->parameter);
        $secret_key = $paystackAcc->secret_key;

        $result = [];
        //The parameter after verify/ is the transaction reference to be verified
        $url = 'https://api.paystack.co/transaction/verify/' . $track;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $secret_key]);
        $r = curl_exec($ch);
        curl_close($ch);



        if ($r) {
            $result = json_decode($r, true);

            if ($result) {
                if ($result['data']) {
                    if ($result['data']['status'] == 'success') {

                        $am = $result['data']['amount'];
                        $sam = round($data->final_amo, 2) * 100;

                        if ($am == $sam && $result['data']['currency'] == $data->method_currency  && $data->status == '0') {
                            //PaymentController::userDataUpdate($data, $result['data']);
                            /**
                             * here i will check the kind of payment the user is saving for and either put it in the
                             * cron job table as autosave, vault or
                             */
                            $temp = json_decode($savingsDump->data);
                            switch ($savingsDump->type)
                            {
                                case 'autosave':
                                    /**
                                     * it is an autosave operation so we first get the authorization on the card
                                     * then store the authorization details for further deduction
                                     */
                                    $authorization = $result['data']['authorization'];

                                    /**
                                     * now we are sure of this, so we go ahead and give this guy a spot on the autosave table
                                     */
                                    $auto = Autosave::create([
                                        'user_id'=>$data->user_id,
                                        'start'=>$temp->start,
                                        'end'=>$temp->end,
                                        'amount'=>$temp->amount,
                                        'email'=>Auth::user()->email,
                                        'how'=>$temp->how,
                                        'when'=>$temp->when,
                                        'reason'=>$temp->reason,
                                        'accumulated'=>$temp->amount,
                                    ]);

                                    $card=CardAuthorization::create([
                                        'user_id'=>$data->user_id,
                                        'authorization'=>json_encode($authorization),
                                        'for'=>'autosave',
                                        'for_id'=>$auto->id
                                    ]);

                                    /**
                                     * here we will add to the user's autosave balance
                                     */
                                    $checkIfBalanceExist = SavingsWallet::getBalance($data->user_id, 'autosave');
                                    if (!isset($checkIfBalanceExist->balance))
                                    {
                                        SavingsWallet::create([
                                            'user_id'=>$data->user_id,
                                            'type'=>'autosave',
                                            'balance'=>$data->amount
                                        ]);
                                    }else{
                                        $s = SavingsWallet::find($checkIfBalanceExist->id);
                                        $s->balance = $checkIfBalanceExist->balance + $data->amount;
                                        $s->save();
                                    }

                                    /**
                                     * here we will log for cron job
                                     */
                                    CronHolder::create([
                                        'user_id'=>$data->user_id,
                                        'start'=>$temp->start,
                                        'end'=>$temp->end,
                                        'amount'=>$temp->amount,
                                        'how'=>$temp->how,
                                        'when'=>$temp->when,
                                        'authorization'=>$card->id
                                    ]);
                                    /**
                                     * here we notify the user that his/her autosave has kicked off
                                     */
                                    $notify[] = ['success', 'Deposit Successful'];
                                    break;
                                case 'vault':
                                    Vaultsave::create([
                                        'user_id'=>$data->user_id,
                                        'name'=>$data->name,
                                        'method'=>$data->method,
                                        'amount'=>$temp->amount,
                                        'email'=>Auth::user()->email,
                                        'end'=>$temp->end,
                                        'reason'=>$temp->reason,
                                        'accumulated'=>$temp->amount,
                                    ]);
                                    /**
                                     * here we will add to the user's autosave balance
                                     */
                                    $checkIfBalanceExist = SavingsWallet::getBalance($data->user_id, 'vault');

                                    if (!isset($checkIfBalanceExist->balance))
                                    {
                                        SavingsWallet::create([
                                            'user_id'=>$data->user_id,
                                            'type'=>'vault',
                                            'balance'=>$data->amount
                                        ]);
                                    }else{
                                        $s = SavingsWallet::find($checkIfBalanceExist->id);
                                        $s->balance = $checkIfBalanceExist->balance + $data->amount;
                                        $s->save();
                                    }
                                    /**
                                     * here we notify the user that his/her autosave has kicked off
                                     */
                                    $notify[] = ['success', 'Deposit Successful'];
                                    break;
                                case 'targetsave':
                                    /**
                                     * it is an autosave operation so we first get the authorization on the card
                                     * then store the authorization details for further deduction
                                     */
                                    $authorization = $result['data']['authorization'];

                                    /**
                                     * now we are sure of this, so we go ahead and give this guy a spot on the autosave table
                                     */
                                    $auto = Targetsave::create([
                                        'user_id'=>$data->user_id,
                                        'name'=>$temp->name,
                                        'start'=>$temp->start,
                                        'target'=>$temp->target,
                                        'end'=>$temp->end,
                                        'amount'=>$temp->amount,
                                        'email'=>Auth::user()->email,
                                        'how'=>$temp->how,
                                        'when'=>$temp->when,
                                        'reason'=>$temp->reason,
                                        'accumulated'=>$temp->amount,
                                    ]);

                                    $card=CardAuthorization::create([
                                        'user_id'=>$data->user_id,
                                        'authorization'=>json_encode($authorization),
                                        'for'=>'targetsave',
                                        'for_id'=>$auto->id
                                    ]);

                                    /**
                                     * here we will add to the user's autosave balance
                                     */
                                    $checkIfBalanceExist = SavingsWallet::getBalance($data->user_id, 'targetsave');
                                    if (!isset($checkIfBalanceExist->balance))
                                    {
                                        SavingsWallet::create([
                                            'user_id'=>$data->user_id,
                                            'type'=>'targetsave',
                                            'balance'=>$data->amount
                                        ]);
                                    }else{
                                        $s = SavingsWallet::find($checkIfBalanceExist->id);
                                        $s->balance = $checkIfBalanceExist->balance + $data->amount;
                                        $s->save();
                                    }

                                    /**
                                     * here we will log for cron job
                                     */
                                    CronHolder::create([
                                        'user_id'=>$data->user_id,
                                        'start'=>$temp->start,
                                        'end'=>$temp->end,
                                        'amount'=>$temp->amount,
                                        'how'=>$temp->how,
                                        'when'=>$temp->when,
                                        'authorization'=>$card->id
                                    ]);
                                    /**
                                     * here we notify the user that his/her autosave has kicked off
                                     */
                                    $notify[] = ['success', 'Deposit Successful'];
                                    break;
                            }
                            //$notify[] = ['success', 'Deposit Successful'];
                        } else {
                            $notify[] = ['error', 'Less Amount Paid. Please Contact With Admin'];
                        }
                    } else {
                        $notify[] = ['error', $result['data']['gateway_response']];
                    }
                } else {
                    $notify[] = ['error', $result['message']];
                }
            } else {
                $notify[] = ['error', 'Something went wrong while executing1'];
            }
        } else {
            $notify[] = ['error', 'Something went wrong while executing'];
        }

        session()->push('notify',$notify[0]);
        echo true;
    }
}
