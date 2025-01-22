@extends('Frontend/layout.app')
@section('content')
<div class="banner_wrap banner_wrap_sub">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="banner_left inside">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <h1>Confirm Your Deposit</h1>
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
</div>
<div class="member_inside">
    <div class="member-container">
        <div class="member-right">
            @include('Frontend/layout/massage_bootstrap')

            <p>Your Requested Deposit Amount is $ {{ number_format($data['request_deposit_amount'], 7) }}</p>
            @if($data['type'] === 'Payeer Manual')

            <p>The PAYEER of TRADEFORYOU is P1123089445. After the deposit, please submit your deposit information
                below.</p>

            @endif
            <table cellspacing="0" cellpadding="2" class="form deposit_confirm">
                <tbody>
                    <tr>
                        <th>Plan:</th>
                        <td> {{ $data['descript_plan']}}</td>
                        <td rowspan="8">
                            @if($data['type'] != 'Perfect Money' && $data['type'] != 'Payeer')
                            <img id="coin_payment_image" src="{{ asset($data['qr_crypto'])}}" style="max-width:120px">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Profit:</th>
                        <td>{{$data['profit_percent']}} </td>
                    </tr>
                    <tr>
                        <th>Principal Return:</th>
                        <td>Yes</td>
                    </tr>
                    <tr>
                        <th>Principal Withdraw:</th>
                        <td>Yes</td>
                    </tr>
                    <tr>
                        <th>Credit Amount:</th>
                        <td>${{$data['request_deposit_amount']}}</td>
                    </tr>

                    <tr>
                        <th>Deposit Fee:</th>
                        <td>0.00% + $0.00 (min. $0.00 max. $0.00)</td>
                    </tr>

                    <tr>
                        <th>Debit Amount:</th>
                        <td>${{$data['request_deposit_amount']}}</td>
                    </tr>
                    @if(trim($data['type']) !== 'Perfect Money' && trim($data['type']) !== 'Payeer' && trim($data['type']) !== 'Payeer Manual')
                    <tr>
                        <th>{{ $data['type'] }} Amount:</th>
                        <td>{{ $data['amount_crypto'] }} {{ $data['type'] }}</td>
                    </tr>
                    @endif


                </tbody>
            </table>

            @if($data['type'] === 'Perfect Money')
            <div class="d-flex gap-5">
                <form action="https://perfectmoney.com/api/step1.asp" method="POST" class="d-flex ">
                    @csrf
                    <input type="hidden" name="PAYEE_ACCOUNT" value="U47746648">
                    <input type="hidden" name="PAYEE_NAME" value="TRADEFORYOU">
                    <input type="hidden" name="PAYMENT_ID" value="{{$data['generate_payment_id']}}">
                    <input type="hidden" name="PAYMENT_AMOUNT" value="{{$data['request_deposit_amount']}}"><BR>
                    <input type="hidden" name="PAYMENT_UNITS" value="USD">
                    <input type="hidden" name="STATUS_URL" value="{{ route('handleCallbackPerfectMoney')}}">
                    <input type="hidden" name="PAYMENT_URL" value="{{ route('handleCallbackPerfectMoney')}}">
                    <input type="hidden" name="PAYMENT_URL_METHOD" value="POST">
                    <input type="hidden" name="NOPAYMENT_URL" value="{{ route('deposit_failure')}}">
                    <input type="hidden" name="NOPAYMENT_URL_METHOD" value="GET">
                    <input type="hidden" name="SUGGESTED_MEMO" value="Plan {{$data['descript_plan']}}">
                    <input type="hidden" name="BAGGAGE_FIELDS" value="">
                    <input type="submit" name="PAYMENT_METHOD" value="Process">
                </form>


                <a href="{{route('deposit')}}">
                    <input type="submit" value="Cancel" class="sbmt">
                </a>
            </div>
            @elseif($data['type'] === 'Payeer')
            <form method="POST" action="https://payeer.com/merchant/">
                <input type="hidden" name="m_shop" value="{{$data['m_shop']}}">
                <input type="hidden" name="m_orderid" value="{{$data['m_orderid']}}">
                <input type="hidden" name="m_amount" value="{{$data['m_amount']}}">
                <input type="hidden" name="m_curr" value="{{$data['m_curr']}}">
                <input type="hidden" name="m_desc" value="{{$data['m_desc']}}">
                <input type="hidden" name="m_sign" value="{{$data['m_sign']}}">
                <input type="submit" value="Process">
            </form>
            @elseif($data['type'] === 'Payeer Manual')

            <form action="{{ route('deposit_send')}}" method="post" name="editform" class="my_accont">
                @csrf
                <table cellspacing="0" cellpadding="2" border="0" width="100%">
                    <tbody>

                        <tr>
                            <td>Payer Account :</td>
                            <td>
                                <input type="text" name="payer_account" value="" class="inpts" size="30">
                            </td>
                        </tr>
                        <tr>
                            <td>Transaction ID :</td>
                            <td>
                                <input type="text" name="transaction_id" value="" class="inpts" size="30">
                            </td>
                        </tr>


                        <tr>
                            <td>&nbsp;</td>
                            <td><input type="submit" value="Save" class="sbmt"></td>
                        </tr>
                    </tbody>
                </table>
            </form>

            @elseif($data['type'] === 'CoinBase')

            <form action="{{ route('paymentcoinbasecreate') }}" method="POST">
                @csrf
                <input type="hidden" name="amount" placeholder="Amount" value="{{$data['request_deposit_amount']}}"
                    required>
                <input type="hidden" name="payment_id" placeholder="Amount" value="{{$data['generate_payment_id']}}"
                    required>
                <input type="submit"></button>
            </form>

            @else

            <div class="btc_form btc9" id="btc_form">Please send <b>{{ $data['amount_crypto']}} {{$data['type']}}</b> to
                <i> <a href="#">{{ $data['my_wallet']}}</a></i><br>
            </div>
            <div id="placeforstatus">
                <div class="payment_status"><b>Order status:</b> <span class="status_text"
                        id="status_text{{Auth::id()}}">Waiting for payment</span>
                </div>
            </div>

            @endif




        </div>

    </div>
    <!--end operatonal area-->

</div>



@include('Frontend/layout/footer')
@endsection
