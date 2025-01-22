@extends('Frontend/layout.app')
@section('content')
<div class="banner_wrap banner_wrap_sub">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="banner_left inside">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <h1>Withdraw Funds</h1>
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

                <h3 class="sub-title gradient-text" style="margin-top:30px;">

                    <span>Your Account Balance: $<b>{{ $account_balance }}</b></span><b>
                    </b>
                </h3><b><b>Pending Withdrawals: ${{ $total_panding }} </b>
                </b>

                <form action="{{ route('withdraw_checkout_sent') }}" method="post">
                    @csrf
                    <table cellspacing="0" cellpadding="2" border="0" width="100%">
                        <tbody>
                            <tr>
                                <th>&nbsp;</th>
                                <th>Processing</th>
                                <th>Available</th>
                                <th>Pending</th>
                                <th>Account</th>
                            </tr>

                            <!-- Perfect Money Row -->
                            <tr>
                                <td width=10>
                                    <input type="radio" name="wallet" value="Perfect Money" {{ old('wallet') == 'Perfect Money' ? 'checked' : '' }} checked>
                                </td>
                                <td>
                                    <img src="{{ asset('assets_backend/images/small_crypto/perfect money.gif') }}" width="44" height="17" align="absmiddle"> PerfectMoney
                                </td>
                                <td><b style="color:green">${{ $perfect_data['available'] }}</b></td>
                                <td><b style="color:red">${{ $perfect_data['pending'] }}</b></td>
                                <td>
                                    <a href="{{ route('edit_account')}}">
                                        <i>{{ Auth::user()->perfect_money }}</i>
                                        <b class="btn btn-info" style="margin-left: 10px">EDIT</b>
                                    </a>
                                </td>
                            </tr>

                            <!-- Payeer Row -->
                            <tr>
                                <td width=10>
                                    <input type="radio" name="wallet" value="Payeer" {{ old('wallet') == 'Payeer' ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <img src="{{ asset('assets_backend/images/small_crypto/payeer.gif') }}" width="44" height="17" align="absmiddle"> Payeer
                                </td>
                                <td><b style="color:green">${{ $payeer_data['available'] }}</b></td>
                                <td><b style="color:red">${{ $payeer_data['pending'] }}</b></td>
                                <td>
                                    <a href="/dashboard/edit_account">
                                        <i>{{ Auth::user()->payeer }}</i>
                                        <b class="btn btn-info" style="margin-left: 10px">EDIT</b>
                                    </a>
                                </td>
                            </tr>

                            <!-- Bitcoin Row -->
                            <tr>
                                <td width=10>
                                    <input type="radio" name="wallet" value="BTC" {{ old('wallet') == 'BTC' ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <img src="{{ asset('assets_backend/images/small_crypto/btc.gif') }}" width="44" height="17" align="absmiddle"> Bitcoin
                                </td>
                                <td><b style="color:green">${{ $btc_data['available'] }}</b></td>
                                <td><b style="color:red">${{ $btc_data['pending'] }}</b></td>
                                <td>
                                    <a href="/dashboard/edit_account">
                                        <i>{{ Auth::user()->bitcoin }}</i>
                                        <b class="btn btn-info" style="margin-left: 10px">EDIT</b>
                                    </a>
                                </td>
                            </tr>

                            <!-- Litecoin Row -->
                            <tr>
                                <td width=10>
                                    <input type="radio" name="wallet" value="LTC" {{ old('wallet') == 'LTC' ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <img src="{{ asset('assets_backend/images/small_crypto/ltc.gif') }}" width="44" height="17" align="absmiddle"> Litecoin
                                </td>
                                <td><b style="color:green">${{ $ltc_data['available'] }}</b></td>
                                <td><b style="color:red">${{ $ltc_data['pending'] }}</b></td>
                                <td>
                                    <a href="/dashboard/edit_account">
                                        <i>{{ Auth::user()->litecoin }}</i>
                                        <b class="btn btn-info" style="margin-left: 10px">EDIT</b>
                                    </a>
                                </td>
                            </tr>

                            <!-- Bitcoin Cash Row -->
                            <tr>
                                <td width=10>
                                    <input type="radio" name="wallet" value="BCH" {{ old('wallet') == 'BCH' ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <img src="{{ asset('assets_backend/images/small_crypto/bch.gif') }}" width="44" height="17" align="absmiddle"> Bitcoin Cash
                                </td>
                                <td><b style="color:green">${{ $bch_data['available'] }}</b></td>
                                <td><b style="color:red">${{ $bch_data['pending'] }}</b></td>
                                <td>
                                    <a href="/dashboard/edit_account">
                                        <i>{{ Auth::user()->bitcoin_cash }}</i>
                                        <b class="btn btn-info" style="margin-left: 10px">EDIT</b>
                                    </a>
                                </td>
                            </tr>

                            <!-- Ethereum Row -->
                            <tr>
                                <td width=10>
                                    <input type="radio" name="wallet" value="ETH" {{ old('wallet') == 'ETH' ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <img src="{{ asset('assets_backend/images/small_crypto/eth.gif') }}" width="44" height="17" align="absmiddle"> Ethereum
                                <td><b style="color:green">${{ $eth_data['available'] }}</b></td>
                                <td><b style="color:red">${{ $eth_data['pending'] }}</b></td>
                                <td>
                                    <a href="/dashboard/edit_account">
                                        <i>{{ Auth::user()->ethereum }}</i>
                                        <b class="btn btn-info" style="margin-left: 10px">EDIT</b>
                                    </a>
                                </td>
                            </tr>


                            <!-- USDT_BSC(BEP20) Row -->
                            <tr>
                                <td width=10>
                                    <input type="radio" name="wallet" value="USDT-BSC(BEP20)" {{ old('wallet') == 'USDT-BSC(BEP20)' ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <img src="{{ asset('assets_backend/images/small_crypto/usdt-bsc(bep20).gif') }}" width="44" height="17" align="absmiddle"> USDT-BSC(BEP20)
                                <td><b style="color:green">${{ $usdt_bsc_bep20_data['available'] }}</b></td>
                                <td><b style="color:red">${{ $usdt_bsc_bep20_data['pending'] }}</b></td>
                                <td>
                                    <a href="/dashboard/edit_account">
                                        <i>{{ Auth::user()->usdt_bsc_bep20  }}</i>
                                        <b class="btn btn-info" style="margin-left: 10px">EDIT</b>
                                    </a>
                                </td>
                            </tr>

                            <!-- Withdrawal Amount -->
                            <tr>
                                <td colspan="2">Amount to Withdrawal ($):</td>
                                <td align="right" colspan="3">
                                    <input type="text" name="amount" value="{{ old('amount', '0.00') }}" class="inpts" size="15" style="text-align:right;">
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <br><br>

                    @if($account_balance <= 0)
                        <div class="alert alert-warning">You have no funds to withdraw.</div>
                    @else
                        <input type="submit" value="Withdraw" class="sbmt">
                    @endif
                </form>





                </b>
            </div><b>

            </b>
        </div><b>

        </b>
    </div><b>

    </b>
</div>

@endsection
