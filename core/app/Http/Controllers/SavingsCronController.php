<?php


namespace App\Http\Controllers;


use App\Autosave;
use App\AutosavePlan;
use App\CardAuthorization;
use App\CronHolder;
use App\Exceptions\CustomException;
use App\GatewayCurrency;
use App\GeneralSetting;
use App\SavingsWallet;
use App\Targetsave;
use App\Trx;
use App\User;
use App\UserWallet;
use App\Vaultsave;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SavingsCronController extends Controller
{
    public function cron()
    {
        try {
            /**
             * this route is best called every morning (8am), afternoon(2pm), evening (8pm)
             */
            $now = Carbon::now();
            /**
             * select all that should be debited from cronholder
             * loop through to find the ones that the time fall in the time selected or attempt is more than zero
             * or it has passed end date, if it has passed, mark as completed
             * now for each of them, get data from the card authorization table
             * from this table we already know the type and type id
             * try to debit the authorization
             * if success, increase the accumulated by the amount and clear attempt
             * increase in the saving wallet
             * check if it is the last day of check and mark as completed
             * notify the user via mail
             * else if it fails, increase attempt by 1
             * notify the user and get ready to retry in next run
             */

            $cron_holder = CronHolder::where('status', 1)->get();

            $gateway = GatewayCurrency::where('method_code', 107)->first();
            $paystackAcc = json_decode($gateway->parameter);
            $secret_key = $paystackAcc->secret_key;

            foreach ($cron_holder as $c)
            {
                $authorization = CardAuthorization::find($c->authorization);
                if ($authorization->for == 'autosave')
                {
                    $method = Autosave::find($authorization->for_id);
                }
                if ($authorization->for == 'vault')
                {
                    $method = Vaultsave::find($authorization->for_id);
                }
                if ($authorization->for == 'targetsave')
                {
                    $method = Targetsave::find($authorization->for_id);
                }

                //skip this guy if it is not his debit time
                if (!self::time($method->when) && !self::interval($method->how, $method->updated_at))
                {
                    continue;
                }

                // run auto debit
                $url = "https://api.paystack.co/transaction/charge_authorization";
                $fields = [
                    'authorization_code' => json_decode($authorization->authorization)->authorization_code,
                    'email' => $method->email,
                    'amount' => $method->amount * 100
                ];
                $fields_string = http_build_query($fields);
                //open connection
                $ch = curl_init();

                //set the url, number of POST vars, POST data
                curl_setopt($ch,CURLOPT_URL, $url);
                curl_setopt($ch,CURLOPT_POST, true);
                curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Authorization: Bearer $secret_key",
                    "Cache-Control: no-cache",
                ));

                //So that curl_exec returns the contents of the cURL; rather than echoing it
                curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

                //execute post
                $re = curl_exec($ch);
                $result = json_decode($re, true);

                //this user
                $user = User::find($method->user_id);

                if ($result) {
                    if ($result['data']) {
                        if ($result['data']['status'] == 'success') {
                            //increase the accumulated amount
                            $method->accumulated = $method->accumulated + $method->amount;

                            //check if it is completed and save
                            if ($now >= $method->end)
                            {
                                //if it has completed change the status in the saving table
                                $method->status = 3;

                                //add to interest wallet
                                $wallet = UserWallet::where('type', 'interest_wallet')->where('user_id', $user->id)->first();
                                $wallet->balance = $wallet->balance + ($method->accumulated + $method->amount);
                                $wallet->save();

                                //here we change the status in the cron job
                                $cron = CronHolder::find($c->id);
                                $cron->status = 2;
                                $cron->save();

                                //notify the user tat his savings is completed
                                notify($user, $type = 'SAVINGS_COMPLETED', [
                                    'amount' =>  $method->amount,
                                    'method' => 'PayStack',
                                    'message' => 'Your savings of'. $method->amount . ' started on '. $method->start .' has
                                 ended, your new balance is '.$method->accumulated
                                ]);
                            }
                            $method->save();

                            //add the amount to the savings wallet
                            $s = SavingsWallet::where('user_id', $method->user_id)
                                ->where('type', $authorization->for)
                                ->first();
                            $s->balance = $method->amount;
                            $s->save();

                            Trx::create([
                                'user_id' => $user->id,
                                'amount' => $method->amount,
                                'main_amo' => formatter_money($method->amount, config('constants.currency.base')),
                                'charge' => formatter_money(0, config('constants.currency.base')),
                                'type' => '+',
                                'remark' => 'autodebit',
                                'title' => 'Autodebit Via ' . 'Paystack',
                                'trx' => ''
                            ]);

                            //notify the user via email that the payment went through
                            notify($user, $type = 'AUTODEBIT_COMPLETE', [
                                'amount' =>  $method->amount,
                                'method' => 'PayStack',
                            ]);

                            continue;
                        }
                    }
                    //increment the attempt
                    $cron = CronHolder::find($c->id);
                    $cron->attempts = $cron->attempts + 1;
                    $cron->save();

                    //notify the user
                    notify($user, $type = 'AUTODEBIT_FAILED', [
                        'amount' =>  $method->amount,
                        'method' => 'PayStack',
                        'message' => 'Something went wrong while executing'
                    ]);

                    //continue;
                }else
                {
                    throw new CustomException('Could not make curl request');
                }
            }
        }catch (\Throwable $throwable)
        {
            report($throwable);
        }
        echo true;
    }

    private static function time($when)
    {
        /**
         * this checks if time is +/- 3 hours from $time
         * and returns true
         */
        $now = strtotime(($when == 'morning')?"09:59":($when == 'afternoon'?"14:59":"23:59"));
        $back = strtotime("$now - 2 hours");
        $front = strtotime("$now + 2 hours");

        return ($now >= $back) && ($now <= $front);
    }

    private static function interval($when, $last_done)
    {
        $now = Carbon::now();

        return round((strtotime($last_done) - strtotime($now))/(($when === 'monthly')?60*60*24*7*28
                    :($when === 'weekly'?60*60*24*7:60*60*24))) >= 1;
    }
}
