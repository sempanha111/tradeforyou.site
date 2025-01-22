@extends('Frontend/layout.app')
@section('content')

<div class="banner_wrap banner_wrap_sub">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="banner_left inside">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <h1>Edit Account</h1>
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

                @include('Frontend/layout/massage_bootstrap')

                <form action="{{ route('edit_account_send')}}" method=post  name=editform   class="my_accont">
                    @csrf
                    <table cellspacing=0 cellpadding=2 border=0 width="100%">
                        <tr>
                            <td width="50%">Account Name:</td>
                            <td width="50%">{{ Auth::user()->fullname}}</td>
                        </tr>
                        <tr>
                            <td>Registration date:</td>
                            <td>{{ Auth::user()->created_at->format('F j, Y, g:i a') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Your Full Name:</td>
                            <td><input type=text name=fullname value='{{ Auth::user()->fullname}}' class=inpts size=30>
                                @error('fullname')
                                <div>{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td>User Name:</td>
                            <td><input type=text name=username value='{{ Auth::user()->name}}' class=inpts size=30>
                                @error('username')
                                <div>{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <td>New Password:</td>
                            <td><input type=password name=password value="" class=inpts size=30>
                                @error('password')
                                <div>{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td>Retype Password:</td>
                            <td><input type=password name='retypepassword' value="" class=inpts size=30>
                                @error('retypepassword')
                                <div>{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td>Your PerfectMoney acc no:</td>
                            <td><input type=text class=inpts size=30 name="perfectmoney"
                                    value="{{ Auth::user()->perfect_money }}" data-validate="regexp"
                                    data-validate-regexp="^U\d{5,}$" data-validate-notice="UXXXXXXX"></td>
                        </tr>
                        <tr>
                            <td>Your Payeer acc no:</td>
                            <td><input type=text class=inpts size=30 name="payeer" value="{{ Auth::user()->payeer }}"
                                    data-validate="regexp" data-validate-regexp="^P\d{5,}$"
                                    data-validate-notice="PXXXXXXX"></td>
                        </tr>
                        <tr>
                            <td>Your Bitcoin acc no:</td>
                            <td><input type=text class=inpts size=30 name="bitcoin" value="{{ Auth::user()->bitcoin }}"
                                    data-validate="regexp" data-validate-regexp="^[13][a-km-zA-HJ-NP-Z1-9]{25,34}$"
                                    data-validate-notice="Bitcoin Address"></td>
                        </tr>
                        <tr>
                            <td>Your Litecoin acc no:</td>
                            <td><input type=text class=inpts size=30 name="litecoin"
                                    value="{{ Auth::user()->litecoin }}" data-validate="regexp"
                                    data-validate-regexp="^[LM3][a-km-zA-HJ-NP-Z1-9]{25,34}$"
                                    data-validate-notice="Litecoin Address"></td>
                        </tr>
                        <tr>
                            <td>Your Ethereum acc no:</td>
                            <td><input type=text class=inpts size=30 name="ethereum"
                                    value="{{ Auth::user()->ethereum }}" data-validate="regexp"
                                    data-validate-regexp="^(0x)?[0-9a-fA-F]{40}$"
                                    data-validate-notice="Ethereum Address"></td>
                        </tr>
                        <tr>
                            <td>Your Bitcoin Cash acc no:</td>
                            <td><input type=text class=inpts size=30 name="bitcoin_cash"
                                    value="{{ Auth::user()->bitcoin_cash }}" data-validate="regexp"
                                    data-validate-regexp="^[\w\d]{25,43}$" data-validate-notice="Bitcoin Cash Address">
                            </td>
                        </tr>
                        <tr>
                            <td>Your USDT-BSC(BEP20) acc no:</td>
                            <td><input type=text class=inpts size=30 name="usdt_bsc_bep20"
                                    value="{{ Auth::user()->usdt_bsc_bep20 }}">
                            </td>
                        </tr>
                        <tr>
                            <td>Your E-mail address:</td>
                            <td><input type=text name=email value='{{ Auth::user()->email }}' class=inpts size=30>
                                @error('email')
                                <div>{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <td>&nbsp;</td>
                            <td><input type=submit value="Change Account data" class=sbmt></td>
                        </tr>
                    </table>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
