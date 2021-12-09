<?php

namespace App\Http\Controllers\Gateway;

use App\Autosave;
use App\CardAuthorization;
use App\GeneralSetting;
use App\Trx;
use App\UserWallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GatewayCurrency;
use App\Deposit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Session;
use App\User;
use App\Gateway;
use App\Rules\FileTypeValidate;

class PaymentController extends Controller
{
    public function deposit()
    {
        $in = session()->get('indirect_i');
        session()->forget('indirect_i');
        if ($in)
        {
            $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
                $gate->where('accept_savings', 1)->where('status', 1);
            })->with('method')->orderby('method_code')->get();
            $dat = Autosave::find((session()->get('indirect')->id));
        }else{
            $dat = NULL;
            $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
                $gate->where('status', 1);
            })->with('method')->orderby('method_code')->get();
        }

        $page_title = 'Deposit Methods';
        return view(activeTemplate() . 'user.deposit', compact('gatewayCurrency', 'page_title', 'dat'));
    }

    public function transfer()
    {
        $user = Auth::user();
        $query = "SELECT * FROM user_wallets WHERE user_id = ? AND type =?";
        $check = DB::select($query, [$user->id, 'deposit_wallet']);
        //$min = $check[0]->balance - (10% $check[0]->balance);
        $page_title = 'Transfer Fund';
        return view(activeTemplate() . 'user.transfer', compact('page_title'));
    }

    public function transferInsert(Request $request)
    {
        //$notify = [];
        $request->validate([
            'wallet' => 'required',
            'amount' => 'required|numeric|min:100',
            'username' => 'required',
        ]);

        $user = Auth::user();
        //get the sender's balance
        $sql = "SELECT * FROM user_wallets WHERE user_id = ? AND type = ?";
        $sender = DB::select($sql, [$user->id, $request->wallet.'_wallet']);
        $sender = $sender[0];

        $sql = "SELECT * FROM users WHERE username = ?";

        $get = DB::select($sql, [$request->username]);

        if (empty($get)){
            $notify[] = ['error', 'Invalid beneficiary supplied'];
            return back()->withNotify($notify);
        }

        if ($get[0]->id == $user->id){
            $notify[] = ['error', 'You can not make transfers to yourself'];
            return back()->withNotify($notify);
        }

        $get = $get[0];

        if ($request->amount > $sender->balance) {
            $notify[] = ['error', 'Insufficient balance in selected wallet'];
            return back()->withNotify($notify);
        }

        $page_title = 'Transfer Confirm';

        $beneficiary = new \stdClass();
        $beneficiary->fullname = $get->firstname. ' '.$get->lastname;
        $beneficiary->username = $get->username;
        $beneficiary->amount = $request->amount;

        //saving in transfer tracking table
        $trx = getTrx();
        Session::put('Track', $trx);
        $sql = "INSERT INTO transfer (user_id, reciever_id, amount, trx, method) VALUES (?, ?, ?, ?, ?)";
        $insert = DB::insert($sql, [$user->id, $get->id, $request->amount, $trx, $request->wallet.'_wallet']);

        return view(activeTemplate() . 'transfer.preview', compact('page_title','beneficiary'));
    }

    public function transferConfirm()
    {
        $user = Auth::user();
        $track = Session::get('Track');
        $sql = "SELECT * FROM transfer WHERE trx = ?";
        $check_track = DB::select($sql, [$track]);

        if (is_null($check_track)){
            $notify[] = ['error', 'Invalid transfer'];
            return redirect()->route('user.transfer')->withNotify($notify);
        }

        $transfer = $check_track[0];

        //debit the user
        $user = UserWallet::where('user_id', $user->id)->where('type', $transfer->method)->first();
        $user['balance'] = formatter_money(($user['balance'] - $transfer->amount));
        $user->update();

        //credit the other guy
        $user = UserWallet::where('user_id', $transfer->reciever_id)->where('type', 'deposit_wallet')->first();
        $user['balance'] = formatter_money(($user['balance'] + $transfer->amount));
        $user->update();

        //update status code of transfer
        $sql = "UPDATE transfer SET status = ? WHERE user_id = ? AND reciever_id = ?";
        $update = DB::update($sql, [1, $transfer->user_id, $transfer->reciever_id]);

        $notify[] = ['success', 'Your request is successful.'];
        return redirect()->route('user.transfer')->withNotify($notify);
    }

    public function depositInsert(Request $request)
    {
        //dd($request->input());
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'method_code' => 'required',
            'currency' => 'required',
        ]);

        $user = auth()->user();

        $now = \Carbon\Carbon::now();
        if (session()->has('req_time') && $now->diffInSeconds(\Carbon\Carbon::parse(session('req_time'))) <= 2) {
            $notify[] = ['error', 'Please wait a moment, processing your deposit'];
            return redirect()->route('payment.preview')->withNotify($notify);
        }
        session()->put('req_time', $now);

        $gate = GatewayCurrency::where('method_code', $request->method_code)->where('currency', $request->currency)->first();


        if (!$gate) {
            $notify[] = ['error', 'Invalid Gateway'];
            return back()->withNotify($notify);
        }

        if ($gate->min_amount > $request->amount || $gate->max_amount < $request->amount) {
            $notify[] = ['error', 'Please Follow Deposit Limit'];
            return back()->withNotify($notify);
        }

        $charge = formatter_money($gate->fixed_charge + ($request->amount * $gate->percent_charge / 100));

        $payable = formatter_money($request->amount + $charge);

        $final_amo = formatter_money($payable /$gate->rate);

        $depo['user_id'] = $user->id;
        $depo['method_code'] = $gate->method_code;
        $depo['method_currency'] = strtoupper($gate->currency);
        $depo['amount'] = $request->amount;
        $depo['charge'] = $charge;
        $depo['rate'] = $gate->rate;
        $depo['final_amo'] = formatter_money($final_amo);
        $depo['btc_amo'] = 0;
        $depo['btc_wallet'] = "";
        $depo['trx'] = getTrx();
        $depo['try'] = 0;
        $depo['status'] = 0;
        $depo['savings'] =  (isset($_GET['savings']))? 1: 0;

        $data = Deposit::create($depo);

        Session::put('Track', $data['trx']);
        $page_title = 'Payment Preview';


        if($data->method_code > 999){
            return redirect()->route('user.manualDeposit.preview');
        }

        return view(activeTemplate() . 'payment.preview', compact('data', 'page_title'));
    }


    public function depositConfirm() 
    {
        $track = Session::get('Track');
        $deposit = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        if (is_null($deposit)) {
            $notify[] = ['error', 'Invalid Deposit Request'];
            return redirect()->route('user.deposit')->withNotify($notify);
        }
        if ($deposit->status != 0) {
            $notify[] = ['error', 'Invalid Deposit Request'];
            return redirect()->route('user.deposit')->withNotify($notify);
        }

        if ($deposit->method_code >= 1000) {
            $this->userDataUpdate($deposit);
            $notify[] = ['success', 'Your deposit request is queued for approval.'];
            return back()->withNotify($notify);
        }

        $xx = 'g' . $deposit->method_code;
        $new =  __NAMESPACE__ . '\\' . $xx . '\\ProcessController';

        $data =  $new::process($deposit);
        $data =  json_decode($data);


        if (isset($data->error)) {
            $notify[] = ['error', $data->message];
            return redirect()->route('user.deposit')->withNotify($notify);
        }
        if (isset($data->redirect)) {
            return redirect($data->redirect_url);
        }


        $page_title = 'Payment Confirm';

        return view(activeTemplate() . $data->view, compact('data', 'page_title','deposit'));
    }


    public static  function userDataUpdate($d, $result)
    {
        $gnl = GeneralSetting::first();
        $data = Deposit::where('trx', $d->trx)->first();
        $in = session()->get('indirect_i');
        if ($data->status == 0) {
            $data['status'] = 1;
            $data->update();

            $user = User::find($data->user_id);

            if ($data['savings']==1)
            {
                $a = Autosave::find($in->id);
                $a->status = 1;
                $a->save();

                //store card authorization in table
                CardAuthorization::create([
                    'user_id'=> $data->user_id,
                    'autosave_id'=>$in->id,
                    'authorization'=>json_encode($result['authorization']),
                ]);
            }else
            {
                $userWallet = UserWallet::where('user_id',$data->user_id)->where('type','deposit_wallet')->first();

                $userWallet->balance += $data->amount;
                $userWallet->save();
            }

            $gateway = $data->gateway;
            Trx::create([
                'user_id' => $data->user_id,
                'amount' => $data->amount,
                'main_amo' => formatter_money($user->balance, config('constants.currency.base')),
                'charge' => formatter_money($data->charge, config('constants.currency.base')),
                'type' => '+',
                'remark' => ($data['savings']==1)?'savings':'deposit',
                'title' => ($data['savings']==1)?'Savings Via ' . $gateway->name:'Deposit Via ' . $gateway->name,
                'trx' => $data->trx
            ]);
            $amount = $data->method_currency . ' ' . formatter_money($data->amount, $gateway->crypto());


            if($gnl->deposit_commission == 1){
                $commissionType =  'Commission Rewarded For '. formatter_money($data->amount) . ' '.$gnl->cur_text.' Deposit';
                levelCommision($user->id, $data->amount, $commissionType);
            }

            if ($data['savings']==1)
            {
                notify($user, $type = 'SAVINGS_STARTED', [
                    'interval' =>  $in->interval,
                    'duration' =>  $in->duration,
                    'amount' =>  $amount,
                    'method' => $gateway->name,
                    'trx' => $data->trx,
                    'charge' => formatter_money($data->charge),
                ]);
            }else
            {
                notify($user, $type = 'DEPOSIT_COMPLETE', [
                    'amount' =>  $amount,
                    'method' => $gateway->name,
                    'trx' => $data->trx,
                    'charge' => formatter_money($data->charge),
                ]);
            }

        }
    }

    public function manualDepositPreview()
    {
        $track = Session::get('Track');
        $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->first();
        if (!$data) {
            return redirect()->route('user.deposit');
        }
        $page_title = "Payment Preview";


        return view(activeTemplate() . 'manual_payment.manual_preview', compact('page_title', 'data'));
    }

    public function manualDepositConfirm()
    {

        $track = Session::get('Track');

        $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->first();
        if (!$data) {
            return redirect()->route('user.deposit');
        }
        if ($data->status != 0) {
            return redirect()->route('user.deposit');
        }

        if($data->method_code > 999){

            $page_title = 'Deposit Confirm';
            $method = $data->gateway_currency();

            return view(activeTemplate() . 'manual_payment.manual_confirm', compact('data','page_title','method'));
        }
        abort(404);
    }

    public function manualDepositUpdate(Request $request)
    {
        $track = Session::get('Track');
        $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->first();
        if (!$data) {
            return redirect()->route('user.deposit');
        }
        if ($data->status != 0) {
            return redirect()->route('user.deposit');
        }

        $params = json_decode($data->gateway_currency()->parameter);

        $extra = $data->gateway->extra;

        if (!empty($params)) {
            foreach ($params as $param) {
                $validation_rule['ud.' . str_slug($param)] = 'required';
                $validation_msg['ud.'. str_slug($param) .'.required'] =  str_replace("ud."," ",$param) . ' is required';
            }
            $request->validate($validation_rule, $validation_msg);
        }
        if ($request->hasFile('verify_image')) {
            try {
                $filename = upload_image($request->verify_image, config('constants.deposit.verify.path'));
                $data['verify_image'] = $filename;
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Could not upload your '.$extra->verify_image];
                return back()->withNotify($notify)->withInput();
            }
        }

        $data->detail =$request->ud;
        $data->status = 2; // pending
        $data->update();

        notify($data->user, $type = 'DEPOSIT_PENDING', [
            'trx' => $data->trx,
            'amount' => formatter_money($data->amount) . ' '.$data->method_currency,
            'method' => $data->gateway_currency()->name,
            'charge' => formatter_money($data->charge) . ' '.$data->method_currency,
        ]);

        $notify[] = ['success', 'You have deposit request has been taken.'];
        return redirect()->route('user.deposit')->withNotify($notify);
    }
}
