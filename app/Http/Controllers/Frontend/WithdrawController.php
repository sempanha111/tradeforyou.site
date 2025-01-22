<?php

namespace App\Http\Controllers\Frontend;

use App\Events\AlertDepositSuccessCrypto;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Withdraw;
use App\Services\GeneralService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WithdrawController extends Controller
{

    protected $generalService;

    public function __construct(GeneralService $generalService)
    {
        $this->generalService = $generalService;
    }


    public function withdraw()
    {

        $Auth_id = Auth::id();
        $users = User::find($Auth_id);

        $perfect_data = $this->generalService->getAmountPerWallet('Perfect Money');
        $payeer_data = $this->generalService->getAmountPerWallet('Payeer');
        $btc_data = $this->generalService->getAmountPerWallet('BTC');
        $ltc_data = $this->generalService->getAmountPerWallet('LTC');
        $bch_data = $this->generalService->getAmountPerWallet('BCH');
        $eth_data = $this->generalService->getAmountPerWallet('ETH');
        $usdt_bsc_bep20_data = $this->generalService->getAmountPerWallet('USDT-BSC(BEP20)');


        $account_balance = $this->generalService->Get_Account_Balance();

        $total_panding = $perfect_data['pending'] + $payeer_data['pending'] + $btc_data['pending'] + $ltc_data['pending'] + $bch_data['pending'] + $eth_data['pending'] + $usdt_bsc_bep20_data['pending'];


        return view('Frontend.withdraw', compact(
            'account_balance',
            'total_panding',
            'perfect_data',
            'payeer_data',
            'btc_data',
            'ltc_data',
            'bch_data',
            'eth_data',
            'usdt_bsc_bep20_data',
        ));
    }




    public function withdraw_send(Request $request)
    {

        try {
            if ($request->session()->has('Session_withdraws_confirm')) {

                $Session_withdraws_confirm = session('Session_withdraws_confirm');
                $wallet = $Session_withdraws_confirm['wallet'];
                $withdraw_request = $Session_withdraws_confirm['withdraw_request'];
                $amount_crypto = $Session_withdraws_confirm['amount_crypto'];

                // Clear the session after getting the data
                $request->session()->forget('Session_withdraws_confirm');
            } else {
                return redirect()->back()->with('error', 'Something went wrong with the withdrawal process. Please try again.');
            }

            // Create a new withdraw request in the database
            $withdraw = Withdraw::create([
                'user_id' => Auth::id(),
                'money' => $wallet,
                'withdraw_request' => $withdraw_request, // Make sure to serialize arrays/objects
                'amount_crypto' => $amount_crypto,
                'status' => 'Pending'
            ]);

            // Check if withdrawal was successfully created
            if ($withdraw) {
                event(new AlertDepositSuccessCrypto("Withdraw Success"));
                return redirect()->route('withdraw')->with('success', 'Withdrawal request submitted successfully. The operation will be processed by the Administrator shortly');
            } else {
                return redirect()->back()->with('error', 'Failed to create withdrawal request. Please try again.');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'User not found. Please ensure you are logged in.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while processing your request. Please try again later.');
        }
    }

    public function withdraw_history(Request $request)
    {
        $filter_data = [
            'type' => 'Withdrawal',
            'crypto_type' => 'All Currencies',
            'month_from' => 1,
            'day_from' => 1,
            'month_to' => 12,
            'day_to' => 31,
        ];

        $request->session()->put('history_filter', $filter_data);

        $filtered_data = $this->generalService->Get_History_Filter('Withdrawal', 'All Currencies', 'All', 'All');

        return view('Frontend.history', [
            'datas' => $filtered_data['datas'],
            'filter_data' => $filter_data
        ]);
    }






    public function withdraw_checkout_sent(Request $request)
    {

        try {

            $wallet = $request->wallet;
            $amount_request = $request->amount;

            $users = User::find(Auth::id());

            if ($wallet === 'Perfect Money') {
                $coloum = 'perfect_money';
                $payment_name = 'Perfect Money';
            } elseif ($wallet === 'Payeer') {
                $coloum = 'payeer';
                $payment_name = 'Payeer';
            } elseif ($wallet === 'BTC') {
                $coloum = 'bitcoin';
                $payment_name = 'Bitcoin';
            } elseif ($wallet === 'LTC') {
                $coloum = 'litecoin';
                $payment_name = 'Litecoin';
            } elseif ($wallet === 'BCH') {
                $coloum = 'bitcoin_cash';
                $payment_name = 'Bitcoin Cash';
            } elseif ($wallet === 'ETH') {
                $coloum = 'ethereum';
                $payment_name = 'Ethereum';
            } elseif ($wallet === 'USDT-BSC(BEP20)') {
                $coloum = 'usdt_bsc_bep20';
                $payment_name = 'USDT-BSC(BEP20)';
            } else {
                $coloum = 'error';
                $payment_name = 'error';
            }


            $checkwallet = $this->generalService->Check_Wallet_Address($coloum);

            if ($checkwallet === false) {
                return redirect()->back()->withInput()->with('error', 'We have not found a wallet to withdraw.');
            }
            if ($amount_request <= 0) {
                return redirect()->back()->withInput()->with('error', 'Your request does not to match with balance');
            }

            switch ($wallet) {
                case 'Perfect Money':
                    $perfect_moneys_able = $this->generalService->getAmountPerWallet($wallet);

                    if ($amount_request > $perfect_moneys_able['available']) {
                        return redirect()->back()->withInput()->with('error', 'Your request does not to match with balance');
                    } else {
                        if ($perfect_moneys_able['available'] < 0.50) {
                            return redirect()->back()->withInput()->with('error', 'Your request does not meet the minimum withdrawal amount of $0.50.');
                        }
                    }

                    $Session_withdraws = [
                        'wallet' => $wallet,
                        'withdraw_request' => $amount_request,
                        'amount_crypto' => null,
                        'account' => $users->perfect_money,
                        'payment_name' => $payment_name,
                    ];

                    $request->session()->put('session_withdraws', $Session_withdraws);
                    return redirect()->route('withdraw_confirm');

                case 'Payeer':
                    $payeer_able = $this->generalService->getAmountPerWallet($wallet);

                    if ($amount_request > $payeer_able['available']) {
                        return redirect()->back()->withInput()->with('error', 'Your request does not to match with balance');
                    } else {
                        if ($payeer_able['available'] < 0.50) {
                            return redirect()->back()->withInput()->with('error', 'Your request does not meet the minimum withdrawal amount of $0.50.');
                        }
                    }



                    $Session_withdraws = [
                        'wallet' => $wallet,
                        'withdraw_request' => $amount_request,
                        'amount_crypto' => null,
                        'account' => $users->payeer,
                        'payment_name' => $payment_name,
                    ];

                    $request->session()->put('session_withdraws', $Session_withdraws);
                    return redirect()->route('withdraw_confirm');

                case 'BTC':
                    $bitcoin_able = $this->generalService->getAmountPerWallet($wallet);

                    if ($amount_request > $bitcoin_able['available']) {
                        return redirect()->back()->withInput()->with('error', 'Your request does not to match with balance');
                    } else {
                        if ($bitcoin_able['available'] < 15) {
                            return redirect()->back()->withInput()->with('error', 'Your request does not meet the minimum withdrawal amount of $15.00.');
                        }
                    }

                    $amount_crypto = $amount_request / $this->generalService->Get_PriceOfCrypto($wallet);
                    $Session_withdraws = [
                        'wallet' => $wallet,
                        'withdraw_request' => $amount_request,
                        'amount_crypto' => number_format($amount_crypto, 7),
                        'account' => $users->bitcoin,
                        'payment_name' => $payment_name,
                    ];

                    $request->session()->put('session_withdraws', $Session_withdraws);
                    return redirect()->route('withdraw_confirm');

                case 'LTC':
                    $litecoin_able = $this->generalService->getAmountPerWallet($wallet);

                    if ($amount_request > $litecoin_able['available']) {
                        return redirect()->back()->withInput()->with('error', 'Your request does not to match with balance');
                    } else {
                        if ($litecoin_able['available'] < 1) {
                            return redirect()->back()->withInput()->with('error', 'Your request does not meet the minimum withdrawal amount of $1.00.');
                        }
                    }
                    $amount_crypto = $amount_request / $this->generalService->Get_PriceOfCrypto($wallet);
                    $Session_withdraws = [
                        'wallet' => $wallet,
                        'withdraw_request' => $amount_request,
                        'amount_crypto' => number_format($amount_crypto, 7),
                        'account' => $users->litecoin,
                        'payment_name' => $payment_name,
                    ];

                    $request->session()->put('session_withdraws', $Session_withdraws);
                    return redirect()->route('withdraw_confirm');

                case 'BCH':
                    $bitcoin_cash_able = $this->generalService->getAmountPerWallet($wallet);

                    if ($amount_request > $bitcoin_cash_able['available']) {
                        return redirect()->back()->withInput()->with('error', 'Your request does not to match with balance');
                    } else {
                        if ($bitcoin_cash_able['available'] < 1) {
                            return redirect()->back()->withInput()->with('error', 'Your request does not meet the minimum withdrawal amount of $1.00.');
                        }
                    }

                    $amount_crypto = $amount_request / $this->generalService->Get_PriceOfCrypto($wallet);
                    $Session_withdraws = [
                        'wallet' => $wallet,
                        'withdraw_request' => $amount_request,
                        'amount_crypto' => number_format($amount_crypto, 7),
                        'account' => $users->bitcoin_cash,
                        'payment_name' => $payment_name,
                    ];

                    $request->session()->put('session_withdraws', $Session_withdraws);
                    return redirect()->route('withdraw_confirm');
                    break;
                case 'ETH':
                    $ethereum_cash_able = $this->generalService->getAmountPerWallet($wallet);

                    if ($amount_request > $ethereum_cash_able['available']) {
                        return redirect()->back()->withInput()->with('error', 'Your request does not to match with balance');
                    } else {
                        if ($ethereum_cash_able['available'] < 5) {
                            return redirect()->back()->withInput()->with('error', 'Your request does not meet the minimum withdrawal amount of $5.00.');
                        }
                    }

                    $amount_crypto = $amount_request / $this->generalService->Get_PriceOfCrypto($wallet);
                    $Session_withdraws = [
                        'wallet' => $wallet,
                        'withdraw_request' => $amount_request,
                        'amount_crypto' => number_format($amount_crypto, 7),
                        'account' => $users->ethereum,
                        'payment_name' => $payment_name,
                    ];

                    $request->session()->put('session_withdraws', $Session_withdraws);
                    return redirect()->route('withdraw_confirm');
                    break;
                case 'USDT-BSC(BEP20)':
                    $usdt_bsc_bep20_able = $this->generalService->getAmountPerWallet($wallet);

                    if ($amount_request > $usdt_bsc_bep20_able['available']) {
                        return redirect()->back()->withInput()->with('error', 'Your request does not to match with balance');
                    } else {
                        if ($usdt_bsc_bep20_able['available'] < 1) {
                            return redirect()->back()->withInput()->with('error', 'Your request does not meet the minimum withdrawal amount of $1.00.');
                        }
                    }
                    $Session_withdraws = [
                        'wallet' => $wallet,
                        'withdraw_request' => $amount_request,
                        'amount_crypto' => null,
                        'account' => $users->usdt_bsc_bep20,
                        'payment_name' => $payment_name,
                    ];

                    $request->session()->put('session_withdraws', $Session_withdraws);
                    return redirect()->route('withdraw_confirm');
                    break;

                default:
                    return redirect()->back()->withInput()->with('error', 'Invalid wallet selection.');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->withInput()->with('error', 'User or wallet not found.');
        } catch (\Exception $e) {
            Log::error('Withdrawal error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Something went wrong. Please try again later.');
        }
    }


    public function withdraw_confirm(Request $request)
    {
        if ($request->session()->has('session_withdraws')) {

            $Session_withdraws = session('session_withdraws');

            $withdraw_request = $Session_withdraws['withdraw_request'];
            $account = $Session_withdraws['account'];
            $amount_crypto = $Session_withdraws['amount_crypto'];
            $wallet = $Session_withdraws['wallet'];
            $payment_name = $Session_withdraws['payment_name'];



            $Session_withdraws_confirm = [
                'withdraw_request' => $withdraw_request,
                'amount_crypto' => $amount_crypto,
                'payment_name' => $payment_name,
                'account' => $account,
                'wallet' => $wallet,
            ];

            $request->session()->put('Session_withdraws_confirm', $Session_withdraws_confirm);

            $request->session()->forget('session_withdraws');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }

        return view('Frontend.withdraw_checkout', compact('wallet', 'withdraw_request', 'account', 'amount_crypto', 'payment_name'));
    }
}
