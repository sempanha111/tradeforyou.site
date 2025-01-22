<?php

namespace App\Http\Controllers\Frontend;

use App\Events\AlertDepositSuccessCrypto;
use App\Events\UpdateIndex;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Services\GeneralService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class PaymentController extends Controller
{

    private $blockcypherToken = 'abfeb9123767429095f6ba4a845d4ce9';

    protected $client;
    protected $generalService;


    public function __construct(GeneralService $generalService)
    {
        $this->generalService = $generalService;
    }






    public function deposit_failure(Request $request)
    {
        $request->session()->forget('Session_deposit');
        return redirect()->route('deposit')->with('error', 'Payment failed. Please try again.');
    }


    public function handleCallbackPerfectMoney(Request $request)
    {

        // Retrieve callback request data
        $all = $request->all();
        $details = json_encode($all);

        $payeeAccount = $request->input('PAYEE_ACCOUNT');
        $paymentAmount = $request->input('PAYMENT_AMOUNT');
        $paymentId = $request->input('PAYMENT_ID');

        // Your expected payee account
        $expectedPayeeAccount = 'U47746648';

        // Fetch the transaction using the paymentId
        $transaction = Transaction::where('transaction_id', $paymentId)->first();
        if (empty($transaction)) {
            return redirect()->route('logout');
        }

        $users = User::Where("name",  $transaction->user->name)->first();

        if (empty($users)) {
            return redirect()->route('logout');
        }

        Auth::login($users);



        $messages = [];

        if ($payeeAccount !== $expectedPayeeAccount) {
            $messages[] = 'Invalid payee account';
        }
        if ($paymentAmount < $transaction->request_deposit_amount) {
            $messages[] = 'Payment amount is less than requested deposit';
        }


        // If there are issues, don't proceed with Deposit_Success
        if (!empty($messages)) {
            return redirect()->route('deposit')->with('warning', 'Payment validation failed: ' . implode(', ', $messages));
        }

        // If no issues, proceed with marking the deposit as successful
        $transaction->update([
            'status' => 'Success'
        ]);
        $this->generalService->Deposit_Success(
            $transaction->plan,
            $transaction->request_deposit_amount,
            $transaction->crypto,
            null, // satoshis
            $transaction->user_id,
            $paymentId,
            null
        );

        event(new AlertDepositSuccessCrypto($transaction->user_id));

        return redirect()->route('deposit')->with('success', 'Payment completed successfully.');
    }




    public function handlePayeerCallback(Request $request)
    {
        // Retrieve callback request data
        $all = $request->all();

        Log::info('Incoming Payeer Data: ', $all);

        // Your expected payee account and secret key
        $expectedPayeeAccount = 'P1123089445'; // Update with your account
        $secretKey = 'qNekWQzFqzyAfSzK';  // Make sure to store this securely

        // Get data from the request
        $paymentId = $request->query('m_orderid');
        $payeeAccount = $request->query('m_shop');  // Payeer shop ID
        $paymentAmount = $request->query('m_amount');
        $paymentHash = $request->query('m_sign');  // Hash signature sent by Payeer

        // Check for Authentiate
        $transaction = Transaction::where('transaction_id', $paymentId)->first();
        if (empty($transaction)) {
            return redirect()->route('logout')->with('error', 'Transaction not found');
        }

        // Fetch the user associated with the transaction
        $user = User::where("name", $transaction->user->name)->first();
        if (empty($user)) {
            return redirect()->route('logout')->with('error', 'User not found');
        }

        // Log the user in for further processing
        Auth::login($user);

        // Prepare data for signature generation
        $data = [
            'm_operation_id' => $request->query('m_operation_id'),
            'm_operation_ps' => $request->query('m_operation_ps'),
            'm_operation_date' => $request->query('m_operation_date'),
            'm_operation_pay_date' => $request->query('m_operation_pay_date'),
            'm_status' => $request->query('m_status'),
            'm_shop' => $payeeAccount, // Payeer shop ID
            'm_orderid' => $paymentId,
            'm_amount' => number_format($paymentAmount, 2, '.', ''), // Ensure amount has 2 decimal places
            'm_curr' => $request->query('m_curr'),
            'm_desc' => $request->query('m_desc') // Base64-encoded description
        ];



        // Generate the signature to compare with Payeer's signature
        $generatedHash = $this->generalService->generateSignatureForCallback($data, $secretKey);

        if ($paymentHash !== $generatedHash) {
            return redirect()->route('deposit')->with('warning', 'Payment validation failed: Invalid signature');
        }




        // Prepare messages array to store validation issues
        $messages = [];


        // Verify the payment amount matches the requested deposit amount
        if ($paymentAmount < $transaction->request_deposit_amount) {
            $messages[] = 'Payment amount is less than requested deposit';
        }

        // If there are issues, don't proceed with Deposit_Success
        if (!empty($messages)) {
            return redirect()->route('deposit')->with('warning', 'Payment validation failed: ' . implode(', ', $messages));
        }

        // If no issues, proceed with marking the deposit as successful
        $transaction->update([
            'status' => 'Success'
        ]);

        // Call deposit success handler
        $this->generalService->Deposit_Success(
            $transaction->plan,
            $transaction->request_deposit_amount,
            $transaction->crypto,
            null, // satoshis
            $transaction->user_id,
            $paymentId,
            null
        );

        // Fire success event
        event(new AlertDepositSuccessCrypto($transaction->user_id));

        return redirect()->route('deposit')->with('success', 'Payment completed successfully.');
    }


    public function receiveTransactionBTC(Request $request)
    {

        $txid = $request->input('txid'); //Checked
        $amount_btc = $request->input('amount_btc'); //Checked In BTC Calculate in websocket
        $address = $request->input('address'); //Checked
        $amount_satoshis = $request->input('amount_satoshis'); //Checked


        // $transactionDetails = $this->getTransactionDetailsBTC($txid);

        $from_adress = null;

        $details = null;

        $timeLimit = now()->subHours(3);

        $transactions = Transaction::where('crypto', 'BTC')
            ->where('address', $address)
            ->where('status', 'Pending')
            ->where('created_at', '>=', $timeLimit)
            ->get();


        $base_tolerance = 0.00002; // Small base tolerance for precision
        $adjustment_factor = 0.00001; // Fine-tuned adjustment factor for scaling

        // Calculate tolerance percentage based on ranges of amount_satoshis
        $totalloop = 0;
        $foundMatch = false;
        foreach ($transactions as $transaction) {
            $totalloop += 1;

            $expectedSatoshis = $transaction->amount_crypto * 100000000;

            if ($expectedSatoshis <= 3000) {
                $tolerance_percentage = $base_tolerance + ($adjustment_factor * 20);
            } elseif ($expectedSatoshis <= 10000) {
                // Between 3000 and 10000, reduce gradually
                $tolerance_percentage = $base_tolerance + ($adjustment_factor * (32 - ($expectedSatoshis / 1000) * 0.3));
            } elseif ($expectedSatoshis <= 50000) {
                // Between 10000 and 50000, scale more slowly
                $tolerance_percentage = $base_tolerance + ($adjustment_factor * (8.5 - ($expectedSatoshis / 10000) * 0.5));
            } elseif ($expectedSatoshis <= 100000) {
                // Between 50000 and 100000, further gradual reduction
                $tolerance_percentage = $base_tolerance + ($adjustment_factor * (5 - ($expectedSatoshis / 20000) * 0.3));
            } elseif ($expectedSatoshis <= 200000) {
                // Between 100000 and 200000, small tolerance adjustments
                $tolerance_percentage = $base_tolerance + ($adjustment_factor * (0.5 - ($expectedSatoshis / 50000) * 0.1));
            } elseif ($expectedSatoshis <= 500000) {
                // Between 200000 and 500000, minimal adjustment for large amounts
                $tolerance_percentage = $base_tolerance + ($adjustment_factor * 0.01);
            } else {
                // For very large amounts, use a fixed small tolerance
                $tolerance_percentage = $base_tolerance + ($adjustment_factor * 0.005);
            }

            // Calculate tolerance in satoshis
            $tolerance_satoshis = $expectedSatoshis * $tolerance_percentage;

            // Calculate lower and upper bounds
            $lower_bound = $expectedSatoshis - $tolerance_satoshis;
            $upper_bound = $expectedSatoshis + $tolerance_satoshis;


            if ($amount_satoshis >= $lower_bound && $amount_satoshis <= $upper_bound) {

                $transaction->update([
                    'status' => 'Success',
                ]);

                $this->generalService->Deposit_Success(
                    $transaction->plan,
                    $transaction->request_deposit_amount,
                    $transaction->crypto,
                    $transaction->amount_crypto,
                    $transaction->user_id,
                    $transaction->transaction_id,
                    null
                );


                event(new AlertDepositSuccessCrypto($transaction->user_id));

                $foundMatch = true;
                break;
            }
        }

        $status = $foundMatch ? 'Matched' : 'Not Match';

        $this->generalService->Record_From_Server_Transaction(
            $txid,
            $address,
            $from_adress,
            'BTC',
            $amount_btc,
            $amount_satoshis,
            $status,
            $details
        );

        return response()->json([
            'status' => $status,
            'lower_bound' => $lower_bound ?? null,
            'upper_bound' => $upper_bound ?? null,
            'totalloop' => $totalloop,
            'amountInBitcoins' => $amount_btc,
            'expectedSatoshis' => $expectedSatoshis,
        ]);
    }

    public function receiveTransactionLTC(Request $request)
    {
        $txid = $request->input('txid'); //Checked
        $address = $request->input('address'); //Checked
        $amount_ltc = $request->input('amount_ltc'); //Checked amount LTC calculate in websocket
        $amount_satoshis = $request->input('amount_satoshis'); //Checked This is already in Satoshis


        $from_adress = null;
        $details = null;


        // $transactionDetails = $this->getTransactionDetailsLTC($txid);

        $timeLimit = now()->subHours(5);

        $transactions = Transaction::where('crypto', 'LTC')
            ->where('address', $address)
            ->where('status', 'Pending')
            ->where('created_at', '>=', $timeLimit)
            ->get();

        $foundMatch = false;

        $totalloop = 0;

        $base_tolerance = 0.00000005; // Smaller base tolerance for tighter control
        $adjustment_factor = 0.000000008; // Fine-tuned adjustment factor for even smaller ranges

        foreach ($transactions as $transaction) {
            $expectedSatoshis = $transaction->amount_crypto * 100000000; // Convert LTC to Satoshis

            if ($expectedSatoshis <= 10000000) { // For small amounts up to 0.1 LTC
                $tolerance_percentage = $base_tolerance + ($adjustment_factor * 40); // Tight tolerance for small values
            } elseif ($expectedSatoshis <= 100000000) { // Between 0.1 and 1 LTC
                $tolerance_percentage = $base_tolerance + ($adjustment_factor * (8 - ($expectedSatoshis / 10000000) * 0.3));
            } elseif ($expectedSatoshis <= 500000000) { // Between 1 and 5 LTC
                $tolerance_percentage = $base_tolerance + ($adjustment_factor * (3 - ($expectedSatoshis / 50000000) * 0.1)); // Smaller range for big values
            } else { // For very large amounts greater than 5 LTC
                $tolerance_percentage = $base_tolerance + ($adjustment_factor * 0.0005); // Minimal tolerance for very large values
            }

            // Calculate tolerance in Satoshis
            $tolerance_satoshis = $expectedSatoshis * $tolerance_percentage;

            // Calculate lower and upper bounds with a very small range
            $lower_bound = $expectedSatoshis - $tolerance_satoshis;
            $upper_bound = $expectedSatoshis + $tolerance_satoshis;

            if ($amount_satoshis >= $lower_bound && $amount_satoshis <= $upper_bound) {

                $transaction->update([
                    'status' => 'Success',
                ]);

                $this->generalService->Deposit_Success(
                    $transaction->plan,
                    $transaction->request_deposit_amount,
                    $transaction->crypto,
                    $transaction->amount_crypto,
                    $transaction->user_id,
                    $transaction->transaction_id,
                    null
                );

                event(new AlertDepositSuccessCrypto($transaction->user_id));
                $foundMatch = true;
                break;
            }
        }

        $status = $foundMatch ? 'Matched' : 'Not Match';

        $this->generalService->Record_From_Server_Transaction($txid, $address, $from_adress, 'LTC', $amount_ltc, $amount_satoshis, $status, $details);

        return response()->json([
            'status' => $status,
            'lower_bound' => $lower_bound ?? null,
            'upper_bound' => $upper_bound ?? null,
            'totalloop' => $totalloop,
            'amount_ltc' => $amount_ltc,
            'expectedSatoshis' => $foundMatch ? $expectedSatoshis : null,
        ]);

    }


    public function receiveTransactionBCH(Request $request)
    {
        $txid = $request->input('txid'); //Checked
        $address = $request->input('address'); //Checked

        $amount_bch = $request->input('amount_bch');  //Checked amount BCH calculate in websocket
        $amount_satoshis =  $request->input('amount_satoshis'); //Checked This is already in Satoshis

        $from_adress = null;
        $details = null;


        $timeLimit = now()->subHours(3);

        $transactions = Transaction::where('crypto', 'BCH')
            ->where('address', $address)
            ->where('status', 'Pending')
            ->where('created_at', '>=', $timeLimit)
            ->get();

        $foundMatch = false;
        $totalloop = 0;

        $base_tolerance =  0.000001; // Very small base tolerance for precision
        $adjustment_factor = 0.00000003; // Very small adjustment factor for fine-tuning

        foreach ($transactions as $transaction) {
            $totalloop += 1;
            $expectedSatoshis = $transaction->amount_crypto * 100000000; // Convert BCH to satoshis

            // Apply tolerance based on specific ranges of expected satoshis
            if ($expectedSatoshis <= 291700) {
                // For values <= 1 USD, apply a small tolerance for precision
                $tolerance_percentage = $base_tolerance + ($adjustment_factor * 200);
            } elseif ($expectedSatoshis <= 1000000) {
                // For mid-range values, scale down tolerance gradually
                $tolerance_percentage = $base_tolerance + ($adjustment_factor * (3.5 - ($expectedSatoshis / 1000000) * 0.1));
            } elseif ($expectedSatoshis <= 3000000) {
                // Further reduce the tolerance for values up to 3,000,000
                $tolerance_percentage = $base_tolerance + ($adjustment_factor * (8.5 + ($expectedSatoshis / 3000000) * 0.08));
            } elseif ($expectedSatoshis <= 5000000) {
                // Tighten the tolerance for values between 3,000,000 and 5,000,000
                $tolerance_percentage = $base_tolerance + ($adjustment_factor * (0.2 + ($expectedSatoshis / 5000000) * 0.00075));
            } elseif ($expectedSatoshis <= 8000000) {
                // Precise tolerance for values between 5,000,000 and 8,000,000
                $tolerance_percentage = $base_tolerance + ($adjustment_factor * (0.1 + ($expectedSatoshis / 8000000) * 0.0005));
            } elseif ($expectedSatoshis <= 10000000) {
                // Fine-tuned for values between 8,000,000 and 10,000,000
                $tolerance_percentage = $base_tolerance + ($adjustment_factor * (0.05 + ($expectedSatoshis / 10000000) * 0.00025));
            } elseif ($expectedSatoshis <= 20000000) {
                // Fine-tuned precision for high-value ranges
                $tolerance_percentage = $base_tolerance + ($adjustment_factor * (0.01 + ($expectedSatoshis / 20000000) *  0.00005));
            } else {
                // Minimal tolerance for amounts larger than 20,000,000
                $tolerance_percentage = $base_tolerance + ($adjustment_factor * 0.005); // Very tight for large amounts
            }

            // Calculate tolerance in satoshis
            $tolerance_satoshis = $expectedSatoshis * $tolerance_percentage;

            // Calculate lower and upper bounds
            $lower_bound = $expectedSatoshis - $tolerance_satoshis;
            $upper_bound = $expectedSatoshis + $tolerance_satoshis;


            if ($amount_satoshis >= $lower_bound && $amount_satoshis <= $upper_bound) {

                $transaction->update([
                    'status' => 'Success',
                ]);

                $this->generalService->Deposit_Success(
                    $transaction->plan,
                    $transaction->request_deposit_amount,
                    $transaction->crypto,
                    $transaction->amount_crypto,
                    $transaction->user_id,
                    $transaction->transaction_id,
                    null
                );

                event(new AlertDepositSuccessCrypto($transaction->user_id));

                $foundMatch = true;

                break;
            }
        }


        $status = $foundMatch ? 'Matched' : 'Not Match';

        $this->generalService->Record_From_Server_Transaction($txid, $address, $from_adress, 'BCH', $amount_bch, $amount_satoshis, $status, $details);

        return response()->json([
            'status' => $status,
            'lower_bound' => $lower_bound ?? null,
            'upper_bound' => $upper_bound ?? null,
            'totalloop' => $totalloop,
            'amount_bch' => $amount_bch,
            'expectedSatoshis' => $foundMatch ? $expectedSatoshis : null,
        ]);
    }


    public function receiveTransactionETH(Request $request)
    {
        $txid = $request->input('txid');  //Checked
        $amount_eth = $request->input('amount_eth');  // Checked  Amount is already in Ether from the Node.js script
        $address = $request->input('address');
        $amount_wei = $request->input('amount_wei');

        $from_adress = null;
        $details = null;


        $timeLimit = now()->subHours(3);

        // Fetch pending transactions related to Ethereum
        $transactions = Transaction::where('crypto', 'ETH')
            ->where('address', $address)
            ->where('status', 'Pending')
            ->where('created_at', '>=', $timeLimit)
            ->get();

        $foundMatch = false;
        $totalloop = 0;

        $base_tolerance = 0.00001; // Smaller base tolerance for ETH
        $adjustment_factor = 0.000001; // Smaller adjustment factor for precise control

        foreach ($transactions as $transaction) {
            $totalloop += 1;

            $expectedWei = $transaction->amount_crypto * 1000000000000000000; // Convert ETH to Wei

            // Apply a very precise tolerance based on expectedWei value ranges
            if ($expectedWei <= 291700000000000000) { // <= 0.2917 ETH
                $tolerance_percentage = $base_tolerance + ($adjustment_factor * 20); // Tighter for small amounts
            } elseif ($expectedWei <= 1000000000000000000) { // Up to 1 ETH
                $tolerance_percentage = $base_tolerance + ($adjustment_factor * (2.5 - ($expectedWei / 1000000000000000000) * 0.05));
            } elseif ($expectedWei <= 3000000000000000000) { // Up to 3 ETH
                $tolerance_percentage = $base_tolerance + ($adjustment_factor * (5.5 + ($expectedWei / 3000000000000000000) * 0.03));
            } elseif ($expectedWei <= 5000000000000000000) { // Up to 5 ETH
                $tolerance_percentage = $base_tolerance + ($adjustment_factor * (0.1 + ($expectedWei / 5000000000000000000) * 0.00025));
            } elseif ($expectedWei <= 8000000000000000000) { // Up to 8 ETH
                $tolerance_percentage = $base_tolerance + ($adjustment_factor * (0.05 + ($expectedWei / 8000000000000000000) * 0.0001));
            } else { // For larger values, minimal tolerance
                $tolerance_percentage = $base_tolerance + ($adjustment_factor * 0.00005);
            }

            // Calculate tolerance in Wei
            $toleranceWei = $expectedWei * $tolerance_percentage;

            // Set a fixed minimum tolerance to avoid too narrow a range for small amounts
            $toleranceWei = max($toleranceWei, 5000); // e.g., 5000 Wei (~0.000005 ETH) as minimum tolerance

            // Calculate lower and upper bounds in Wei
            $lower_bound = $expectedWei - $toleranceWei;
            $upper_bound = $expectedWei + $toleranceWei;

            // Check if the incoming amount is within tolerance
            if ($amount_wei >= $lower_bound && $amount_wei <= $upper_bound) {
                $transaction->update([
                    'status' => 'Success',
                ]);

                $this->generalService->Deposit_Success(
                    $transaction->plan,
                    $transaction->request_deposit_amount,
                    $transaction->crypto,
                    $transaction->amount_crypto,
                    $transaction->user_id,
                    $transaction->transaction_id,
                    null
                );

                event(new AlertDepositSuccessCrypto($transaction->user_id));

                $foundMatch = true;
                break;
            }
        }

        if (!$foundMatch) {
            $status = 'Not Match';
        } else {
            $status = 'Matched';
        }

        $this->generalService->Record_From_Server_Transaction($txid, $address, $from_adress, 'ETH', $amount_eth, $amount_wei, $status, $details);


        return response()->json([
            'status' => $status,
            'lower_bound' => $lower_bound ?? null,
            'upper_bound' => $upper_bound ?? null,
            'totalloop' => $totalloop,
            'amountInBitcoins' => $amount_eth,
            'expectedSatoshis' => $foundMatch ? $amount_wei : null,
        ]);
    }


    public function receiveTransactionUSDT_BSC_BEP20(Request $request)
    {
        $txid = $request->input('txid');
        $amount_usdt = $request->input('amount_usdt');
        $address = $request->input('address');
        $from_address = null; // Use if available in the request
        $details = 'amount wei: '.$request->input('amount_wei');

        $timeLimit = now()->subHours(3);

        // Fetch pending transactions related to USDT-BSC(BEP20)
        $transactions = Transaction::where('crypto', 'USDT-BSC(BEP20)')
            ->where('address', $address)
            ->where('status', 'Pending')
            ->where('created_at', '>=', $timeLimit)
            ->get();

        $foundMatch = false;
        $totalloop = 0;
        $tolerance = 0.0001; // Set tolerance for precision handling
        $expectedAmount = null; // Initialize to track expected amount for later use

        foreach ($transactions as $transaction) {
            $totalloop += 1;

            $expectedAmount = $transaction->request_deposit_amount;

            // Check if the incoming amount is within tolerance
            if (abs($amount_usdt - $expectedAmount) < $tolerance) {
                $transaction->update([
                    'status' => 'Success',
                ]);

                $this->generalService->Deposit_Success(
                    $transaction->plan,
                    $transaction->request_deposit_amount,
                    $transaction->crypto,
                    $transaction->amount_crypto,
                    $transaction->user_id,
                    $transaction->transaction_id,
                    null
                );

                event(new AlertDepositSuccessCrypto($transaction->user_id));

                $foundMatch = true;
                break; // Exit loop after finding the first match
            }
        }

        if (!$foundMatch) {
            $status = 'Not Match';
            Log::warning("No matching transaction found for address: $address, amount: $amount_usdt, txid: $txid");
        } else {
            $status = 'Matched';
        }

        // Logging transaction details to the server
        $lower_bound = $expectedAmount - $tolerance;
        $upper_bound = $expectedAmount + $tolerance;

        $this->generalService->Record_From_Server_Transaction(
            $txid,
            $address,
            $from_address,
            'USDT-BSC(BEP20)',
            $amount_usdt,
            $expectedAmount,
            $status,
            $details
        );

        // Return response to the Node.js script
        return response()->json([
            'status' => $status,
            'lower_bound' => $lower_bound,
            'upper_bound' => $upper_bound,
            'totalloop' => $totalloop,
            'amountInBitcoins' => $amount_usdt,
            'expectedSatoshis' => $foundMatch ? $expectedAmount : null,
        ]);
    }

















    ///Get Detail
    private function getTransactionDetailsBTC($txid)
    {
        try {
            // API endpoint for BlockCypher to get transaction details
            $url = "https://api.blockcypher.com/v1/btc/main/txs/{$txid}?token={$this->blockcypherToken}";

            // Make the HTTP request
            $response = Http::get($url);

            // Check if the request was successful
            if ($response->successful()) {
                $data = $response->json();

                // Extract inputs and outputs
                $inputs = $data['inputs'] ?? [];
                $outputs = $data['outputs'] ?? [];

                // Extract sender addresses from inputs
                $senders = array_map(function ($input) {
                    return $input['addresses'] ?? [];
                }, $inputs);

                // Flatten the array of sender addresses
                $senders = array_merge(...$senders);

                // Extract receiver addresses and amounts from outputs
                $receivers = array_map(function ($output) {
                    return [
                        'address' => $output['addresses'][0] ?? 'Unknown',
                        'amount' => $output['value'] ?? 0
                    ];
                }, $outputs);

                // Convert amounts from satoshis to BTC
                $totalAmountInBtc = array_reduce($receivers, function ($carry, $receiver) {
                    return $carry + ($receiver['amount'] / 100000000);
                }, 0);

                // Format amount
                $formattedAmount = number_format($totalAmountInBtc, 8) . ' BTC';

                return [
                    'senders' => $senders,
                    'receivers' => $receivers,
                    'total_amount' => $formattedAmount
                ];
            } else {
                // Handle error
                return [
                    'error' => 'Transaction not found or API request failed'
                ];
            }
        } catch (\Exception $e) {
            // Handle exceptions
            return [
                'error' => 'An error occurred: ' . $e->getMessage()
            ];
        }
    }


    private function getTransactionDetailsLTC($txid)
    {
        try {
            // API endpoint for BlockCypher to get Litecoin transaction details
            $url = "https://api.blockcypher.com/v1/ltc/main/txs/{$txid}?token={$this->blockcypherToken}";

            // Make the HTTP request
            $response = Http::get($url);

            // Check if the request was successful
            if ($response->successful()) {
                $data = $response->json();

                // Extract inputs and outputs
                $inputs = $data['inputs'] ?? [];
                $outputs = $data['outputs'] ?? [];

                // Extract sender addresses from inputs
                $senders = array_map(function ($input) {
                    return $input['addresses'] ?? [];
                }, $inputs);

                // Flatten the array of sender addresses
                $senders = array_merge(...$senders);

                // Extract receiver addresses and amounts from outputs
                $receivers = array_map(function ($output) {
                    return [
                        'address' => $output['addresses'][0] ?? 'Unknown',
                        'amount' => $output['value'] ?? 0
                    ];
                }, $outputs);

                // Convert amounts from litoshis to LTC (1 LTC = 100,000,000 litoshis)
                $totalAmountInLtc = array_reduce($receivers, function ($carry, $receiver) {
                    return $carry + ($receiver['amount'] / 100000000); // Convert litoshis to LTC
                }, 0);

                // Format amount
                $formattedAmount = number_format($totalAmountInLtc, 8) . ' LTC';

                return [
                    'senders' => $senders,
                    'receivers' => $receivers,
                    'total_amount' => $formattedAmount
                ];
            } else {
                // Handle error
                return [
                    'error' => 'Transaction not found or API request failed'
                ];
            }
        } catch (\Exception $e) {
            // Handle exceptions
            return [
                'error' => 'An error occurred: ' . $e->getMessage()
            ];
        }
    }


    private function getTransactionDetailsBCH($txid)
    {
        try {
            // API endpoint for BlockCypher to get Bitcoin Cash transaction details
            $url = "https://api.blockcypher.com/v1/bch/main/txs/{$txid}?token={$this->blockcypherToken}";

            // Make the HTTP request
            $response = Http::get($url);

            // Check if the request was successful
            if ($response->successful()) {
                $data = $response->json();

                // Extract inputs and outputs
                $inputs = $data['inputs'] ?? [];
                $outputs = $data['outputs'] ?? [];

                // Extract sender addresses from inputs
                $senders = array_map(function ($input) {
                    return $input['addresses'] ?? [];
                }, $inputs);

                // Flatten the array of sender addresses
                $senders = array_merge(...$senders);

                // Extract receiver addresses and amounts from outputs
                $receivers = array_map(function ($output) {
                    return [
                        'address' => $output['addresses'][0] ?? 'Unknown',
                        'amount' => $output['value'] ?? 0
                    ];
                }, $outputs);

                // Convert amounts from satoshis to BCH (1 BCH = 100,000,000 satoshis)
                $totalAmountInBch = array_reduce($receivers, function ($carry, $receiver) {
                    return $carry + ($receiver['amount'] / 100000000); // Convert satoshis to BCH
                }, 0);

                // Format amount
                $formattedAmount = number_format($totalAmountInBch, 8) . ' BCH';

                return [
                    'senders' => $senders,
                    'receivers' => $receivers,
                    'total_amount' => $formattedAmount
                ];
            } else {
                // Handle error
                return [
                    'error' => 'Transaction not found or API request failed'
                ];
            }
        } catch (\Exception $e) {
            // Handle exceptions
            return [
                'error' => 'An error occurred: ' . $e->getMessage()
            ];
        }
    }


    private function getTransactionDetailsETH($txid)
    {
        $etherscanApiKey = 'YOUR_ETHERSCAN_API_KEY';
        $url = "https://api.etherscan.io/api?module=transaction&action=gettxreceiptstatus&txhash={$txid}&apikey={$etherscanApiKey}";

        // Send a request to the Etherscan API to get transaction details
        $client = new \GuzzleHttp\Client();
        $response = $client->get($url);
        $data = json_decode($response->getBody(), true);

        if (isset($data['result'])) {
            return $data['result'];
        } else {
            return 'Transaction details not found';
        }
    }
}
