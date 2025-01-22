<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Earning;
use App\Models\History;
use App\Models\User;
use App\Models\Withdraw;
use App\Services\GeneralService;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    protected $generalService;



    public function __construct(GeneralService $generalService)
    {
        $this->generalService = $generalService;
    }


    public function index()
    {
        $releaseDate = new DateTime('2025-01-20'); // Replace with the release date
        $currentDate = new DateTime(); // Current date
        $interval = $releaseDate->diff($currentDate); // Calculate the difference
        $days = $interval->days; // Get the total number of days


        $deposits = Deposit::all();
        $withdraws = Withdraw::all();


        $total_member = User::Where('role', 'customer')->count();

        $total_deposit = number_format($deposits->sum('amount'), 2);

        $total_withdraw = number_format($withdraws->sum('withdraw_request'), 2);


        $deposits = Deposit::orderBy('id', 'desc')->limit(10)->get();
        $withdrawals = Withdraw::orderBy('id', 'desc')->limit(10)->get();



        $depositData = $deposits->map(function ($deposit) {
            return [
                'image' => 'assets_backend/images/small_crypto/' . strtolower($deposit->money) . '.gif',
                'amount' => $deposit->amount,
                'username' => $deposit->user->name,
                'date' => $deposit->created_at->format('M-d-y H:i:s')
            ];
        });

        $withdrawalData = $withdrawals->map(function ($withdrawal) {
            return [
                'image' => 'assets_backend/images/small_crypto/' . strtolower($withdrawal->money) . '.gif',
                'amount' => $withdrawal->withdraw_request,
                'username' => $withdrawal->user->name,
                'date' => $withdrawal->created_at->format('M-d-y H:i:s')
            ];
        });



        return view('Frontend/index', compact('days', 'total_member', 'total_deposit', 'total_withdraw',  'depositData', 'withdrawalData'))->render();
    }

    public function getLastTransactions()
    {

        $deposits = Deposit::orderBy('id', 'desc')->limit(10)->get();
        $withdrawals = Withdraw::orderBy('id', 'desc')->limit(10)->get();

        $depositData = $deposits->map(function ($deposit) {
            return [
                'image' => 'assets_backend/images/small_crypto/' . strtolower($deposit->money) . '.gif',
                'amount' => $deposit->amount,
                'username' => $deposit->user->name,
                'date' => $deposit->created_at->format('M-d-y H:i:s')
            ];
        });

        $withdrawalData = $withdrawals->map(function ($withdrawal) {
            return [
                'image' => 'assets_backend/images/small_crypto/' . strtolower($withdrawal->money) . '.gif',
                'amount' => $withdrawal->withdraw_request,
                'username' => $withdrawal->user->name,
                'date' => $withdrawal->created_at->format('M-d-y H:i:s')
            ];
        });




        $html = view('Frontend/layout/last_transactions', [
            'depositData' => $depositData,
            'withdrawalData' => $withdrawalData
        ])->render();

        return response()->json(['html' => $html]);
    }


    public function getLastStats(){

        $releaseDate = new DateTime('2024-09-08'); // Replace with the release date
        $currentDate = new DateTime(); // Current date
        $interval = $releaseDate->diff($currentDate); // Calculate the difference


        $deposits = Deposit::all();
        $withdraws = Withdraw::all();


        $days = $interval->days;

        $total_member = User::Where('role', 'customer')->count();

        $total_deposit = number_format($deposits->sum('amount'), 2);

        $total_withdraw = number_format($withdraws->sum('withdraw_request'), 2);

        $html = view('Frontend/layout/stats', [
            'days' => $days,
            'total_member' => $total_member,
            'total_deposit' => $total_deposit,
            'total_withdraw' => $total_withdraw,
        ])->render();

        return response()->json(['html' => $html]);
    }







    public function dashboard(Request $request)
    {

        $Auth_id = Auth::user()->id;
        $users = User::find($Auth_id);

        $deposits = $users->deposit;

        $percent = 0;

        foreach ($deposits as $deposit) {
            if ($deposit->plan == 1) {
                $percent = 130 / 100;
            } elseif ($deposit->plan == 2) {
                $percent = 175 / 100;
            } elseif ($deposit->plan == 3) {
                $percent = 200 / 100;
            } elseif ($deposit->plan == 4) {
                $percent = 245 / 100;
            } elseif ($deposit->plan == 5) {
                $percent = 375 / 100;
            } else {
                $percent = 0 / 100;
            }


            if ($deposit->start_plan != null) {

                $startPlan = Carbon::parse($deposit->start_plan);
                $currentDate = Carbon::now();

                $hoursDifference = $startPlan->diffInHours($currentDate);

                $investmentAmount = $deposit->amount;

                $profitRatePerHour = $percent / 72;


                if ($hoursDifference < 72) {

                    $earn = $users->earning->Where('deposit_id', $deposit->id)->first();

                    if ($earn) {
                        $update = Carbon::parse($earn->updated_at);
                    } else {
                        $update = Carbon::createFromFormat('Y-m-d H:i:s', '1900-01-01 00:00:00');
                    }

                    $current = Carbon::now();
                    $hoursdiff = $update->diffInHours($current);

                    if ($hoursdiff >= 3) {



                        $currentProfit = $investmentAmount * $profitRatePerHour * $hoursDifference;
                        $earnings = Earning::Where('deposit_id', $deposit->id)->first();
                        if ($earnings == null) {

                            Earning::create([
                                'user_id' => $Auth_id,
                                'deposit_id' => $deposit->id,
                                'money' => $deposit->money,
                                'profit' => $currentProfit,
                                'from' => $deposit->plan,
                            ]);
                        } else {
                            $earnings->update([
                                'profit' => $currentProfit,
                            ]);
                        }

                        $history = $users->history()->Where('deposit_id', $deposit->id)->latest()->first();
                        if ($history) {
                            $last_date = $history->created_at;
                        } else {
                            $last_date = $deposit->start_plan;
                        }

                        $last = Carbon::parse($last_date);
                        $hoursDif = $last->diffInHours($currentDate);


                        History::create([
                            'user_id' => $Auth_id,
                            'deposit_id' => $deposit->id,
                            'type' => 'Profit',
                            'money' => $deposit->money,
                            'from' => 'Plan' . $deposit->plan,
                            'deposit' => $deposit->amount,
                            'amount' => $investmentAmount * $profitRatePerHour * $hoursDif,
                        ]);
                    }
                }

                if ($hoursDifference >= 72) {

                    $earnings = Earning::Where('deposit_id', $deposit->id)->first();

                    if ($earnings == null) {

                        Earning::create([
                            'user_id' => $Auth_id,
                            'deposit_id' => $deposit->id,
                            'money' => $deposit->money,
                            'profit' => $investmentAmount * $percent,
                            'from' => $deposit->plan,
                        ]);
                    } else {
                        $earnings->update([
                            'profit' => $investmentAmount * $percent,
                        ]);
                    }



                    $history = $users->history->Where('type', 'Profit')->Where('from', 'Plan' . $deposit->plan)->last();

                    if ($history) {

                        $last_date = $history->created_at;



                        $last = Carbon::parse($last_date);
                        $hoursDif = $last->diffInHours($deposit->end_plan);


                        $profit_amount = $investmentAmount * $profitRatePerHour * $hoursDif;


                        if ($profit_amount > 0) {
                            History::create([
                                'user_id' => $Auth_id,
                                'type' => 'Profit',
                                'money' => $deposit->money,
                                'from' => 'Plan' . $deposit->plan,
                                'deposit' => $deposit->amount,
                                'amount' => $profit_amount,
                            ]);
                        }
                    } else {


                        History::create([
                            'user_id' => $Auth_id,
                            'type' => 'Profit',
                            'money' => $deposit->money,
                            'from' => 'Plan' . $deposit->plan,
                            'deposit' => $deposit->amount,
                            'amount' => $investmentAmount * $percent,
                        ]);
                    }
                }
            }
        }

        $account_balance = $this->generalService->Get_Account_Balance();

        $total_withdraw_success = $this->generalService->Get_Withdraw_All();

        $last_withdraw = $this->generalService->Get_Last_Withdraw();

        $deposit_summary = $this->generalService->Get_Deposit_Summary();

        $total_deposit_actives = $deposit_summary['total_deposit_actives'];

        $total_deposit = $deposit_summary['total_deposit'];

        $total_last_deposit = $this->generalService->Get_Last_Deposit();

        $earn_only = $this->generalService->Get_Earn_Only();

        return view('Frontend.dashboard', compact('earn_only', 'account_balance', 'total_withdraw_success', 'total_deposit_actives', 'total_deposit', 'total_last_deposit', 'last_withdraw'));
    }

    public function referrals()
    {
        $reffals = $this->generalService->Get_Referral();
        return view('Frontend.referallinks', compact('reffals'));
    }



}
