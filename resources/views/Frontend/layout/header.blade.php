@php

$generalService = app()->make(App\Services\GeneralService::class);
$date = $generalService->getFormattedDateTime();

$bitcoinprice = $generalService->Get_PriceOfCrypto('BTC');


@endphp

<div class="header_wrap">
    <div class="header_top">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <img src="{{ asset('assets/images/top-ic1.png')}}" alt="">Registered Company: <a href="#"
                        target="_blank"><span>#SC769139</span>
                    </a>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <img src="{{ asset('assets/images/top-ic2.png')}}" alt="">Date &amp; Time: {{$date}}</span>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <img src="{{ asset('assets/images/top-ic3.png')}}" alt="">Live Price: 1 BTC = <span
                        class="bitCoin">${{$bitcoinprice}}</span>
                </div>

            </div>
        </div>
    </div>
</div>
<nav id="mainNav" class="navbar navbar-default">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="logo fadeInDown wow"><a href="/"><img src="{{ asset('assets/images/logo.png')}}"
                            alt=""></a></div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-5 col-xs-12">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle
                            navigation</span> Menu <i class="fa fa-bars"></i> </button>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav fadeInDown wow">
                        <li><a href="/">Home</a></li>
                        <li><a href="/about">About Us</a></li>
                        <li><a href="/news">News</a></li>
                        <li><a href="/faq">faq</a></li>
                        <li><a href="/affiliates">Affiliate Program</a></li>
                        <li><a href="/support">Support</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                <div class="login_wrap fadeInDown wow">
                    @if(Auth::check())
                    <div class="auth-container">

                        <div class="signup">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </div>

                        <div class="login">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="javascript:void(0)" onclick="this.closest('form').submit();" style="display: inline-flex; align-items: center;">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                            </form>
                        </div>

                    </div>
                    @else


                    <div class="signup"><a href="{{ route('signup')}}">signup</a></div>
                    <div class="login"><a href="/login">login</a></div>

                    @endif

                </div>
            </div>
        </div>
    </div>
</nav>
