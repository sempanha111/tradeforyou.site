@extends('Frontend/layout.app')
@section('content')
<div class="banner_wrap banner_wrap_sub">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="banner_left inside">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <h1>{{$filter_data['type']}} History</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="member_wrap">

    <div class="container">
        <div class="big-stats">
            <div class="row">
                <div class="col-lg-12 col-md12 col-sm-12 col-xs-12">
                    @include('Frontend/layout/membersidebar')
                </div>
            </div>
        </div>
    </div>
    <div class="member_inside">
        <div class="member-container">
            <div class="member-right">

                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tbody>
                        <tr>
                            <td colspan="3">
                                <h3>History:</h3>
                            </td>
                        </tr>
                        <tr>
                            <form action="{{route('filter')}}" method="post" name="opts">
                                @csrf
                                <td>
                                    <select name="type" class="inpts">
                                        <option value="All Transactions" {{ $filter_data['type'] =='All Transactions' ? 'selected'
                                            : '' }}>All transactions</option>
                                        <option value="Deposit" {{ $filter_data['type'] =='Deposit' ? 'selected' : '' }} >
                                            Deposit
                                        </option>
                                        <option value="Withdrawal" {{ $filter_data['type'] =='Withdrawal' ? 'selected' : '' }}>
                                            Withdrawal</option>
                                        <option value="Earning" {{ $filter_data['type'] =='Earning' ? 'selected' : '' }}>Earning
                                        </option>
                                        <option value="Referral" {{ $filter_data['type'] =='Referral' ? 'selected' : '' }}>
                                            Referral commission</option>
                                    </select>
                                    <br><img src="images/q.gif" width="1" height="4"><br>
                                    <select name="crypto_type" class="inpts">
                                        <option value="All Currencies" {{ $filter_data['crypto_type'] =='All Currencies'
                                            ? 'selected' : '' }}>All eCurrencies</option>
                                        <option value="Perfect Money" {{ $filter_data['crypto_type'] =='Perfect Money' ? 'selected' : '' }}>Perfect Money </option>
                                        <option value="Payeer" {{ $filter_data['crypto_type'] =='Payeer' ? 'selected' : '' }}>Payeer </option>
                                        <option value="BTC" {{ $filter_data['crypto_type'] =='BTC' ? 'selected' : '' }}>Bitcoin </option>
                                        <option value="LTC" {{ $filter_data['crypto_type'] =='LTC' ? 'selected' : '' }}>Litecoin </option>
                                        <option value="BCH" {{ $filter_data['crypto_type'] =='BCH' ? 'selected' : '' }}>Bitcoin  Cash</option>
                                        <option value="ETH" {{ $filter_data['crypto_type'] =='ETH' ? 'selected' : '' }}>Ethereum</option>
                                        <option value="USDT-BSC(BEP20)" {{ $filter_data['crypto_type'] =='USDT-BSC(BEP20)' ? 'selected' : '' }}>USDT-BSC(BEP20)</option>
                                    </select>
                                </td>
                                <td align="right">
                                    From:
                                    <!-- From Date Selection -->
                                    <label>From:</label>
                                    <select name="month_from" class="inpts">
                                        <option value="1" {{ $filter_data['month_from'] ==1 ? 'selected' : '' }}>Jan</option>
                                        <option value="2" {{ $filter_data['month_from'] ==2 ? 'selected' : '' }}>Feb</option>
                                        <option value="3" {{ $filter_data['month_from'] ==3 ? 'selected' : '' }}>Mar</option>
                                        <option value="4" {{ $filter_data['month_from'] ==4 ? 'selected' : '' }}>Apr</option>
                                        <option value="5" {{ $filter_data['month_from'] ==5 ? 'selected' : '' }}>May</option>
                                        <option value="6" {{ $filter_data['month_from'] ==6 ? 'selected' : '' }}>Jun</option>
                                        <option value="7" {{ $filter_data['month_from'] ==7 ? 'selected' : '' }}>Jul</option>
                                        <option value="8" {{ $filter_data['month_from'] ==8 ? 'selected' : '' }}>Aug</option>
                                        <option value="9" {{ $filter_data['month_from'] ==9 ? 'selected' : '' }}>Sep</option>
                                        <option value="10" {{ $filter_data['month_from'] ==10 ? 'selected' : '' }}>Oct</option>
                                        <option value="11" {{ $filter_data['month_from'] ==11 ? 'selected' : '' }}>Nov</option>
                                        <option value="12" {{ $filter_data['month_from'] ==12 ? 'selected' : '' }}>Dec</option>
                                    </select> &nbsp;
                                    <select name="day_from" class="inpts">
                                        @for ($day = 1; $day <= 31; $day++) <option value="{{ $day }}" {{
                                            $filter_data['day_from'] ==$day ? 'selected' : '' }}>{{ $day }}</option>
                                            @endfor
                                    </select> &nbsp;

                                    <select name="year_from" class="inpts">
                                        <option value="2024" >2024
                                        </option>
                                    </select><br><img src="images/q.gif" width="1" height="4"><br>

                                    To: <select name="month_to" class="inpts">
                                        <option value="1" {{ $filter_data['month_to'] ==1 ? 'selected' : '' }}>Jan</option>
                                        <option value="2" {{ $filter_data['month_to'] ==2 ? 'selected' : '' }}>Feb</option>
                                        <option value="3" {{ $filter_data['month_to'] ==3 ? 'selected' : '' }}>Mar</option>
                                        <option value="4" {{ $filter_data['month_to'] ==4 ? 'selected' : '' }}>Apr</option>
                                        <option value="5" {{ $filter_data['month_to'] ==5 ? 'selected' : '' }}>May</option>
                                        <option value="6" {{ $filter_data['month_to'] ==6 ? 'selected' : '' }}>Jun</option>
                                        <option value="7" {{ $filter_data['month_to'] ==7 ? 'selected' : '' }}>Jul</option>
                                        <option value="8" {{ $filter_data['month_to'] ==8 ? 'selected' : '' }}>Aug</option>
                                        <option value="9" {{ $filter_data['month_to'] ==9 ? 'selected' : '' }}>Sep</option>
                                        <option value="10" {{ $filter_data['month_to'] ==10 ? 'selected' : '' }}>Oct</option>
                                        <option value="11" {{ $filter_data['month_to'] ==11 ? 'selected' : '' }}>Nov</option>
                                        <option value="12" {{ $filter_data['month_to'] ==12 ? 'selected' : '' }} >Dec
                                        </option>
                                    </select>&nbsp;
                                    <select name="day_to" class="inpts">
                                        @for ($day = 1; $day <= 31; $day++) <option value="{{ $day }}" {{
                                            $filter_data['day_to'] ==$day ? 'selected' : '' }}>{{ $day }}</option>
                                            @endfor
                                    </select> &nbsp;

                                    <select name="year_to" class="inpts">
                                        <option value="2024">2024</option>
                                    </select>

                                </td>
                                <td>
                                    &nbsp; <input type="submit" value="Go" class="sbmt">
                                </td>
                            </form>
                        </tr>
                    </tbody>
                </table>

                <br><br>
                <table cellspacing="1" cellpadding="2" border="0" width="100%">
                    <tbody>
                        <tr>
                            <td class="inheader"><b>Type</b></td>
                            <td class="inheader" width="200"><b>Amount</b></td>
                            <td class="inheader" width="170"><b>Date</b></td>
                        </tr>

                        @php
                        $total = 0;
                        $generalService = app()->make(App\Services\GeneralService::class);
                        @endphp

                        @if($datas->isEmpty())
                            <tr>
                                <td colspan="3" align="center">No transactions found</td>
                            </tr>
                        @else
                            @foreach($datas as $data)

