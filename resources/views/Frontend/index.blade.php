@extends('Frontend/layout.app')

@section('content')


<div class="banner_wrap">
    <div class="container">
        @include('Frontend/layout/massage_bootstrap')
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="banner_left">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <h1><span>72 Hours</span> MINING &amp; WITHDRAW INSTANTLY</h1>
                            <p><a href="{{ route('signup')}}" class="access">Register Now</a></p>
                            <div class="social">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="profit-container">

    <div class="container">


        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="security-container">
                    <div class="row">
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <img src="{{ asset('assets/images/feature1.png')}}" alt="">
                            <h2>Comodo SSL Certificate</h2>
                            <p>All investors transactions are totally safe and secure</p>

                        </div>

                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <img src="{{ asset('assets/images/feature2.png')}}" alt="">
                            <h2>DDoS Protection</h2>
                            <p>Powerful DDoS protection system guarantees stable service work</p>
                        </div>

                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <img src="{{ asset('assets/images/feature3.png')}}" alt="">
                            <h2>Dedicated Server</h2>
                            <p>We use a very powerful dedicated server for fast performance</p>
                        </div>

                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <img src="{{ asset('assets/images/feature4.png')}}" alt="">
                            <h2>Instant Withdrawals</h2>
                            <p>Request payment anytime and get it instantly</p>
                        </div>


                    </div>
                </div>

            </div>
        </div>


        <div class="reinvest-but reinvest-home">
            <div class="row">
                <div class="col-lg-12 col-md12 col-sm-12 col-xs-12">
                    <a href="{{ route('signup')}}">Get Early Access</a>
                </div>
            </div>

        </div>



        <h1><span>Investment</span> Plans</h1>


    </div>
</div>







<div class="plans-container">
    <div class="container">
        <div class="row">
            <div class="plan_wrap">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="plan_box2">
                        <h2>How to make <span>profit</span></h2>
                        <br>
                        <div><img src="{{ asset('assets/images/how1.png')}}" alt="">
                            <p>Fill in the registration form to open account</p>
                        </div>
                        <div><img src="{{ asset('assets/images/how2.png')}}" alt="">
                            <p>Choose any plan you like</p>
                        </div>
                        <div><img src="{{ asset('assets/images/how3.png')}}" alt="">
                            <p>Watch your profit grow</p>
                        </div>
                        <div><img src="{{ asset('assets/images/how4.png')}}" alt="">
                            <p>Get instant payment upon request</p>
                        </div>
                        <a href="{{ route('signup')}}">Register Now</a>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">

                    <div class="row">
                        <div class="plan_box option1">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="plan-left">
                                    <div class="option">Option 1</div>
                                    <h2>130<span>%</span></h2>
                                </div>
                                <div class="plan-right">
                                    <p>after <span>72</span> Hours</p>
                                    <ul>
                                        <li>Minimum Deposit 1 USD</li>
                                        <li>Maximum Deposit 5 USD</li>
                                    </ul>
                                </div>


                                <div class="plan_but">
                                    <a href="{{ route('signup')}}">Register Now</a>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--end row-->

                    <div class="row">
                        <div class="plan_box option2">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="plan-left">
                                    <div class="option">Option 2</div>
                                    <h2>175<span>%</span></h2>
                                </div>
                                <div class="plan-right">
                                    <p>after <span>72</span> Hours</p>
                                    <ul>
                                        <li>Minimum Deposit 5 USD</li>
                                        <li>Maximum Deposit 15 USD</li>
                                    </ul>
                                </div>

                                <div class="plan_but">
                                    <a href="{{ route('signup')}}">Register Now</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--end row-->

                    <div class="row">
                        <div class="plan_box option3">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="plan-left">
                                    <div class="option">Option 3</div>
                                    <h2>200<span>%</span></h2>
                                </div>
                                <div class="plan-right">
                                    <p>after <span>72</span> Hours</p>
                                    <ul>
                                        <li>Minimum Deposit 15 USD</li>
                                        <li>Maximum Deposit 30 USD</li>
                                    </ul>
                                </div>

                                <div class="plan_but">
                                    <a href="{{ route('signup')}}">Register Now</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--end row-->
                    <br>
                    <div class="row">
                        <div class="plan_box option2">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="plan-left">
                                    <div class="option">Option 4</div>
                                    <h2>245<span>%</span></h2>
                                </div>
                                <div class="plan-right">
                                    <p>after <span>72</span> Hours</p>
                                    <ul>
                                        <li>Minimum Deposit 30 USD</li>
                                        <li>Maximum Deposit 50 USD</li>
                                    </ul>
                                </div>

                                <div class="plan_but">
                                    <a href="{{ route('signup')}}">Register Now</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--end row-->
                    <br>
                    <div class="row">
                        <div class="plan_box option1">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="plan-left">
                                    <div class="option">Option 5</div>
                                    <h2>375<span>%</span></h2>
                                </div>
                                <div class="plan-right">
                                    <p>after <span>72</span> Hours</p>
                                    <ul>
                                        <li>Minimum Deposit 50 USD</li>
                                        <li>Maximum Deposit 200 USD</li>
                                    </ul>
                                </div>

                                <div class="plan_but">
                                    <a href="{{ route('signup')}}">Register Now</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--end row-->


                </div>
            </div>
        </div>
    </div>

