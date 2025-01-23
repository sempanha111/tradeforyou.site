<?php

namespace App\Http\Controllers\Frontend;

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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class DespositController extends Controller
{

    protected $generalService;

    public function __construct(GeneralService $generalService)
    {
        $this->generalService = $generalService;
    }

    public function deposit()
    {
        $account_balance = $this->generalService->Get_Account_Balance();
        return view('Frontend.deposit', compact('account_balance'));
    }



    public function depositcheckout(Request $request)
    {

        $generate_payment_id = Str::random(10); // Generate a random payment ID
        $plan = $request->h_id;
        $request_deposit_amount = $request->amount;
        $type = $request->type;


        $plans = $this->generalService->Get_Des_plan($plan);


        $descript_plan = $plans['descript_plan'];
        $profit_percent = $plans['profit_percent'];


        switch ($type) {
            case 'Perfect Money':
                $wallet = 'U47746648';
                $amount_crypto = null;

                Transaction::create([
                    'user_id' => Auth::id(),
                    'request_deposit_amount' => $request_deposit_amount,
                    'plan' => $plan,
                    'crypto' => $type,
                    'address' => $wallet,
                    'amount_crypto' => $amount_crypto,
                    'status' => 'Pending',
                    'transaction_id' => $generate_payment_id,
                ]);

                break;

            case 'Payeer':
                $secret = 'qNekWQzFqzyAfSzK'; // Your Payeer secret key
                $shopId = '2133008988'; // Your Payeer shop ID
                $wallet = 'P1123089445';
                $amount_crypto = null;

                $data['m_shop'] = $shopId;
                $data['m_orderid'] = $generate_payment_id;
                $data['m_amount'] = number_format($request_deposit_amount, 2, '.', ''); // Ensure amount has 2 decimal places
                $data['m_curr'] = 'USD';
                $data['m_desc'] = base64_encode('Plan' . $descript_plan); // Base64-encode the description
                $data['m_sign'] = $this->generalService->generateSignature($data, $secret);


                Transaction::create([
                    'user_id' => Auth::id(),
                    'request_deposit_amount' => $request_deposit_amount,
                    'plan' => $plan,
                    'crypto' => 'Payeer',
                    'address' => $wallet,
                    'amount_crypto' => $amount_crypto,
                    'status' => 'Pending',
                    'transaction_id' => $generate_payment_id,
                ]);


                break;
            case 'Payeer Manual':
                $wallet = 'P1123089445';
                $amount_crypto = null;

                Transaction::create([
                    'user_id' => Auth::id(),
                    'request_deposit_amount' => $request_deposit_amount,
                    'plan' => $plan,
                    'crypto' => 'Payeer',
                    'address' => $wallet,
                    'amount_crypto' => $amount_crypto,
                    'status' => 'Pending',
                    'transaction_id' => $generate_payment_id,
                ]);


                break;
            case 'CoinBase':

                $wallet = 'CoinBase';
                $amount_crypto = null;

                Transaction::create([
                    'user_id' => Auth::id(),
                    'request_deposit_amount' => $request_deposit_amount,
                    'plan' => $plan,
                    'crypto' => $type,
                    'address' => $wallet,
                    'amount_crypto' => $amount_crypto,
                    'status' => 'Pending',
                    'transaction_id' => $generate_payment_id,
                ]);

                break;

            case 'BTC':

                $my_wallet = [
                    '3BvX5ipX3uRkvqEnXmMNNVW6DS3XxyEDgb',
                    '3KJzUaR6fwRwVLWfPjxeE5uJ1jNBkA7HcF',
                    '3A7SrNCJmgozqUMVhbztXiEPBKEUcGKYDE',
                    '35hsci23hQ2gwkoJzWkax6E8uDByZq3ZfF',
                    '13LAsq2CbU7cexTMa3i9gzHuEPNJdygKKq',
                ];

                $amountToCheck = number_format($request_deposit_amount / $this->generalService->Get_PriceOfCrypto($type), 8); // Starting amount to check

                $tolerance = 0.0000004; // Define tolerance for lower and upper limit
                $timeLimit = now()->subHours(5); // Transactions within the last 3 hours
                $increment = 0.0000004; // Increment amount if all wallets have matching transactions

                $transactionCreated = false; // Variable to check if a new transaction has been created

                // Loop until a new transaction is created
                while (!$transactionCreated) {
                    $allMatched = true; // Reset the variable for each loop iteration

                    // Loop through each wallet address
                    foreach ($my_wallet as $wallet) {
                        // Fetch transactions for the wallet within the last 3 hours
                        $transactions = Transaction::where('crypto', 'BTC')->Where('status', 'Pending')
                            ->where('address', $wallet)
                            ->where('created_at', '>=', $timeLimit)
                            ->get();

                        $found = false; // To check if we found a valid transaction for this wallet

                        foreach ($transactions as $transaction) {
                            $transactionAmount = $transaction->amount_crypto;

                            // Calculate the lower and upper bounds based on tolerance
                            $lower_bound = $transactionAmount - $tolerance;
                            $upper_bound = $transactionAmount + $tolerance;

                            // Check if the transaction amount is within the range
                            if ($amountToCheck >= $lower_bound && $amountToCheck <= $upper_bound) {
                                // If the transaction amount is within the range, mark as found
                                $found = true;
                                break;
                            }
                        }

                        if ($found) {
                            // If a valid transaction is found, continue to the next wallet
                            continue;
                        } else {
                            $amount_crypto = $amountToCheck;
                            if ($wallet == $my_wallet[0]) {
                                $qr_crypto = 'assets_backend/images/crypto/BTC3BvXEDgb.png';
                            } elseif ($wallet == $my_wallet[1]) {
                                $qr_crypto = 'assets_backend/images/crypto/3KjzUakA7HcF.png';
                            } else {
                                $qr_crypto = 'assets_backend/images/crypto/BTC3A7KYDE.png';
                            }


                            Transaction::create([
                                'user_id' => Auth::id(),
                                'request_deposit_amount' => $request_deposit_amount,
                                'plan' => $plan,
                                'crypto' => $type,
                                'address' => $wallet,
                                'amount_crypto' => $amount_crypto,
                                'status' => 'Pending',
                                'transaction_id' => $generate_payment_id,
                            ]);

                            $transactionCreated = true; // Mark that a new transaction has been created
                            break; // Exit the loop after creating the transaction
                        }
                    }

                    if ($allMatched) {
                        $amountToCheck += $increment;
                        $amountToCheck = number_format($amountToCheck, 8);
                    }
                }

                break;

            case 'LTC':

                $my_wallet = [
                    'MGHtuaALaURDoX5DwCBTq7hvpM39MpFSHY',
                    'MDhDUXAxMfKtGMXVY9gVxqBQgm5WW3N12X',
                    'MK9gL2zEKxA2gyu6MaVyUDonTdSnDqp5nC',
                    'ltc1qyjr8fjndk8l67xne2j8rv92mukzz82w7l32qmp',
                    'LYRJuifgn4CqoKnvUnouTeY5cHtvYX2jyv',
                ];

                $amountToCheck = number_format($request_deposit_amount / $this->generalService->Get_PriceOfCrypto($type), 8); // Starting amount to check

                $tolerance = 0.0000005; // Define tolerance for lower and upper limit
                $timeLimit = now()->subHours(5); // Transactions within the last 3 hours
                $increment = 0.0000005; // Increment amount if all wallets have matching transactions

                $transactionCreated = false; // Variable to check if a new transaction has been created

                // Loop until a new transaction is created
                while (!$transactionCreated) {
                    $allMatched = true; // Reset the variable for each loop iteration

                    // Loop through each wallet address
                    foreach ($my_wallet as $wallet) {
                        // Fetch transactions for the wallet within the last 3 hours
                        $transactions = Transaction::where('crypto', 'LTC')->Where('status', 'Pending')
                            ->where('address', $wallet)
                            ->where('created_at', '>=', $timeLimit)
                            ->get();

                        $found = false; // To check if we found a valid transaction for this wallet

                        foreach ($transactions as $transaction) {
                            $transactionAmount = $transaction->amount_crypto;

                            // Calculate the lower and upper bounds based on tolerance
                            $lower_bound = $transactionAmount - $tolerance;
                            $upper_bound = $transactionAmount + $tolerance;

                            // Check if the transaction amount is within the range
                            if ($amountToCheck >= $lower_bound && $amountToCheck <= $upper_bound) {
                                // If the transaction amount is within the range, mark as found
                                $found = true;
                                break;
                            }
                        }

                        if ($found) {
                            // If a valid transaction is found, continue to the next wallet
                            continue;
                        } else {
                            $amount_crypto = $amountToCheck;
                            if ($wallet == $my_wallet[0]) {
                                $qr_crypto = 'assets_backend/images/crypto/MGHtuaMpFSHY.png';
                            } elseif ($wallet == $my_wallet[1]) {
                                $qr_crypto = 'assets_backend/images/crypto/MDhDUXW3N12X.png';
                            } else {
                                $qr_crypto = 'assets_backend/images/crypto/MK9gp5nC.png';
                            }


                            Transaction::create([
                                'user_id' => Auth::id(),
                                'request_deposit_amount' => $request_deposit_amount,
                                'plan' => $plan,
                                'crypto' => $type,
                                'address' => $wallet,
                                'amount_crypto' => $amount_crypto,
                                'status' => 'Pending',
                                'transaction_id' => $generate_payment_id,
                            ]);

                            $transactionCreated = true; // Mark that a new transaction has been created
                            break; // Exit the loop after creating the transaction
                        }
                    }

                    if ($allMatched) {
                        $amountToCheck += $increment;
                        $amountToCheck = number_format($amountToCheck, 8);
                    }
                }

                break;

            case 'BCH':

                $my_wallet = [
                    '1M7dwMpJgNSR7P4QHVxHKgMJxdHJjdYcij',
                    '1Avfbct2XeLEuxeLNhg2qunypBYq2iFsnE',
                    'qr2m6tjls7elzcs08cp707z7t0tkyqzqvyr3vdn6ru',
                    'bitcoincash:qqsm2jqk7xpk5f66evnc4hrazjvuyvw83v76txn9st'
                ];

                $amountToCheck = number_format($request_deposit_amount / $this->generalService->Get_PriceOfCrypto($type), 8); // Starting amount to check

                $tolerance = 0.0000006; // Define tolerance for lower and upper limit
                $timeLimit = now()->subHours(3); // Transactions within the last 3 hours
                $increment = 0.0000006; // Increment amount if all wallets have matching transactions

                $transactionCreated = false; // Variable to check if a new transaction has been created

                // Loop until a new transaction is created
                while (!$transactionCreated) {
                    $allMatched = true; // Reset the variable for each loop iteration

                    // Loop through each wallet address
                    foreach ($my_wallet as $wallet) {
                        // Fetch transactions for the wallet within the last 3 hours
                        $transactions = Transaction::where('crypto', 'BCH')->Where('status', 'Pending')
                            ->where('address', $wallet)
                            ->where('created_at', '>=', $timeLimit)
                            ->get();

                        $found = false; // To check if we found a valid transaction for this wallet

                        foreach ($transactions as $transaction) {
                            $transactionAmount = $transaction->amount_crypto;

                            // Calculate the lower and upper bounds based on tolerance
                            $lower_bound = $transactionAmount - $tolerance;
                            $upper_bound = $transactionAmount + $tolerance;

                            // Check if the transaction amount is within the range
                            if ($amountToCheck >= $lower_bound && $amountToCheck <= $upper_bound) {
                                // If the transaction amount is within the range, mark as found
                                $found = true;
                                break;
                            }
                        }

                        if ($found) {
                            // If a valid transaction is found, continue to the next wallet
                            continue;
                        } else {
                            $amount_crypto = $amountToCheck;
                            if ($wallet == $my_wallet[0]) {
                                $qr_crypto = 'assets_backend/images/crypto/1M7dwMjdYcij.png';
                            } elseif ($wallet == $my_wallet[1]) {
                                $qr_crypto = 'assets_backend/images/crypto/1Avfbc2iFsnE.png';
                            } else {
                                $qr_crypto = 'assets_backend/images/crypto/1M7dwMjdYcij.png';
                            }


                            Transaction::create([
                                'user_id' => Auth::id(),
                                'request_deposit_amount' => $request_deposit_amount,
                                'plan' => $plan,
                                'crypto' => $type,
                                'address' => $wallet,
                                'amount_crypto' => $amount_crypto,
                                'status' => 'Pending',
                                'transaction_id' => $generate_payment_id,
                            ]);

                            $transactionCreated = true; // Mark that a new transaction has been created
                            break; // Exit the loop after creating the transaction
                        }
                    }

                    if ($allMatched) {
                        $amountToCheck += $increment;
                        $amountToCheck = number_format($amountToCheck, 8);
                    }
                }

                break;
            case 'ETH':

                $my_wallet = [
                    '0x310ED57aC2b9daF8337430F593FB9FEC9347fb8a',
                    '0x6C6CFcd53d23065c99AA60Eb1bcc50f36953A05b',
                    '0x723942748f92F7Bd9a29CaB4B0fE2984fbB8C717',
                ];

                $amountToCheck = number_format($request_deposit_amount / $this->generalService->Get_PriceOfCrypto($type), 8); // Starting amount to check

                $tolerance = 0.0000006; // Define tolerance for lower and upper limit
                $timeLimit = now()->subHours(3); // Transactions within the last 3 hours
                $increment = 0.0000006; // Increment amount if all wallets have matching transactions

                $transactionCreated = false; // Variable to check if a new transaction has been created

                // Loop until a new transaction is created
                while (!$transactionCreated) {
                    $allMatched = true; // Reset the variable for each loop iteration

                    // Loop through each wallet address
                    foreach ($my_wallet as $wallet) {
                        // Fetch transactions for the wallet within the last 3 hours
                        $transactions = Transaction::where('crypto', 'ETH')->Where('status', 'Pending')
                            ->where('address', $wallet)
                            ->where('created_at', '>=', $timeLimit)
                            ->get();

                        $found = false; // To check if we found a valid transaction for this wallet

                        foreach ($transactions as $transaction) {
                            $transactionAmount = $transaction->amount_crypto;

                            // Calculate the lower and upper bounds based on tolerance
                            $lower_bound = $transactionAmount - $tolerance;
                            $upper_bound = $transactionAmount + $tolerance;

                            // Check if the transaction amount is within the range
                            if ($amountToCheck >= $lower_bound && $amountToCheck <= $upper_bound) {
                                // If the transaction amount is within the range, mark as found
                                $found = true;
                                break;
                            }
                        }

                        if ($found) {
                            // If a valid transaction is found, continue to the next wallet
                            continue;
                        } else {
                            $amount_crypto = $amountToCheck;
                            if ($wallet == $my_wallet[0]) {
                                $qr_crypto = 'assets_backend/images/crypto/0x310E47fb8a.png';
                            } elseif ($wallet == $my_wallet[1]) {
                                $qr_crypto = 'assets_backend/images/crypto/0x728C717.png';
                            } else {
                                $qr_crypto = 'assets_backend/images/crypto/0x6C6C53A05b.png';
                            }


                            Transaction::create([
                                'user_id' => Auth::id(),
                                'request_deposit_amount' => $request_deposit_amount,
                                'plan' => $plan,
                                'crypto' => $type,
                                'address' => $wallet,
                                'amount_crypto' => $amount_crypto,
                                'status' => 'Pending',
                                'transaction_id' => $generate_payment_id,
                            ]);

                            $transactionCreated = true; // Mark that a new transaction has been created
                            break; // Exit the loop after creating the transaction
                        }
                    }

                    if ($allMatched) {
                        $amountToCheck += $increment;
                        $amountToCheck = number_format($amountToCheck, 8);
                    }
                }

                break;



            case 'USDT-BSC(BEP20)':

                $my_wallet = [
                    '0x04ef7293a38938d0e23f23854935f64220442a5f',
                    '0xde52c7a4de802687ab1c02daca6101b5fc5e142b',
                    '0xace754e086c29bbb075144e655ae6bceda4e2721',
                    '0xab728ffa6b59d3180c4a1953824b7427c63ecbb7',
                    '0x6a5b763f01de09f65d20527e3c81cc0870c441ef',
                    '0xc941bfe40fecb272c7596731f0762ab12c2bae9a',
                    '0x95ac9fa2cf01022b072aa4f6c6254f29e836acdc',
                    '0xf82e9976b34b5c84b33042997c0b0fea0dcfe7e5',
                    '0x4542c27ce4588281828dc7fb59c739a29482d38d',
                    '0x79a3d395e4c5f2f1cec3bb59625cda54161b4e79',
                    '0xeaca783da50291976fd3f9edd3cebe3f8e7f9f00',
                    '0x69bddec4ed54d93136adf2bcb204eb8e68f3d4b4',
                    '0x67a1395fc553b5eae85fbc61be17d8bcb7b665e2',
                    '0x4b3f7c294ca35e640e102ebd35c4793f16c0d12f',
                    '0x619ef9f6f954bbe964820b521f94cd45b1277ffc',
                    '0x3a2ccf9a2913c06fa8b551b3d9a660f61ecd08d1',
                    '0x9dad619f9b3972b998b6e9df78efa5e754af1d36',
                    '0x5ce3c0526d6325ab7cb32641c67b71f045a58d54',
                    '0x8de469ec8c027efbbbf8e79d4b1e681b67662bfe',
                    '0x2057ed79c19beaf4680a066fa3deb82fc609798d',
                    '0xa1afad3930459e17b11a264d02e8302379c828da',
                    '0xc7fb1aba660924a4a2e4c0524fd2715de96afc57',
                    '0x680fcae95352fdc0992db54629fd657998c365bb',
                    '0x4685aa973adb83288f8813ec72a3b93b08454641',
                    '0x6046242a78e6858ee02611d4b2833c3648ab2857',
                    '0x0e965335b5a44c0df9c88b4daf1efadb38038d21',
                    '0x0d3e6930aabd8243060b527b3f324c16ae56b3b4',
                    '0x790a304c3ae0827f65f6c1ed51817469af941a16',
                    '0x17b445d10e6d9a8b7a0b9888b101e4186867220e',
                    '0x6b1f2424d93c2c3d40d6324e04f6c4e4cd5e256e',
                    '0x0ebadef4a65fc7e13323c6bf4f477f9683bdf837',
                    '0x1c31d2785d513596db07042164076fe5c6715161',
                    '0xea4dbd0cdc555e1044a666b4d3a678df1716c1e0',
                    '0x3eecd5856ddf13698c7d3893b269c12b2c6e0204',
                    '0x545a996aa752ebc1660a8cd6e7a20ff7c20187cf',
                    '0x48ed79a6c0d5e5ff01c62095d0c0d3d2a9c15a82',
                    '0x4e197e2be3cc7649ed99db16acc53617dc403a3e',
                    '0xf9ddc8c448ef1636ddf4a009e4c0467b6b427d3f',
                    '0xbdfdc666ff1a0c7e92efad6bdb879bcf976d1532',
                    '0x9b2327fe0e3f68ae445e8a3430ae38e0dec70426',
                    '0x918fbf344ac8070ea6e7a3532d5c71f4e4b39084',
                    '0xb9e31ad9c943ce4a50e429033a17e9ced91356e7',
                    '0xb0e58acd448a62259128f831c91162a161290706',
                    '0xfdc9d343ce16a7424db54f5ebb5ae74a7b406b20',
                    '0xd670deea330de983df0fc61a1ddf10bdd4be3279',
                    '0x829bedf1ac2bc20c84ccc4443a10258a2b2388c4',
                    '0x33a508908ce002e3f30edbafa9778ad9eb9e71b8',
                    '0x49ca9ef7c06c90ed0d0139df1096c7635e46e194',
                    '0x0058d710bbceceeea9c8f8a44bc6fbf56b4f43e5',
                    '0x424d70008cb523cbbfe8e4f2ecc797c0af85bf0b',
                ];

                $amountToCheck = $request_deposit_amount;
                $timeLimit = now()->subHours(3); // Transactions within the last 3 hours
                $transactionCreated = false; // To check if a new transaction has been created

                // Loop until a new transaction is created
                while (!$transactionCreated) {
                    // Loop through each wallet address
                    foreach ($my_wallet as $wallet) {
                        // Fetch transactions for the wallet within the last 3 hours
                        $transactions = Transaction::where('crypto', 'USDT-BSC(BEP20)')
                            ->where('status', 'Pending')
                            ->where('address', $wallet)
                            ->where('created_at', '>=', $timeLimit)
                            ->get();

                        $found = false; // To check if we found a valid transaction for this wallet

                        // Check all transactions for this wallet
                        foreach ($transactions as $transaction) {
                            $transactionAmount = $transaction->request_deposit_amount;

                            // Check if the transaction amount matches
                            if ($amountToCheck === $transactionAmount) {
                                $found = true; // Found a matching transaction
                                break;
                            }
                        }

                        if ($found) {
                            // A valid transaction is found, continue to the next wallet
                            continue;
                        } else {
                            // If no matching transaction, create a new one
                            $amount_crypto = $amountToCheck;
                            Transaction::create([
                                'user_id' => Auth::id(),
                                'request_deposit_amount' => $request_deposit_amount,
                                'plan' => $plan,
                                'crypto' => $type,
                                'address' => $wallet,
                                'amount_crypto' => $amount_crypto, // Store the amount to check
                                'status' => 'Pending',
                                'transaction_id' => $generate_payment_id,
                            ]);

                            $transactionCreated = true; // Mark as created
                            break; // Exit after creating the transaction
                        }
                    }

                    if (!$transactionCreated) {
                        // If no transaction was created, increase the amount and check again
                        $amountToCheck += 0.01;
                    }
                }

                break;


            default:
                return redirect()->route('deposit')->with('error', 'Invalid payment type.');
        }

        $Session_deposit = [
            'user_name' => Auth::user()->name,
            'plan' => $plan,
            'request_deposit_amount' => $request_deposit_amount,
            'type' => $type,
            'generate_payment_id' => $generate_payment_id,
            'amount_crypto' => $amount_crypto ?? null, // Set to null if not applicable
            'qr_crypto' => $qr_crypto ?? null, // Set to null if not applicable
            'my_wallet' => $wallet,
            'm_shop' => $data['m_shop'] ?? null,
            'm_orderid' => $data['m_orderid'] ?? null,
            'm_amount' => $data['m_amount'] ?? null,
            'm_curr' => $data['m_curr'] ?? null,
            'm_desc' => $data['m_desc'] ?? null,
            'm_desc' => $data['m_desc'] ?? null,
            'm_sign' => $data['m_sign'] ?? null,
            'descript_plan' => $descript_plan,
            'profit_percent' => $profit_percent,
        ];

        $request->session()->put('Session_deposit', $Session_deposit);

        return redirect()->route('go_deposit_check');
    }



    public function go_deposit_check(Request $request)
    {
        // Retrieve session data
        $sessionData = $request->session()->get('Session_deposit');

        if ($sessionData) {
            // Pass the session data to the view
            return view('Frontend.deposit_checkout', ['data' => $sessionData]);
        } else {
            // Handle the case where session data is not available
            return redirect()->route('deposit')->with('error', 'No deposit session data found.');
        }
    }






    public function deposit_send(Request $request)
    {
        $request->validate([
            'payer_account' => 'required',
            'transaction_id' => 'required'
        ]);
        try {

            $Session_deposit = session('Session_deposit');
            $plan = $Session_deposit['plan'];
            $request_deposit_amount = $Session_deposit['request_deposit_amount'];
            $type = $Session_deposit['type'];
            $generate_payment_id = $Session_deposit['generate_payment_id'];



            $transaction = Transaction::Where('transaction_id', $generate_payment_id)->first();


            $deposits = Deposit::Where('transaction_id', $request->transaction_id)->first();

            if (!empty($deposits)) {
                return redirect()->back()->with('error', 'The Transaction id Has been used. Please Cheack it again.');
            }

            if (!$transaction) {
                return redirect()->back()->with('error', 'The System found You are Transaction Already.');
            }

            $transaction->update([
                'transaction_id' => $request->transaction_id
            ]);

            Deposit::create([
                'user_id' => Auth::id(),
                'plan' => $plan,
                'amount' => $request_deposit_amount,
                'money' => $type === 'Payeer Manual' ? 'Payeer' :  $type,
                'payer_account' => $request->payer_account,
                'transaction_id' => $request->transaction_id,
                'amount_crypto' => $request->amount_crypto > 0 ? $request->amount_crypto : null,
                'status' => 'Pending',
            ]);


            return redirect()->back()->with('success', 'The deposit has been saved. It will become active when the administrator checks statistics.');
        } catch (\Exception $e) {
            // Handle any other kind of exception
            Log::error('Error saving deposit: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again later.');
        }
    }

    public function deposit_history(Request $request)
    {

        $filter_data = [
            'type' => 'Deposit',
            'crypto_type' => 'All Currencies',
            'month_from' => 1,
            'day_from' => 1,
            'month_to' => 12,
            'day_to' => 31,
        ];

        // Set the session with default values
        $request->session()->put('history_filter', $filter_data);

        $filtered_data = $this->generalService->Get_History_Filter('Deposit', 'All Currencies', 'All', 'All');

        return view('Frontend.history', [
            'datas' => $filtered_data['datas'],
            'filter_data' => $filter_data
        ]);
    }



    public function  deposit_list()
    {

        $Auth_id = Auth::user()->id;
        $users = User::find($Auth_id);
        $startOfDay = Carbon::today()->startOfDay();
        $endOfDay = Carbon::today()->endOfDay();

        $deposits = $users->deposit;

        $plan1 = $deposits->Where('status', 'Approved')->Where('plan', 1);
        $plan2 = $deposits->Where('status', 'Approved')->Where('plan', 2);
        $plan3 = $deposits->Where('status', 'Approved')->Where('plan', 3);
        $plan4 = $deposits->Where('status', 'Approved')->Where('plan', 4);
        $plan5 = $deposits->Where('status', 'Approved')->Where('plan', 5);


        $account_balance = $this->generalService->Get_Account_Balance();





        return view('Frontend.deposit_list', [
            'plan1' => $plan1,
            'plan2' => $plan2,
            'plan3' => $plan3,
            'plan4' => $plan4,
            'plan5' => $plan5,
            'startOfDay' => $startOfDay,
            'endOfDay' => $endOfDay,
            'account_balance' => $account_balance,
        ]);
    }







    public function checkstatusdeposit(Request $request)
    {
        if ($request->session()->has('generate_payment_id')) {
            $transaction_id = $request->session()->get('generate_payment_id');
            $transaction = Transaction::where('user_id', Auth::id())->where('transaction_id', $transaction_id)->first();

            if ($transaction) {
                return response()->json([
                    'status' => $transaction->status,
                    'transaction_id' => $transaction_id,
                ], 200);
            } else {
                return response()->json(['status' => 'Not Found'], 404);
            }
        } else {
            return response()->json([
                'status' => 'No have transaction to fetch',
                'transaction_id' => null,
            ]);
        }
    }
}
