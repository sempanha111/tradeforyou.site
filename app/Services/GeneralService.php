<?php

namespace App\Services;

use App\Events\AlertDepositSuccessCrypto;
use App\Events\UpdateIndex;
use App\Models\Deposit;
use App\Models\Earning;
use App\Models\History;
use App\Models\Recordserver;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeneralService
{

    public function createCharge($amount, $currency, $payment_id)
    {
        $apiKey = '2927842e-fab6-4e01-aea8-e7ea4b6c61ae'; // Replace with your actual API key
        $url = 'https://api.commerce.coinbase.com/charges';

        $headers = [
            'Content-Type' => 'application/json',
            'X-CC-Api-Key' => $apiKey,
            'X-CC-Version' => '2018-03-22',
        ];

        $data = [
            'name' => 'Payment for service',
            'description' => 'Service payment description',
            'metadata' => [
                'payment_id' => $payment_id,
            ],
            'local_price' => [
                'amount' => $amount,
                'currency' => $currency
            ],
            'pricing_type' => 'fixed_price',
            'redirects' => [
                'success_url' => route('handleCallcoinbase'),
                'cancel_url' => route('deposit_failure')
            ]
        ];


        try {
            $response = Http::withOptions(['verify' => false])
                ->withHeaders($headers)
                ->post($url, $data);

            Log::info('Coinbase Charge Creation Request', [
                'url' => $url,
                'headers' => $headers,
                'data' => $data,
                'status' => $response->status(),
                'response' => $response->json(),
            ]);

            if ($response->failed()) {
                Log::error('Coinbase Charge Creation Failed', [
                    'status' => $response->status(),
                    'response' => $response->json(),
                    'data' => $data,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Coinbase Charge Creation Exception', [
                'message' => $e->getMessage(),
                'data' => $data,
            ]);
            return ['error' => $e->getMessage()];
        }
    }

    public function verifySignature($payload, $signatureHeader, $sharedSecret)
    {
        $computedSignature = hash_hmac('sha256', $payload, $sharedSecret);

        return hash_equals($computedSignature, $signatureHeader);
    }

    public function AuthLogin($user)
    {
        Auth::login($user);
    }

    public function Get_Earn_All()
    {

        $users = User::find(Auth::id());

        return  $users->earning()->sum('profit');
    }
    public function Get_Withdraw_All()
    {
        $users = User::find(Auth::id());
        return $withdraw = $users->withdraw()->Where('status', 'Approved')->sum('withdraw_request');
    }
    public function Get_Account_Balance()
    {

        $earning = $this->Get_Earn_All();
        $withdraw = $this->Get_Withdraw_All();

        return number_format($earning - $withdraw, 2);
    }

    public function Get_Last_Withdraw()
    {
        $user = User::find(Auth::id());
        $last_withdraw = $user->withdraw()->latest()->first();
        return $last_withdraw ? $last_withdraw->withdraw_request : 0;
    }

    public function Get_Last_Deposit()
    {
        $users = User::find(Auth::id());

        $last_deposit = $users->deposit()->Where('status', 'approved')->latest()->first();

        return $last_deposit ? $last_deposit->amount : 0;
    }

    public function Get_Deposit_Summary()
    {
        $user = User::find(Auth::id()); // Get the authenticated user

        // Get all approved deposits for the user
        $deposit_actives = $user->deposit()->where('status', 'Approved')->get();

        // Initialize the totals
        $total_deposit_actives = 0;
        $total_deposit = 0;

        // Loop through each approved deposit and calculate totals
        foreach ($deposit_actives as $deposits_active) {
            $end_plan = Carbon::parse($deposits_active->end_plan);
            $current_date = Carbon::now();

            // If the current date is less than the end_plan, it's an active deposit
            if ($current_date->lt($end_plan)) {
                $total_deposit_actives += $deposits_active->amount;
            }

            // Sum up all approved deposits, whether active or not
            $total_deposit += $deposits_active->amount;
        }

        // Return both totals
        return [
            'total_deposit_actives' => $total_deposit_actives,
            'total_deposit' => $total_deposit,
        ];
    }

    public function Get_Earn_Only()
    {
        $user = User::find(Auth::id());
        return $user->history()->Where('type', '!=', 'Referral')->sum('amount');
    }


    function getFormattedDateTime()
    {
        // Get the current date and time
        $now = Carbon::now();

        // Format the date and time like "Wednesday, September 11 3:04 PM"
        $formattedDateTime = $now->format('l, F j g:i A');

        return $formattedDateTime;
    }



    public function Get_PriceOfCrypto($crypto)
    {
        $supportedCryptos = ['BTC', 'ETH', 'LTC', 'XRP', 'DASH', 'XMR', 'XEM', 'BCH'];

        if (!in_array($crypto, $supportedCryptos)) {
            return "Unsupported cryptocurrency: " . $crypto;
        }

       // Temporarily disable SSL verification (not recommended for production)
       $response = Http::withOptions(['verify' => false])
       ->get('https://min-api.cryptocompare.com/data/pricemultifull?fsyms=BTC,ETH,LTC,XRP,DASH,XMR,XEM,BCH&tsyms=USD');


        if ($response->successful()) {
            $data = $response->json();

            if (isset($data['RAW'][$crypto]['USD']['PRICE'])) {
                $price = round($data['RAW'][$crypto]['USD']['PRICE'], 2);
                return  $price;
            } else {
                return "Price data for {$crypto} not found.";
            }
        }
        return "Failed to retrieve cryptocurrency data.";
    }


    public function Get_Referral()
    {
        $user = User::find(Auth::id());
        $referrals =  $user->history()->Where('type', 'Referral');

        return [
            'total_referral' => $referrals->count(),
            'total_amount' =>  number_format($referrals->sum('amount'), 2),
        ];
    }


    public function generateSignature($data, $secret)
    {
        // Concatenate parameters in the required order
        $signString = implode(':', [
            $data['m_shop'],
            $data['m_orderid'],
            number_format($data['m_amount'], 2, '.', ''), // Ensure amount has 2 decimal places
            $data['m_curr'],
            $data['m_desc'], // Already base64-encoded before being passed here
            $secret
        ]);

        // Generate the SHA-256 signature
        return strtoupper(hash('sha256', $signString));
    }

    public function generateSignatureForCallback($data, $secret)
    {
        $signString = implode(':', [
            $data['m_operation_id'],
            $data['m_operation_ps'],
            $data['m_operation_date'],
            $data['m_operation_pay_date'],
            $data['m_shop'],
            $data['m_orderid'],
            number_format($data['m_amount'], 2, '.', ''),
            $data['m_curr'],
            $data['m_desc'],
            $data['m_status'],
            $secret
        ]);

        return strtoupper(hash('sha256', $signString));
    }



    public function Deposit_Success($plan, $request_deposit_amount, $type, $amount_crypto, $users_id, $transaction_id, $payer_account)
    {

        $start_plan =  Carbon::now();
        $end_plan = $start_plan->copy()->addHours(72);

        $Deposit = Deposit::create([
            'user_id' => $users_id,
            'plan' => $plan,
            'amount' => $request_deposit_amount,
            'money' => $type,
            'payer_account' => $payer_account ?? null,
            'transaction_id' => $transaction_id,
            'amount_crypto' => $amount_crypto ?? null,
            'status' => 'Approved',
            'start_plan' => $start_plan,
            'end_plan' => $end_plan,
        ]);



        if ($Deposit) {
            $this->Check_Alffiliate($users_id, $request_deposit_amount);
            return 'success';
        } else {
            return 'false';
        }
    }


    public function Check_Alffiliate($users_id, $deposit_amount)
    {
        $user = User::find($users_id);

        $comission_percent = 10 / 100; //10%

        if ($user && $user->link_from != null) {
            $link_from = $user->link_from;


            $own_of_link = User::Where('fullname', $link_from)->first();


            if ($own_of_link) {

                if ($own_of_link->perfect_money != null) {
                    $wallet = 'Perfect Money';
                } elseif ($own_of_link->payeer != null) {
                    $wallet = 'Payeer';
                } elseif ($own_of_link->bitcoin != null) {
                    $wallet = 'BTC';
                } elseif ($own_of_link->litecoin != null) {
                    $wallet = 'LTC';
                } elseif ($own_of_link->bitcoin_cash != null) {
                    $wallet = 'BCH';
                } elseif ($own_of_link->ethereum != null) {
                    $wallet = 'ETH';
                } elseif ($own_of_link->usdt_bsc_bep20 != null) {
                    $wallet = 'USDT-BSC(BEP20)';
                } else {
                    $wallet = 'LTC';
                }

                $earn = Earning::Where('user_id', $own_of_link->id)->Where('from', 'Referral')->first();
                if ($earn) {
                    $old_profit_rel = $earn->profit;
                    $earn->update([
                        'profit' => $old_profit_rel + ($deposit_amount * $comission_percent),
                    ]);
                } else {
                    Earning::create([
                        'user_id' => $own_of_link->id,
                        'money' => $wallet,
                        'profit' => ($deposit_amount * $comission_percent),
                        'from' => 'Referral'
                    ]);
                }

                History::create([
                    'user_id' => $own_of_link->id,
                    'type' => 'Referral',
                    'money' => $wallet,
                    'from' => $user->fullname,
                    'deposit' => $deposit_amount,
                    'amount' => $deposit_amount * $comission_percent,
                ]);
            }
        }
    }

    public function expireOldPayments()
    {
        // Get payments that are still pending and older than 24 hours
        $transactions = Transaction::where('status', 'Pending')->where('created_at', '<', now()->subHours(0.05))->get();

        foreach ($transactions as $transaction) {
            // Update payment status to 'expired'
            $transaction->status = 'Expired';
            $transaction->save();
        }
    }



    public function getAmountPerWallet($walletType)
    {

        $Auth_id = Auth::id();
        $user = User::find($Auth_id);


        $earnings = $user->earning->where('money', $walletType);
        $withdraws = $user->withdraw->where('money', $walletType);
        $withdraws_pending = $withdraws->where('status', 'Pending');

        $total_earnings = $earnings->sum('profit');

        $withdrawed_total = $withdraws->sum('withdraw_request');
        $pending_total = $withdraws_pending->sum('withdraw_request');

        // Available amount to withdraw
        $available = $total_earnings - $withdrawed_total;

        return [
            'available' => number_format($available, 2),
            'pending' => number_format($pending_total, 2)
        ];
    }



    public function Get_History_Filter($type, $crypto_type, $from, $to)
    {
        $user = User::find(Auth::id());


        if ($type === 'Withdrawal') {
            $query = $user->withdraw()->get()->map(function ($item) {
                $item->type = 'Withdrawal';
                return $item;
            });
        } elseif ($type === 'Deposit') {
            $query = $user->transaction()->get()->map(function ($item) {
                $item->type = 'Deposit';
                return $item;
            });
        } elseif ($type === 'Earning') {
            $query = $user->history()->where('type', 'Profit')->get()->map(function ($item) {
                $item->type = 'Earning';
                return $item;
            });
        } elseif ($type === 'Referral') {
            $query = $user->history()->where('type', 'Referral')->get()->map(function ($item) {
                $item->type = 'Referral';
                return $item;
            });
        } elseif ($type === 'All Transactions') {
            $withdrawals = $user->withdraw()->get()->map(function ($item) {
                $item->type = 'Withdrawal';
                return $item;
            });

            $deposits = $user->transaction()->get()->map(function ($item) {
                $item->type = 'Deposit';
                return $item;
            });

            $earnings = $user->history()->where('type', 'Profit')->get()->map(function ($item) {
                $item->type = 'Earning';
                return $item;
            });
            $referral = $user->history()->where('type', 'Referral')->get()->map(function ($item) {
                $item->type = 'Referral';
                return $item;
            });

            $query = $withdrawals->merge($deposits)->merge($earnings)->merge($referral);
        } else {
            return [
                'type' => $type,
                'datas' => collect()
            ];
        }



        if ($crypto_type !== 'All Currencies') {
            $query = $query->filter(function ($item) use ($crypto_type) {
                if ($item->type === 'Deposit') {
                    // Check for 'crypto' field in Deposit type transactions
                    return $item->crypto === $crypto_type;
                } else {
                    // For other transaction types, use 'money' or other appropriate field
                    return $item->money === $crypto_type;
                }
            });
        }


        if ($from !== 'All' && $to !== 'All') {
            $fromDate = Carbon::createFromFormat('Y-m-d', $from)->startOfDay();
            $toDate = Carbon::createFromFormat('Y-m-d', $to)->endOfDay();
            $query = $query->filter(function ($item) use ($fromDate, $toDate) {
                return $item->created_at->between($fromDate, $toDate);
            });
        }


        return [
            'type' => $type,
            'datas' => $query = $query->sortByDesc('created_at')
        ];
    }


    public function Check_Wallet_Address($type)
    {
        $user = User::find(Auth::id());
        if ($user->$type !== null) {
            return true;
        } else {
            return false;
        }
    }


    public function Get_coloum_wallet_user($wallet)
    {
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
        }
        else{
            $coloum = null;
            $payment_name = null;
        }

        return [
            'coloum' => $coloum,
            'payment_name' => $payment_name
        ];
    }

    public function Get_Own_Address_smalllogo($type)
    {
        switch ($type) {
            case 'Perfect Money':
                $small_logo = 'perfect money.gif';
                break;
            case 'Payeer':
                $small_logo = 'payeer.gif';
                break;
            case 'BTC':
                $small_logo = 'btc.gif';
                break;
            case 'LTC':
                $small_logo = 'ltc.gif';
                break;
            case 'BCH':
                $small_logo = 'bch.gif';
                break;
            case 'ETH':
                $small_logo = 'eth.gif';
                break;
            case 'USDT-BSC(BEP20)':
                $small_logo = 'usdt-bsc(bep20).gif';
                break;
            default:
                $small_logo = null;
                break;
        }
        return [
            'small_logo' => $small_logo,
        ];
    }

    public function Get_Des_plan($plan)
    {
        switch ($plan) {
            case 1:
            case 'Plan1':
                $descript_plan = "130% After 72 Hours";
                $profit_percent = "130.00%";
                break;

            case 2:
            case 'Plan2':
                $descript_plan = "175% After 72 Hours";
                $profit_percent = "175.00%";
                break;

            case 3:
            case 'Plan3':
                $descript_plan = "220% After 72 Hours";
                $profit_percent = "220.00%";
                break;

            case 4:
            case 'Plan4':
                $descript_plan = "245% After 72 Hours";
                $profit_percent = "245.00%";
                break;

            case 5:
            case 'Plan5':
                $descript_plan = "375% After 72 Hours";
                $profit_percent = "375.00%";
                break;

            default:
                return "error"; // Return error if no match is found
        }

        // Return the result as an associative array
        return [
            'descript_plan' => $descript_plan,
            'profit_percent' => $profit_percent,
        ];
    }


    public function Record_From_Server_Transaction($txhash, $my_adress, $from_adress, $crypto_type, $amount_crypto, $satoshis, $status, $details)
    {
        Recordserver::create([
            'txhash' => $txhash ?? null,
            'my_adress' => $my_adress ?? null,
            'from_adress' => $from_adress ?? null,
            'crypto_type' => $crypto_type ?? null,
            'amount_crypto' => $amount_crypto ?? null,
            'satoshis' => $satoshis ?? null,
            'status' => $status ?? null,
            'details' => $details ?? null
        ]);
    }
}