</div>

<div class="welcome_wrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <h1>Welcome to Tradeforyou!</h1>
                <p>Welcome to the website of Tradeforyou! If you find yourself here, you are definitely in search
                    of reliable and profitable investment. Yes, you are just at the right place! Our company offers
                    trust assets management of the highest quality on the basis of foreign exchange and profitable
                    trade through Bitcoin exchanges. There is no other worldwide financial market that can guarantee
                    a daily ability to generate constant profit with the large price swings of Bitcoin. Proposed
                    modalities for strengthening cooperation will be accepted by anyone who uses cryptocurrency and
                    knows about its fantastic prospects. Your deposit is working on an ongoing basis, and makes
                    profit every day with the ability to withdraw profit instantly. Join our company today and start
                    making high profits!</p>
                <p><a class="info">More Information</a></p>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="about-right">

                </div>
            </div>
        </div>
    </div>
</div>







<div class="referral_wrap">

    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="company-section">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="cert-container">
                                <img src="{{ asset('assets/images/certificate.png')}}" alt="">
                                <a href="crt.png')}}" class="cert-view" target="_blank"><img
                                        src="{{ asset('assets/images/view.png')}}" alt=""></a>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                            <div class="company-right">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 border-right">
                                        <img src="{{ asset('assets/images/company1.png')}}" alt="">
                                        <h2>Registered Company</h2>
                                        <p>EVERY MINUTE LTD, UK #SC769139</p>
                                        <a class="details-but">View Certificate</a>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 border-right">
                                        <img src="{{ asset('assets/images/company2.png')}}" alt="">
                                        <h2>Company Location</h2>
                                        <p>Portlethen, Aberdeen, Scotland, AB12 4UN </p>
                                        <a href="https://beta.companieshouse.gov.uk/company/SC769139" target="_blank"
                                            class="details-but">View Details</a>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <img src="{{ asset('assets/images/company3.png')}}" alt="">
                                        <h2>Contact Us</h2>
                                        <p><a href="mailto:admin@tradeforyou.site">admin@tradeforyou.site</a>
                                        </p>
                                        <a href="/support" class="details-but">Support</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <h3><span>Referral</span> commission</h3>
                <p>Tradeforyou is paying for the popularization of its investment program and anyone can be
                    rewarded. To benefit from this, you have to tell your friends, relatives or colleagues about our
                    company. We offer 2 levels referral commissions: The first level of direct referrals from you
                    will entitle you to a commission of 10%, and second level gives you commission of 3%. You can
                    surely make a lot of money from the referral commissions you get!
                </p>
                <img src="{{ asset('assets/images/levels.png')}}" class="img-levels" alt="">
            </div>

        </div>
    </div>

    <div class="container">
        <div class="lasttenwrap1" id="stats">
            @include('Frontend/layout/stats', [
            'days' => $days,
            'total_member' => $total_member,
            'total_deposit' => $total_deposit,
            'total_withdraw' => $total_withdraw,
            ])
        </div>
        <br><br>

        <div class="lasttenwrap1" id="last_transaction">
            @include('Frontend/layout/last_transactions', [
            'depositData' => $depositData,
            'withdrawalData' => $withdrawalData
            ])
        </div>

    </div>

</div>


<script>


</script>

@endsection
