<?php

namespace App\Http\Controllers;

use App\CommissionLog;
use App\ContactTopic;
use App\Deposit;
use App\GeneralSetting;
use App\Invest;
use App\Lib\GoogleAuthenticator;
use App\Plan;
use App\SavingsWallet;
use App\SupportAttachment;
use App\SupportMessage;
use App\SupportTicket;
use App\TimeSetting;
use App\Trx;
use App\User;
use App\UserWallet;
use App\Withdrawal;
use App\WithdrawMethod;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Image;
use File;
use Validator;
use Session;


class UserController extends Controller
{

    public function home()
    {
        $data['totalInvest'] = Invest::where('user_id', auth()->id())->sum('amount');
        $data['authWallets'] = UserWallet::where('user_id', auth()->id())->get();
        $data['savingsWallets'] = SavingsWallet::where('user_id', auth()->id())->get();
        $data['totalWithdraw'] = Withdrawal::where('user_id', Auth::id())->whereIn('status', [0, 1])->sum('amount');
        $data['totalDeposit'] = Deposit::where('user_id', Auth::id())->where('status', 1)->sum('amount');
        $data['totalTicket'] = SupportTicket::where('user_id', Auth::id())->count();
        $data['loan'] = DB::select("SELECT * FROM loan_table WHERE user_id = ? AND  status = ?", [Auth::user()->id, 1])[0]->payback_amount??"";
        $page_title = 'Dashboard';


        $collection['day'] = collect([]);
        $collection['trx'] = collect([]);
        Trx::where('user_id', Auth::id())
            ->where('created_at', '>', Carbon::now()->subDays(7))
            ->selectRaw('SUM((CASE WHEN type = "+" THEN amount  END)) as totalTransaction ')
            ->selectRaw("DATE_FORMAT(created_at, '%W') day")
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get()->map(function ($v, $key) use ($collection){
                if ($v->totalTransaction == null) {
                    $collection['trx']->push(round($v->totalTransaction, 2));
                }else{
                    $collection['trx']->push(round($v->totalTransaction, 2));
                }
                $collection['day']->push($v->day);
                return $collection;
            });
        return view(activeTemplate() . 'user.dashboard', compact('page_title','collection'), $data);
    }


    public function depositHistory()
    {
        $page_title = 'Deposit History';
        $empty_message = 'No history found.';
        $deposits = Deposit::with('gateway')->where('user_id', Auth::id())->where('status', '!=', 0)->latest()->paginate(20);
        return view(activeTemplate() . 'user.deposit_history', compact('page_title', 'empty_message', 'deposits'));
    }

    public function transferHistory(Request $request)
    {
        $pagination = new Pagination($request);
        $page_title = 'Transfer History';
        $empty_message = 'No history found.';

        $sql = "SELECT * FROM transfer WHERE user_id = ? OR reciever_id = ? AND status != ? ORDER BY created_on DESC LIMIT ?";
        $data = [Auth::id(), Auth::id(), 0, 20];
        if (isset($request->page) && $request->page > 1){
            $sql = "SELECT * FROM transfer WHERE user_id = ? OR reciever_id = ? AND status != ? ORDER BY created_on DESC LIMIT ? OFFSET ?";
            $data = [Auth::id(), Auth::id(), 0, 20, ($request->page*20)+1];
        }

        $transfers = DB::select($sql, $data);
        return view(activeTemplate() . 'user.transfer_history', compact('page_title', 'empty_message', 'transfers', 'pagination'));
    }


    public function transactions()
    {
        $page_title = 'Transactions';
        $logs = auth()->user()->transactions()->latest()->paginate(config('constants.table.default'));
        $empty_message = 'No transaction history';
        return view(activeTemplate() . 'user.transactions', compact('page_title', 'logs', 'empty_message'));
    }


    public function editProfile()
    {
        $data['page_title'] = "Edit Profile";
        $data['user'] = User::findOrFail(Auth::id());
        return view(activeTemplate() . 'user.edit-profile', $data);
    }

