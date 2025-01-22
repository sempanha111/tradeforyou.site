@extends('Frontend/layout.app')
@section('content')
<div class="banner_wrap banner_wrap_sub">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="banner_left inside">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <h1>Ask for Withdraw</h1>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="social">

                            </div>
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
                <div class="top ">
                    <p>State:</p>
                    <h2>Prepared</h2>
                </div>
                <div class="top white">
                    <p>Date: </p>
                    <h2>{{ \Carbon\Carbon::now()->format('M-d-y H:i:s') }} </h2>
                </div>
                <div class="top white">
                    <p>Payment System: </p>
                    <h2 style="color: white">{{ $payment_name }}</h2>
                </div>
                <div class="top white">
                    <p>Amount:</p>
                    <h2 style="color: white">$ {{ $withdraw_request }}</h2>
                </div>
                @if($wallet != 'Perfect Money' && $wallet != 'Payeer' && $wallet != 'USDT-BSC(BEP20)')
                <div class="top white">
                    <p>Amount:</p>
                    <h2 style="color: white"> {{ $amount_crypto }} {{$wallet}}</h2>
                </div>
                @endif
                <div class="top white">
                    <p>To Account:</p>
                    <h2 style="color: white"> {{ $account }}</h2>
                </div>


            </div>

            <form action="{{ route('withdraw_send')}}" method="post">
                @csrf
                <input type="submit" value="Confirm" class="sbmt">
            </form>

        </div>
    </div>
</div>
@endsection

