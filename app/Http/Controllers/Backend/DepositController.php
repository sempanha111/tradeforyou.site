<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Earning;
use App\Models\History;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdraw;
use App\Services\GeneralService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    protected $generalService;


    public function __construct(GeneralService $generalService)
    {
        $this->generalService = $generalService;
    }
    public function deposit()
    {

        $deposits = Deposit::WhereNull('on_delete')->orderBy('id', 'desc')->get();
        return view('Backend.deposit', compact('deposits'));
    }
    public function approved($id)
    {
        $deposit = Deposit::Where('id', $id)->first();

        $plan = $deposit->plan;
        $request_deposit_amount = $deposit->amount;
        $money = $deposit->money;
        $user_id = $deposit->user_id;
        $transaction_id = $deposit->transaction_id;
        $payer_account = $deposit->payer_account;


        $transaction = Transaction::Where('transaction_id', $transaction_id)->first();
        $transaction->update([
            'status' => 'Success',
        ]);

        $deposit->delete();

        $this->generalService->Deposit_Success(
            $plan,
            $request_deposit_amount,
            $money,
            null, // satoshis
            $user_id,
            $transaction_id,
            $payer_account
        );


        return redirect()->back()->with('success', 'You has Approve Deposit Successfully');
    }
    public function pending($id)
    {
        try {
            $deposit = Deposit::find($id);
            if ($deposit) {

                $deposit->update([
                    'status' => 'Pending'
                ]);
                return redirect()->back()->with('success', "You has add Pending successfully.");
            }
        } catch (\Exception $e) {
            // Handle general exceptions
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }
    public function delete_deposit($id)
    {
        $deposit = Deposit::find($id);
        $deposit->update([
            'on_delete' => 1
        ]);
        return redirect()->back()->with('success', 'You Delete Deposit Successfully');
    }

}
