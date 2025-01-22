@extends('Frontend/layout.app')
@section('content')

<div class="banner_wrap banner_wrap_sub">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="banner_left inside">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <h1>About Trade30Minutes</h1>
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
<div class="welcome_wrap about_top">
    <div class="container">
        <div class="row">

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <h1>Welcome to Trade30Minutes!</h1>
                <p>Crypto-currency mining is considered to be one of the most promising and most liquid areas for
                    investment in the last years. The vast majority of Internet users do not have sufficient
                    opportunities to purchase expensive computing equipment, and the profitability of small
                    investments in this area of activity is very doubtful. Our company offers an alternative option
                    consisting in the rental of computing capacities for the cloud mining of crypto-currencies. All
                    adult investors are invited to cooperate, and each participant of the project is guaranteed
                    transparency and stability of dividends. In addition to the transfer of mining equipment for
                    rent to investors, Trade30Minutes can offer a number of complete solutions for better
                    interaction between investors and partners with the management. The company's online resource
                    uses the latest technologies to protect the transfer of confidential data and financial
                    transactions, and we also use special software to optimize management processes and ensure the
                    continuity of crypto-currency mining.</p>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <img src="{{ asset('assets/images/about-left.webp')}}" alt="">
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
                                        <a href="crt.png')}}" target="_blank" class="details-but">View Certificate</a>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 border-right">
                                        <img src="{{ asset('assets/images/company2.png')}}" alt="">
                                        <h2>Company Location</h2>
                                        <p>Portlethen, Aberdeen, Scotland, AB12 4UN </p>
                                        <a href="https://beta.companieshouse.gov.uk/company/SC769139"
                                            target="_blank" class="details-but">View Details</a>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <img src="{{ asset('assets/images/company3.png')}}" alt="">
                                        <h2>Contact Us</h2>
                                        <p><a
                                                href="mailto:admin@trade30minutes.cloud">admin@trade30minutes.cloud</a>
                                        </p>
                                        <a href="?a=support" target="_blank" class="details-but">Support</a>
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
                <p>Trade30Minutes is paying for the popularization of its investment program and anyone can be
                    rewarded. To benefit from this, you have to tell your friends, relatives or colleagues about our
                    company. We offer 2 levels referral commissions: The first level of direct referrals from you
                    will entitle you to a commission of 10%, and second level gives you commission of 3%. You can
                    surely make a lot of money from the referral commissions you get!
                </p>
                <img src="{{ asset('assets/images/levels.png')}}" class="img-levels" alt="">
            </div>

        </div>
    </div>



</div>


@endsection