    public function submitProfile(Request $request)
    {
        $user = User::findOrFail(Auth::id());
        $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'email' => "sometimes|required|string|email|max:255|unique:users,email,".$user->id,
            'mobile' => "sometimes|required|unique:users,mobile,".$user->id,
            'address' => "required|max:80",
            'state' => 'required|max:80',
            'zip' => 'required|max:40',
            'city' => 'required|max:50',
            'country' => 'required|string|max:50',
            'image' => 'mimes:png,jpg,jpeg'
        ],[
            'firstname.required'=>'First Name Field is required',
            'lastname.required'=>'Last Name Field is required'
        ]);


        $in['firstname'] = $request->firstname;
        $in['lastname'] = $request->lastname;
        $in['email'] = $request->email;
        $in['mobile'] = str_replace('-', '', $request->mobile);

        $in['address'] = [
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => $request->country,
            'city' => $request->city,
        ];


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $user->username . '.jpg';
            $location = 'assets/images/user/profile/' . $filename;
            $in['image'] = $filename;

            $path = './assets/images/user/profile/';
            $link = $path . $user->image;
            if (file_exists($link)) {
                @unlink($link);
            }
            Image::make($image)->save($location);
        }
        $user->fill($in)->save();
        $notify[] = ['success', 'Profile Updated successfully.'];
        return back()->withNotify($notify);
    }


    public function changePassword()
    {
        $data['page_title'] = "CHANGE PASSWORD";
        return view(activeTemplate() . 'user.password', $data);
    }

    public function submitPassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:5|confirmed'
        ]);
        try {

            $c_password = Auth::user()->password;
            $c_id = Auth::user()->id;
            $user = User::findOrFail($c_id);
            if (Hash::check($request->current_password, $c_password)) {

                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();

                $notify[] = ['success', 'Password Changes successfully.'];
                return back()->withNotify($notify);

            } else {
                $notify[] = ['error', 'Current password not match.'];
                return back()->withNotify($notify);
            }

        } catch (\PDOException $e) {
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }
    }


    public function twoFactorAuth()
    {
        $gnl = GeneralSetting::first();
        $ga = new GoogleAuthenticator();
        $page_title = "Google 2Fa Security";
        $secret = $ga->createSecret();

        $qrCodeUrl = $ga->getQRCodeGoogleUrl(Auth::user()->username . '@' . $gnl->sitename, $secret);
        $prevcode = Auth::user()->tsc;
        $prevqr = $ga->getQRCodeGoogleUrl(Auth::user()->username . '@' . $gnl->sitename, $prevcode);

        return view(activeTemplate() . 'user.goauth.create', compact('secret', 'qrCodeUrl', 'prevcode', 'prevqr', 'page_title'));
    }

    public function create2fa(Request $request)
    {
        $user = User::find(Auth::id());
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);
        $ga = new GoogleAuthenticator();
        $secret = $request->key;
        $oneCode = $ga->getCode($secret);

        $userCode = $request->code;
        if ($oneCode == $userCode) {
            $user['tsc'] = $request->key;
            $user['ts'] = 1;
            $user['tv'] = 1;
            $user->save();

            $info = json_decode(json_encode(getIpInfo()), true);

            notify($user, $type = '2fa', [
                'action' => 'Enabled',
                'ip' => request()->ip(),
                'browser' => $info['browser'],
                'time' => date('d M, Y h:i:s A'),
            ]);
            $notify[] = ['success', 'Google Authenticator Enabled Successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong Verification Code'];
            return back()->withNotify($notify);
        }

    }


    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user = User::find(Auth::id());
        $ga = new GoogleAuthenticator();

        $secret = $user->tsc;
        $oneCode = $ga->getCode($secret);
        $userCode = $request->code;

        if ($oneCode == $userCode) {
            $user = User::find(Auth::id());
            $user['ts'] = 0;
            $user['tv'] = 1;
            $user['tsc'] = null;
            $user->save();


            $info = json_decode(json_encode(getIpInfo()), true);
            notify($user, $type = '2fa', [
                'action' => 'Disabled',
                'ip' => request()->ip(),
                'browser' => $info['browser'],
                'time' => date('d M, Y h:i:s A')
            ]);
            $notify[] = ['success', 'Two Factor Authenticator Disable Successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong Verification Code'];
            return back()->withNotify($notify);
        }

    }


    // Support Ticket
    public function supportTicket()
    {
        $page_title = "Support Tickets";
        $supports = SupportTicket::where('user_id', Auth::id())->latest()->paginate(15);
        return view(activeTemplate() . 'user.support.supportTicket', compact('supports', 'page_title'));
    }

    public function openSupportTicket()
    {
        $page_title = "Support Tickets";
        $user = Auth::user();
        $topics = ContactTopic::all();
        return view(activeTemplate() . 'user.support.sendSupportTicket', compact('page_title', 'user', 'topics'));
    }

    public function storeSupportTicket(Request $request)
    {
        $ticket = new SupportTicket();
        $message = new SupportMessage();

        $imgs = $request->file('attachments');
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf');

        $validator = $this->validate($request, [
            'attachments' => [
                'max:4096',
                function ($attribute, $value, $fail) use ($imgs, $allowedExts) {
                    foreach ($imgs as $img) {
                        $ext = strtolower($img->getClientOriginalExtension());
                        if (($img->getClientSize() / 1000000) > 2) {
                            return $fail("Images MAX  2MB ALLOW!");
                        }
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg, pdf images are allowed");
                        }
                    }
                    if (count($imgs) > 5) {
                        return $fail("Maximum 5 images can be uploaded");
                    }
                },
            ],
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'subject' => 'required|max:100',
            'department' => 'required',
            'priority' => 'required',
            'message' => 'required',
        ]);

        $department = ContactTopic::findOrFail($request->department);

        $ticket->user_id = Auth::id();
        $random = rand(100000, 999999);

        $ticket->ticket = 'S-' . $random;
        $ticket->name = Auth::user()->fullname;
        $ticket->email = Auth::user()->email;
        $ticket->subject = $request->subject;
        $ticket->department = $department->name;
        $ticket->priority = $request->priority;
        $ticket->status = 0;
        $ticket->save();

        $message->supportticket_id = $ticket->id;
        $message->type = 1;
        $message->message = $request->message;
        $message->save();


        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $image) {
                $filename = rand(1000, 9999) . time() . '.' . $image->getClientOriginalExtension();
                $image->move('assets/images/support', $filename);
                SupportAttachment::create([
                    'support_message_id' => $message->id,
                    'image' => $filename,
                ]);
            }
        }
        $notify[] = ['success', 'ticket created successfully!'];
        return back()->withNotify($notify);
    }

    public function supportMessage($ticket)
    {
        $page_title = "Support Tickets";
        $my_ticket = SupportTicket::where('ticket', $ticket)->latest()->first();
        $messages = SupportMessage::where('supportticket_id', $my_ticket->id)->latest()->get();
        $user = Auth::user();
        $topics = ContactTopic::all();
        if ($my_ticket->user_id == Auth::id()) {
            return view(activeTemplate() . 'user.support.supportMessage', compact('my_ticket', 'messages', 'page_title', 'user', 'topics'));
        } else {
            return abort(404);
        }

    }

    public function supportMessageStore(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);
        $message = new SupportMessage();
        if ($ticket->status != 3) {

            if ($request->replayTicket == 1) {
                $imgs = $request->file('attachments');
                $allowedExts = array('jpg', 'png', 'jpeg', 'pdf');

                $this->validate($request, [
                    'attachments' => [
                        'max:4096',
                        function ($attribute, $value, $fail) use ($imgs, $allowedExts) {
                            foreach ($imgs as $img) {
                                $ext = strtolower($img->getClientOriginalExtension());
                                if (($img->getClientSize() / 1000000) > 2) {
                                    return $fail("Images MAX  2MB ALLOW!");
                                }
                                if (!in_array($ext, $allowedExts)) {
                                    return $fail("Only png, jpg, jpeg, pdf images are allowed");
                                }
                            }
                            if (count($imgs) > 5) {
                                return $fail("Maximum 5 images can be uploaded");
                            }
                        },
                    ],
                    'message' => 'required',
                ]);

                $ticket->status = 2;
                $ticket->save();

                $message->supportticket_id = $ticket->id;
                $message->type = 1;
                $message->message = $request->message;
                $message->save();

                if ($request->hasFile('attachments')) {
                    foreach ($request->file('attachments') as $image) {
                        $filename = rand(1000, 9999) . time() . '.' . $image->getClientOriginalExtension();
                        $image->move('assets/images/support', $filename);
                        SupportAttachment::create([
                            'support_message_id' => $message->id,
                            'image' => $filename,
                        ]);
                    }
                }

                $notify[] = ['success', 'Support ticket replied successfully!'];
            } elseif ($request->replayTicket == 2) {
                $ticket->status = 3;
                $ticket->save();
                $notify[] = ['success', 'Support ticket closed successfully!'];
            }
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Support ticket already closed!'];
            return back()->withNotify($notify);
        }

    }

    public function ticketDownload($ticket_id)
    {
        $attachment = SupportAttachment::findOrFail(decrypt($ticket_id));
        $file = $attachment->image;
        $full_path = 'assets/images/support/' . $file;

        $title = str_slug($attachment->supportMessage->ticket->subject);
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $mimetype = mime_content_type($full_path);


        header('Content-Disposition: attachment; filename="' . $title . '.' . $ext . '";');
        header("Content-Type: " . $mimetype);
        return readfile($full_path);
    }

    public function ticketDelete(Request $request)
    {
        $message = SupportMessage::where('id', $request->message_id)->latest()->firstOrFail();

        if ($message->ticket->user_id != Auth::id()) {
            $notify[] = ['error', 'Unauthorized!'];
            return back()->withNotify($notify);
        }

        if ($message->attachments()->count() > 0) {
            foreach ($message->attachments as $img) {
                @unlink('assets/images/support/' . $img->image);
                $img->delete();
            }
        }
        $message->delete();

        $notify[] = ['success', 'Delete successfully.'];
        return back()->withNotify($notify);
    }


    public function withdrawMoney()
    {
        $data['withdrawMethod'] = WithdrawMethod::whereStatus(1)->get();
        $data['page_title'] = "Withdraw Money";
        return view(activeTemplate() . 'user.withdraw.money', $data);
    }


    public function withdrawMoneyRequest(Request $request)
    {
        $this->validate($request, [
            'method_code' => 'required',
            'amount' => 'required|numeric'
        ]);
        $method = WithdrawMethod::where('id', $request->method_code)->where('status', 1)->firstOrFail();
        $authWallet = UserWallet::where('type', 'interest_wallet')->where('user_id', Auth::id())->first();

        $charge = $method->fixed_charge + ($request->amount * $method->percent_charge / 100);

        $finalAmo = $request->amount - $charge;

        $youGet = $finalAmo * $method->rate;


        if ($request->amount < $method->min_limit) {
            $notify[] = ['error', 'Your Request Amount is Smaller Then Withdraw Minimum Amount.'];
            return back()->withNotify($notify);
        }
        if ($request->amount > $method->max_limit) {
            $notify[] = ['error', 'Your Request Amount is Larger Then Withdraw Maximum Amount.'];
            return back()->withNotify($notify);
        }

        if (formatter_money($request->amount + $charge) > $authWallet->balance) {
            $notify[] = ['error', 'Your have Insufficient Balance For Withdraw.'];
            return back()->withNotify($notify);
        } else {

            $w['method_id'] = $method->id; // wallet method ID
            $w['user_id'] = Auth::id();
            $w['wallet_id'] = $authWallet->id; // User Wallet ID
            $w['amount'] = formatter_money($request->amount);
            $w['currency'] = $method->currency;
            $w['rate'] = $method->rate;
            $w['charge'] = $charge;
            $w['final_amount'] = $youGet;
            $w['delay'] = $method->delay;

            $multiInput = [];
            if ($method->user_data != null) {
                foreach ($method->user_data as $k => $val) {
                    $multiInput[str_replace(' ', '_', $val)] = null;
                }
            }
            $w['detail'] = json_encode($multiInput);
            $w['trx'] = getTrx();
            $w['status'] = -1;
            $result = Withdrawal::create($w);

            Session::put('wtrx', $result->trx);
            return redirect()->route('user.withdraw.preview');
        }
    }

    public function withdrawReqPreview()
    {

        $withdraw = Withdrawal::with('method', 'wallet')->where('trx', Session::get('wtrx'))->where('status', -1)->latest()->firstOrFail();
        $data['page_title'] = "Withdraw Preview";
        $data['withdraw'] = $withdraw;
        return view(activeTemplate() . 'user.withdraw.preview', $data);
    }


    public function withdrawReqSubmit(Request $request)
    {
        $general = GeneralSetting::first();
        $withdraw = Withdrawal::with('method', 'wallet')->where('trx', Session::get('wtrx'))->where('status', -1)->latest()->firstOrFail();

        $customField = [];
        foreach (json_decode($withdraw->detail) as $k => $val) {
            $customField[$k] = ['required'];
        }

        $validator = Validator::make($request->all(), $customField);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $in = $request->except('_token', 'verify_image');
        $multiInput = [];
        foreach ($in as $k => $val) {
            $multiInput[$k] = $val;
        }

        $authWallet = UserWallet::find($withdraw->wallet_id);

        if (formatter_money($withdraw->amount + $withdraw->charge) > $authWallet->balance) {
            $notify[] = ['error', 'Your Request Amount is Larger Then Your Current Balance.'];
            return back()->withNotify($notify);
        } else {


            if ($request->hasFile('verify_image')) {
                try {
                    $filename = upload_image($request->verify_image, config('constants.deposit.verify.path'));
                    $withdraw->verify_image = $filename;
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Could not upload your File'];
                    return back()->withNotify($notify)->withInput();
                }
            }

            $withdraw->detail = json_encode($multiInput);
            $withdraw->status = 0;
            $withdraw->save();

            $authWallet->balance = formatter_money($authWallet->balance - ($withdraw->amount + $withdraw->charge));
            $authWallet->update();

            Trx::create([
                'user_id' => $authWallet->user_id,
                'amount' => $withdraw->amount,
                'main_amo' => $authWallet->balance,
                'charge' => $withdraw->charge,
                'type' => '-',
                'remark' => 'withdraw',
                'title' => formatter_money($withdraw->final_amount) . ' ' . $withdraw->currency . ' Withdraw Via ' . $withdraw->method->name,
                'trx' => $withdraw->trx
            ]);


            notify($authWallet->user, $type = 'WITHDRAW_REQUEST', [
                'amount' => formatter_money($withdraw->amount),
                'currency' => $general->cur_text,
                'withdraw_method' => $withdraw->method->name,
                'method_amount' => formatter_money($withdraw->final_amount),
                'method_currency' => $withdraw->currency,
                'duration' => $withdraw->delay,
                'trx' => $withdraw->trx,
            ]);

            $notify[] = ['success', 'Withdraw Request Successfully Send'];
            return redirect()->route('user.withdraw.money')->withNotify($notify);

        }
    }

    public function withdrawLog()
    {

        $data['page_title'] = "Withdraw Log";
        $data['withdraws'] = Withdrawal::where('user_id', Auth::id())->where('status', '!=', -1)->latest()->paginate(20);
        return view(activeTemplate() . 'user.withdraw.log', $data);
    }


    public function buyPlan(Request $request)
    {

        $request->validate([
            'amount' => 'required|min:0',
            'plan_id' => 'required',
            'wallet_type' => 'required',
        ]);


        $user = User::find(Auth::id());
        $gnl = GeneralSetting::first();

        $userWallet = UserWallet::where('user_id', Auth::id())->where('id', $request->wallet_type)->first();
        if (!$userWallet) {
            $notify[] = ['error', 'Invalid Wallet!'];
            return back()->withNotify($notify);
        }
        $plan = Plan::where('id', $request->plan_id)->where('status', 1)->first();
        if (!$plan) {
            $notify[] = ['error', 'Invalid Plan!'];
            return back()->withNotify($notify);
        }

        if ($plan->fixed_amount == '0') {
            if ($request->amount < $plan->minimum) {
                $notify[] = ['error', 'Minimum Invest ' . formatter_money($plan->minimum) . ' ' . $gnl->cur_text];
                return back()->withNotify($notify);
            }

            if ($request->amount > $plan->maximum) {
                $notify[] = ['error', 'Maximum Invest ' . formatter_money($plan->maximum) . ' ' . $gnl->cur_text];
                return back()->withNotify($notify);
            }
        } else {

            if ($request->amount != $plan->fixed_amount) {
                $notify[] = ['error', 'Please Invest must ' . formatter_money($plan->fixed_amount) . ' ' . $gnl->cur_text];
                return back()->withNotify($notify);
            }
        }

        if ($request->amount > $userWallet->balance) {
            $notify[] = ['error', 'Insufficient Balance'];
            return back()->withNotify($notify);
        }

        $time_name = TimeSetting::where('time', $plan->times)->first();
        $now = Carbon::now();

        $new_balance = formatter_money($userWallet->balance - $request->amount);
        $userWallet->balance = $new_balance;
        $userWallet->save();

        Trx::create([
            'user_id' => $user->id,
            'amount' => formatter_money($request->amount),
            'main_amo' => formatter_money($userWallet->balance, config('constants.currency.base')),
            'charge' => 0,
            'type' => '-',
            'remark' => 'invest',
            'title' => 'Invested On ' . $plan->name,
            'trx' => getTrx(),
        ]);

        //start
        if ($plan->interest_status == 1) {
            $interest_amount = ($request->amount * $plan->interest) / 100;
        } else {
            $interest_amount = $plan->interest;
        }
        $period = ($plan->lifetime_status == 1) ? '-1' : $plan->repeat_time;
        //end

        if ($plan->fixed_amount == 0) {

            if ($plan->minimum <= $request->amount && $plan->maximum >= $request->amount) {
                $invest['user_id'] = $user->id;
                $invest['plan_id'] = $plan->id;
                $invest['amount'] = $request->amount;
                $invest['interest'] = $interest_amount;
                $invest['period'] = $period;
                $invest['time_name'] = $time_name->name;
                $invest['hours'] = $plan->times;
                $invest['next_time'] = Carbon::parse($now)->addHours($plan->times);
                $invest['status'] = 1;
                $invest['capital_status'] = $plan->capital_back_status;
                $invest['trx'] = getTrx();
                $a = Invest::create($invest);

                if ($gnl->invest_commission == 1) {
                    $commissionType = formatter_money($request->amount) . ' ' . $gnl->cur_text . ' Invest for ' . $plan->name;
                    levelCommision($user->id, $request->amount, $commissionType);
                }

                notify($user, $type = 'INVESTMENT_PURCHASE', [
                    'trx' => $a->trx,
                    'amount' => formatter_money($request->amount),
                    'currency' => $gnl->cur_text,
                    'interest_amount' => $interest_amount,
                ]);


                $notify[] = ['success', 'Invested Successfully'];
                return redirect()->route('user.interest.log')->withNotify($notify);
            }
            $notify[] = ['error', 'Invalid Amount'];
            return back()->withNotify($notify);

        } else {
            if ($plan->fixed_amount == $request->amount) {

                $data['user_id'] = $user->id;
                $data['plan_id'] = $plan->id;
                $data['amount'] = $request->amount;
                $data['interest'] = $interest_amount;
                $data['period'] = $period;
                $data['time_name'] = $time_name->name;
                $data['hours'] = $plan->times;
                $data['next_time'] = Carbon::parse($now)->addHours($plan->times);
                $data['status'] = 1;
                $data['capital_status'] = $plan->capital_back_status;
                $data['trx'] = getTrx();
                $a = Invest::create($data);

                if ($gnl->invest_commission == 1) {
                    $commissionType = formatter_money($request->amount) . ' ' . $gnl->cur_text . ' Invest for ' . $plan->name;
                    levelCommision($user->id, $request->amount, $commissionType);
                }


                notify($user, $type = 'INVESTMENT_PURCHASE', [
                    'trx' => $a->trx,
                    'amount' => formatter_money($request->amount),
                    'currency' => $gnl->cur_text,
                    'interest_amount' => $interest_amount,
                ]);

                $user->save();
                $notify[] = ['success', 'Package Purchased Successfully Complete'];
                return redirect()->route('user.interest.log')->withNotify($notify);
            }

            $notify[] = ['error', 'Something Went Wrong'];
            return back()->withNotify($notify);
        }


    }

    public function startSavings()
    {

    }


    public function interestLog()
    {
        $page_title = 'Interest Log';
        $trans = Invest::where('user_id', Auth::id())->latest()->paginate(15);
        return view(activeTemplate() . 'user.interest_log', compact('page_title', 'trans'));
    }

    public function refMy()
    {
        $page_title = "My Referral";

        $trans = CommissionLog::with('user', 'bywho')->where('user_id', Auth::id())->latest()->paginate(15);
        return view(activeTemplate() . 'user.my_referral', compact('page_title', 'trans'));


    }

    public function loanRequest()
    {
        $page_title = "Loan Request";
        return view(activeTemplate(). "user.loan.loan", compact('page_title'));
    }

    public function loanPayback()
    {
        $page_title = "Loan Payback";
        $user = Auth::user()->id;
        $loan = DB::select("SELECT * FROM loan_table WHERE user_id = ? AND status = ?", [$user, 1])[0]??[];
        $wallets = DB::select("SELECT *  FROM user_wallets WHERE user_id = ?", [$user]);
        return view(activeTemplate(). "user.loan.payback", compact('page_title', 'loan', 'wallets'));
    }

    public function loanPaybackPost(Request $request)
    {
        $user = Auth::user()->id;
        $loan = DB::select("SELECT * FROM loan_table WHERE user_id = ? AND status = ?", [$user, 1])[0]??[];
        if (empty($loan))
        {
            $notify[] = ['error', 'You are not owing'];
            return back()->withNotify($notify??[]);
        }

        switch ($request){
            case ($request->wallet == 'deposit'):
                $wallet = DB::select("SELECT *  FROM user_wallets WHERE user_id = ? AND type =? ", [$user, "deposit_wallet"])[0];
                if ($loan->payback_amount > $wallet->balance)
                {
                    //the amount you owe is greater than wallet balance
                    $sql = "UPDATE loan_table SET payback_amount = ? WHERE user_id = ? AND status = ?";
                    if (DB::update($sql, [$loan->payback_amount-$wallet->balance, $user, 1]))
                    {
                        $sql = "UPDATE user_wallets SET balance = ? WHERE user_id = ? AND type = ?";
                        if (DB::update($sql, [0, $user, "deposit_wallet"]))
                        {
                            $notify[] = ['success', 'Loan payback was successful'];
                        }
                    }
                }
                else
                {
                    //the amount you owe is less than wallet balance
                    $sql = "UPDATE loan_table SET payback_amount = ?, status = ? WHERE user_id = ? AND loan_id = ?";
                    if (DB::update($sql, [0, 3, $user, $loan->loan_id]))
                    {
                        $sql = "UPDATE user_wallets SET balance = ? WHERE user_id = ? AND type = ?";
                        if (DB::update($sql, [$wallet->balance-$loan->payback_amount, $user, "deposit_wallet"]))
                        {
                            $notify[] = ['success', 'Loan payback was successful'];
                        }
                    }
                }
            break;
            case ($request->wallet == 'interest'):
                $wallet = DB::select("SELECT *  FROM user_wallets WHERE user_id = ? AND type =? ", [$user, "interest_wallet"])[0];
                if ($loan->payback_amount > $wallet->balance)
                {
                    //the amount you owe is greater than wallet balance
                    $sql = "UPDATE loan_table SET payback_amount = ? WHERE user_id = ? AND status = ?";
                    if (DB::update($sql, [$loan->payback_amount-$wallet->balance, $user, 1]))
                    {
                        $sql = "UPDATE user_wallets SET balance = ? WHERE user_id = ? AND type = ?";
                        if (DB::update($sql, [0, $user, "interest_wallet"]))
                        {
                            $notify[] = ['success', 'Loan payback was successful'];
                        }
                    }
                }
                else
                {
                    //the amount you owe is less than wallet balance
                    $sql = "UPDATE loan_table SET payback_amount = ?, status = ? WHERE user_id = ? AND loan_id = ?";
                    if (DB::update($sql, [0, 3, $user, $loan->loan_id]))
                    {
                        $sql = "UPDATE user_wallets SET balance = ? WHERE user_id = ? AND type = ?";
                        if (DB::update($sql, [$wallet->balance-$loan->payback_amount, $user, "interest_wallet"]))
                        {
                            $notify[] = ['success', 'Loan payback was successful'];
                        }
                    }
                }
            break;
            default:
                $notify[] = ['error', 'An error occurred in carrying out this request'];
            break;
        }
        return back()->withNotify($notify??[]);
    }

    public function loanRequestAdd(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'amount' => 'required',
            'duration' => 'required',
            'reason' => 'required',
        ]);
        $loan = DB::select("SELECT * FROM loan_table WHERE user_id = ? AND status = ? OR status = ?", [$user->id, 1, 0]);

        if (!empty($loan))
        {
            $loan = $loan[0];

            if ($loan->status == 1)
            {
                $notify[] = ['error', 'You have an approved loan request'];
            }

            if ($loan->status == 0)
            {
                $notify[] = ['error', 'You have a pending loan request'];
            }
            return back()->withNotify($notify);
        }

        $loan_id = strtoupper(bin2hex(random_bytes(6)));
        if (!is_null(DB::select("SELECT * FROM loan_table WHERE loan_id = ?", [$loan_id])))
        {
            $loan_id = strtoupper(bin2hex(random_bytes(5)));
        }
        $data = [
            $loan_id,
            $user->id,
            $request->amount,
            $request->duration,
            $request->reason,
        ];

        if (DB::insert("INSERT INTO loan_table (loan_id, user_id, request_amount, request_duration, request_reason) VALUES (?, ?, ?, ?,?)", $data))
        {
            $notify[] = ['success', 'Loan request placed successfully'];
            return back()->withNotify($notify);
        }
        $notify[] = ['error', 'An error occurred in carrying out this request'];
        return back()->withNotify($notify);
    }

    public function LoanHistory(Request $request)
    {
        $page_title = 'Loan History';
        $pagination = new Pagination($request);
        $empty_message = 'No history found.';
        $sql = "SELECT * FROM loan_table WHERE user_id = ? LIMIT ?";
        $data = [
            Auth::id(),
            20
        ];
        if (isset($request->page) && $request->page > 1){
            $sql = "SELECT * FROM loan_table WHERE user_id = ? LIMIT ? OFFSET ?";
            $data = [
                Auth::id(),
                20,
                ($request->page+20)+1
            ];
        }

        $loans = DB::select($sql, $data);
        return view(activeTemplate() . 'user.loan.history', compact('page_title', 'empty_message', 'loans', 'pagination'));
    }
}