@php
    // Initialize necessary variables
    $transaction_date = $data->created_at->format('M-d-y H:i:s');
    $small_logo = $generalService->Get_Own_Address_smalllogo($data->money)['small_logo'];
    $amount = 0; // Initialize $amount to avoid undefined variable error
    $massage = ''; // Initialize massage to avoid undefined variable error

    if ($data->type === 'Deposit') {


        $descript_plan = $generalService->Get_Des_plan($data->plan)['descript_plan'];
        $amount = $data->request_deposit_amount;

        $deposit = \App\Models\Deposit::where('transaction_id', $data->transaction_id)->Where('payer_account', '!=' , null)->first();

        if (!$deposit) {
            // This block will run if a Deposit is found where both conditions match.
            if ($data->status === 'Success') {
                $massage = 'The deposit on plan ' . $descript_plan . ' has been processed successfully.';
            } else {
                $massage = 'The deposit on plan ' . $descript_plan . ' is pending, waiting for payment.';
            }
        } else {
            // This block runs if no Deposit is found (meaning no matching record with null payer_account).
            if ($data->status === 'Success') {
                $massage = 'The deposit on plan ' . $descript_plan . ' to the account. Transaction ID: '
                    . $data->transaction_id . ' has been processed successfully.';
            } else {
                $massage = 'The deposit on plan ' . $descript_plan . '. Transaction ID: '
                    . $data->transaction_id . ' is pending, waiting for the administrator to check the statistics.';
            }
        }


        $small_logo = $generalService->Get_Own_Address_smalllogo($data->crypto)['small_logo'];





    } elseif ($data->type === 'Withdrawal') {
        $coloum = $generalService->Get_coloum_wallet_user($data->money)['coloum'];
        $amount = $data->withdraw_request;
        if ($data->status === 'Approved') {
            $massage = 'The Withdrawal processed to the account ' . $data->user->$coloum . '. Batch number: '.$data->batch.'  successfully ';
        } else {
            $massage = 'Withdrawal request submitted successfully. We will review it shortly.';
        }
    } elseif ($data->type === 'Earning') {
        $descript_plan = $generalService->Get_Des_plan($data->from)['descript_plan'];
        $amount = $data->amount;
        $massage = 'The Earning from Profit ' . $descript_plan;
    } elseif ($data->type === 'Referral') {
        $amount = $data->amount;
        $massage = 'The Earning Referral Commission from "' . $data->from . '" has been processed to the account';
    } else {
        $amount = $data->amount;
        $massage = 'Unknown transaction of $';
    }

    $total += $amount; // Add amount to the total
@endphp

                            <tr>
                                <td class="item">
                                    <b>{{ $data->type }}</b>
                                </td>
                                <td class="item" width="200" align="right">
                                    <b>${{ $amount }}</b>
                                    <img src="{{ asset('assets_backend/images/small_crypto/' . $small_logo) }}" alt="">
                                </td>
                                <td class="item" width="170" align="center">{{ $data->created_at->format('M-d-y H:i:s') }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">{{ $massage }}</td>
                            </tr>
                            @endforeach
                        @endif

                        <tr>
                            <td colspan="2">Total:</td>
                            <td align="right"><b>$ {{ number_format($total, 2) }}</b></td>
                        </tr>
                    </tbody>
                </table>



            </div>

        </div>

    </div>

</div>



@endsection
