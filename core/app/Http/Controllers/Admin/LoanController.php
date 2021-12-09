<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function loanPending()
    {
        $page_title = 'Loans Pending';
        $empty_message = 'No history found.';
        $sql = "SELECT * FROM loan_table WHERE status = ?";
        $loans = DB::select($sql, [0]);
        return view('admin.loan.pending', compact('page_title', 'empty_message', 'loans'));
    }

    public function loanActive()
    {
        $page_title = 'Loans Active';
        $empty_message = 'No history found.';
        $sql = "SELECT * FROM loan_table WHERE status = ?";
        $loans = DB::select($sql, [1]);
        return view('admin.loan.active', compact('page_title', 'empty_message', 'loans'));
    }

    public function loanRejected()
    {
        $page_title = 'Loans Rejected';
        $empty_message = 'No history found.';
        $sql = "SELECT * FROM loan_table WHERE status = ?";
        $loans = DB::select($sql, [2]);
        return view('admin.loan.rejected', compact('page_title', 'empty_message', 'loans'));
    }

    public function loanManage()
    {
        $page_title = 'Loans Management';
        $empty_message = 'No history found.';
        $sql = "SELECT * FROM loan_table";
        $loans = DB::select($sql);
        return view('admin.loan.manage', compact('page_title', 'empty_message', 'loans'));
    }

    public function loanInterest()
    {
        $page_title = 'Loans Interest';
        $empty_message = 'No history found.';
        $sql = "SELECT * FROM loan_interest ORDER BY days ASC ";
        $interest = DB::select($sql);
        return view('admin.loan.interest', compact('page_title', 'empty_message', 'interest'));
    }

    public function loanInterestAdd(Request $request)
    {
        //$notify[] = ['error', 'An error occurred in carrying out this request'];
        switch ($request){
            case (isset($request->delete)):
                $sql = "DELETE FROM loan_interest WHERE id = ?";
                if (DB::delete($sql, [$request->id]))
                {
                    $notify[] = ['success', 'Action was successful'];
                }
            break;
            case (isset($request->update)):
                $sql = "UPDATE loan_interest SET name = ?, days = ?, interest = ? WHERE id = ?";
                if (DB::update($sql, [$request->name, $request->time, $request->interest, $request->id]))
                {
                    $notify[] = ['success', 'Action was successful'];
                }
            break;
            case (isset($request->save)):
                $sql = "INSERT INTO loan_interest(name, days, interest) VALUES (?, ?, ?)";
                if (DB::insert($sql, [$request->name, $request->time, $request->interest]))
                {
                    $notify[] = ['success', 'Action was successful'];
                }
            break;
            default:
                $notify[] = ['error', 'An error occurred in carrying out this request'];
            break;
        }
        return back()->withNotify($notify??[]);
    }
    public function loanPendingAdd(Request $request)
    {
        $request->validate([
            'approved_amount'=>'required',
            'loan_id'=>'required'
        ]);

        if (isset($request->reject))
        {
            DB::update("UPDATE loan_table SET status = ? WHERE loan_id = ?", [2, $request->loan_id]);

            $notify[] = ['success', 'You have successfully declined this loan request'];
            return back()->withNotify($notify);
        }

        //get loan details
        $loan = DB::select("SELECT * FROM loan_table WHERE loan_id = ?", [$request->loan_id])[0];
        $duration = DB::select("SELECT * FROM loan_interest WHERE days = ?", [$loan->request_duration])[0];

        if (empty($duration))
        {
            $notify[] = ['error', 'An error occurred in carrying out this request'];
            return back()->withNotify($notify);
        }
        $__payback_amount = $request->approved_amount + ($request->approved_amount * ($duration->interest/100));

        $data = [
            $request->approved_amount,
            date("Y-m-d H:i:s"),
            $__payback_amount,
            date("Y-m-d H:i:s", strtotime($duration->days.' days')),
            1,
            $request->loan_id
        ];

        //update the loan table
        if (DB::update("UPDATE loan_table SET approved_amount = ?, approved_date = ?, payback_amount = ?, payback_date = ?, status = ? WHERE loan_id =?", $data))
        {
            //credit the user
            $balance = DB::select("SELECT * FROM user_wallets WHERE user_id = ? AND type = ?", [$loan->user_id, "deposit_wallet"])[0]->balance;
            $balance = $balance + $request->approved_amount;

            $sql = "UPDATE user_wallets SET balance = ?, updated_at = ? WHERE user_id = ? AND type = ?";

            if (DB::update($sql, [$balance, date("Y-m-d H:i:s"), $loan->user_id, "deposit_wallet"]))
            {
                $notify[] = ['success', 'Loan request approved successfully'];
                return back()->withNotify($notify);
            }
        }

        $notify[] = ['error', 'An error occurred in carrying out this request'];
        return back()->withNotify($notify);
    }
}
