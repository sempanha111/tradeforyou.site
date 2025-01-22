@extends('Frontend/layout.app')
@section('content')
<div class="banner_wrap banner_wrap_sub">
    <div class="container">
        @include('Frontend/layout/massage_bootstrap')

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="banner_left inside">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <h1>Account Dashboard</h1>
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

                <div class="member_left">
                    <div class="row">

                        <br><br>
                        <br>


                        <div class="col-lg-4 col-md4 col-sm-12 col-xs-12">


                            <div class="left">
                                <div class="option">Your Username</div>
                                <span><img src="./assets/images/iconusername.png" alt=""></span>
                                <h2>{{ Auth::user()->fullname}}</h2>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md4 col-sm-12 col-xs-12">
                            <div class="mid1">
                                <div class="option">Current IP</div>
                                <span><img src="./assets/images/iconyourip.png" alt=""></span>
                                <h2>{{ request()->getClientIp() }}</h2>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md4 col-sm-12 col-xs-12">
                            <div class="mid2">
                                <div class="option">Registration Date</div>
                                <span><img src="./assets/images/iconlastaccess.png" alt=""></span>
                                <h2>{{ Auth::user()->created_at->format('M-d-y H:i:s')}}</h2>
                            </div>
                        </div>

                    </div>

                </div>




                <div class="row">
                    <div class="col-lg-8 col-md8 col-sm-12 col-xs-12">
                        <div class="top">
                            <p>Referral Link:</p>
                            <h2>https://tradeforyou.site/signup?rel={{ Auth::user()->fullname }}</h2>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md4 col-sm-12 col-xs-12">
                        <div class="reinvest-but">
                            <a href="{{ route('deposit')}}">Start Your First Invest Now!</a>
                        </div>
                    </div>
                </div>





                <div class="account_mid">
                    <div class="mem_mid one">
                        <div class="mem_mid_left"><span class="acc-bal">&nbsp;</span></div>
                        <div class="mem_mid_right">
                            <p class="big">$ {{ number_format($account_balance, 2) }}</p>
                            <strong>Account Balance</strong>
                            <a href="{{ route('deposit')}}" class="acc_button two"><span>Make A Deposit</span></a>
                        </div>
                    </div>
                    <div class="mem_mid two">
                        <div class="mem_mid_left"><span class="ear-tot">&nbsp;</span></div>
                        <div class="mem_mid_right">
                            <p class="big">$ {{ number_format($earn_only,2) }}</p>
                            <strong>Earned Total</strong>
                            <a href="{{ route('withdraw')}}" class="acc_button one"><span>Withdraw Funds</span></a>
                        </div>
                    </div>
                    <div class="mem_mid three">
                        <div class="mem_mid_left"><span class="acc-dep">&nbsp;</span></div>
                        <div class="mem_mid_right">
                            <p class="big">$ {{ number_format($total_deposit_actives, 2)}}</p>
                            <strong>Active Deposit</strong>
                            <a href="{{ route('referrals')}}" class="acc_button one"><span>Get Banners</span></a>
                        </div>
                    </div>
                </div>
                <div class="account-bottom">
                    <div class="detailed-stats">
                        <div class="pull-left">
                            <div class="detailed-stats-box detailed-stats-box2">
                                <p class="detailed-stats-img"><img src="./assets/images/last_deposit_icon.png" alt="">
                                </p>
                                <p>Last Deposit</p>
                                <h3>$ {{ number_format($total_last_deposit, 2)}}</h3>
                            </div>
                            <div class="detailed-stats-box">
                                <p class="detailed-stats-img"><img src="./assets/images/total_deposit_icon.png" alt="">
                                </p>
                                <p>Total Deposit</p>
                                <h3>$ {{ number_format($total_deposit, 2)}}</h3>
                            </div>

                        </div>
                        <div class="pull-right">

                            <div class="detailed-stats-box detailed-stats-box2">
                                <p class="detailed-stats-img"><img src="./assets/images/last_withdraw_icon.png" alt="">
                                </p>
                                <p>Last Withdrawal</p>
                                <h3>$ {{ number_format($last_withdraw, 2)}}</h3>
                            </div>
                            <div class="detailed-stats-box">
                                <p class="detailed-stats-img"><img src="./assets/images/total_withdraw_icon.png" alt="">
                                </p>
                                <p>Total Withdrew</p>
                                <h3>$ {{ number_format($total_withdraw_success, 2) }}</h3>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
