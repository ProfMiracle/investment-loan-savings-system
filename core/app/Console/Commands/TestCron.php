<?php
namespace App\Http\Controllers;
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\GeneralSetting;
use App\UserWallet;
use Carbon\Carbon;
use App\Invest;
use App\Trx;
use App\User;
use Illuminate\Support\Facades\Request;

class TestCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:interest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate investment maturity period';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Code for testing cron job
     //dd("Hi there it's php artisan all the way");
        $now = Carbon::now();
$invest = Invest::whereStatus(1)->where('next_time', '<=',$now)->get();

$gnl = GeneralSetting::first();

foreach ($invest as $data)
{
     $user = User::find($data->user_id);
     $userInterestWallet = UserWallet::where('user_id', $data->user_id)->where('type', 'interest_wallet')->first();
     $next_time = Carbon::parse($now)->addHours($data->hours);

     $in = Invest::find($data->id);
     $in->return_rec_time + 1;
     $in->next_time = $next_time;
     $in->last_time = $now;

     if ($data->period == '-1')
     {
         $in->status = 1;
         $in->save();
         
         $new_balance = formatter_money($userInterestWallet->balance + $data->interest);
         $userInterestWallet->balance = $new_balance;

         Trx::create (
             [

             'user_id' => $user_id,
             'amount' =>  $data->interest,
             'main_amo' => $new_balance,
             'charge' => 0,
             'type' => '+',
             'remark' => 'interest',
             'title' => 'Interest Return'.$data->interest.' '.$gnl->cur_text.'Added on Your'.str_replace('_', ' ', $userInterestWallet->type).'Balance',
             'trx' => getTrx(),
             ]
         );
         $userInterestWallet->save();
         if($gnl->interest_return_commision == 1){
             $commisionType = formatter_money($data-inerest). ' '.$gnl->cur_text. 'Interest Commission';
             levelCommission($user-id, $data-interest, $commisionType);
         } else{
             if($data-capital_status == 1){
                 if($in->return_rec_time >= $data-period){
                     $bonus = $data->interest + $data->amount;
                     $new_balance = formatter_money($userInterestWallet->balance + $bonus);
                     $userInterestWallet->balance = $new_balance;
                     $in->status = 0;
                 } else{
                     $bonus = 0;
                     $new_balance = formatter_money($userInterestWallet->balance + $data->interest);
                     $userInterestWallet->balance = $new_balance;
                     $in->status = 1;
                 }
                 $in->save();
                 if($bonus !=0){
                     (
                         [
                         'user_id' => $user,
                         'amount' => $data-interest,
                         'main_amo' => $new_balance,
                         'charge' => 0,
                         'type' =>'+',
                         'remark' => 'interest',
                         'title' => 'Interest Return'.$data->interest.' '.$gnl->cur_text.'Added on Your'.str_replace('_', ' ', $userInterestWallet->type).'Balance',
                         'trx' => getTrx(),
                         ]
                     );
                     if($gnl->invest_return_commission == 1){
                         $commisionType = formatter_money($data->interest).' '.$gnl->cur_text. 'Interest Commission';
                         levelCommission($user->id, $data->interest, $commisionType);
                     }
                 }else{
                     (
                         [
                         'user_id' => $user->id,
                         'amount' => $data->interest,
                         'main_amo' => $new_balance,
                         'charge' => 0,
                         'type' => '+',
                         'remark' => 'interest',
                         'title' => 'Interest & Capatial Return'.$bonus.' '.$gnl->cur_text.'Added on Your '.str_replace('_', ' ', $userInterestWallet->type).'Wallet',
                         'trx' => getTrx(),
                         
                         ]
                     );
                     if($gnl->invest_return_commission == 1){
                         $commisionType = formatter_money($data->interest).' '.$gnl->cur_text.' Interest Commssion';
                         levelCommission($user->id, $data->interest, $commisionType);
                     }
                 }
                 $userInterestWallet->save();
             }else{
                 if($in->return_rec_time >= $data->period){
                     $in->status = 0;
                 }else{
                     $in->status = 1;
                 }
                 $in->save();
                 $new_balance = formatter_money($userInterestWallet->balance + $data->interest);
                 $userInterestWallet->balance = $new_balance;
                 $userInterestWallet->save();
                 Trx::create(
                     [
                     'user_id' => $user_id,
                     'amount' => $data->interest,
                     'main_amo' => $new_balance,
                     'charge' => 0,
                     'type' => '+',
                     'remark' => 'interest',
                     'title' => 'Interest Return '.$data->interest.' '.$gnl->cur_text.'Added on Your '.str_replace('_', ' ', $userInterestWallet->type).'Wallet',
                     'trx' => getTrx(),
                     
                     ]
                 );
                 if($gnl->invest_return_commission == 1){
                     $commisionType = formatter_money($data->interest).' '.$gnl->cur_text.'Interest Commission';
                     levelCommission($user->id, $data->interest, $commisionType);
                 }
             }
         }
     }
}
//echo "Still on cron job matter";
}

}

