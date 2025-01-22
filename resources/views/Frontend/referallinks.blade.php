@extends('Frontend/layout.app')
@section('content')
<div class="banner_wrap banner_wrap_sub">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="banner_left inside">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <h1>Your Referrals</h1>
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

                <div class="top">
                    <p>Referral Link:</p>
                    <h2>https://tradeforyou.site/signup?rel={{ Auth::user()->fullname }}</h2>
                </div><br><br>

                <br>
                <div class="my_accont">
                    <table width="100%" cellspacing="4" cellpadding="4">
                        <tbody>
                            <tr>
                                <td width="50%" class="item"><strong>Referrals:</strong></td>
                                <td width="50%" class="item">{{$reffals['total_referral']}}</td>
                            </tr>
                            <tr>
                                <td class="item"><strong>Active Referrals:</strong></td>
                                <td class="item">{{$reffals['total_referral']}}</td>
                            </tr>
                            <tr>
                                <td class="item"><strong>Total Referral Commission:</strong></td>
                                <td class="item">$ {{$reffals['total_amount']}}</td>
                            </tr>
                        </tbody>
                    </table>



                </div>
                <div class="clear"></div>


            </div>
        </div>

    </div>
</div>

@endsection
