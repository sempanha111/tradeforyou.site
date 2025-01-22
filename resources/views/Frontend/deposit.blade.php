@extends('Frontend/layout.app')
@section('content')
<div class="banner_wrap banner_wrap_sub">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="banner_left inside">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <h1>Make Deposit</h1>
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
            @include('Frontend/layout/massage_bootstrap')
            <div class="member-right">
                <h3>Make a Deposit:</h3>
                <br>
                <form action="{{ route('deposit.checkout') }}" method="post" name="spendform">
                    @csrf

                    <table cellspacing="1" cellpadding="2" border="0" width="100%">
                        <tbody>
                            <tr>
                                <td colspan="3">
                                    <input type="radio" name="h_id" value="1" checked>
                                    <b>130% After 72 Hours</b>
                                </td>
                            </tr>
                            <tr>
                                <td class="inheader">Plan</td>
                                <td class="inheader" width="200">Spent Amount ($)</td>
                                <td class="inheader" width="100" nowrap="">
                                    <nobr> Profit (%)</nobr>
                                </td>
                            </tr>
                            <tr>
                                <td class="item">130% After 72 Hours</td>
                                <td class="item" align="right">$1.00 - $5.00</td>
                                <td class="item" align="right">130.00</td>
                            </tr>

                        </tbody>
                    </table><br><br>

                    <table cellspacing="1" cellpadding="2" border="0" width="100%">
                        <tbody>
                            <tr>
                                <td colspan="3">
                                    <input type="radio" name="h_id" value="2" >

                                    <b>175% After 72 Hours</b>
                                </td>
                            </tr>
                            <tr>
                                <td class="inheader">Plan</td>
                                <td class="inheader" width="200">Spent Amount ($)</td>
                                <td class="inheader" width="100" nowrap="">
                                    <nobr>Hourly Profit (%)</nobr>
                                </td>
                            </tr>
                            <tr>
                                <td class="item">175% After 72 Hours</td>
                                <td class="item" align="right">$5.00 - $15.00</td>
                                <td class="item" align="right">175.00</td>
                            </tr>

                        </tbody>
                    </table><br><br>

                    <table cellspacing="1" cellpadding="2" border="0" width="100%">
                        <tbody>
                            <tr>
                                <td colspan="3">
                                    <input type="radio" name="h_id" value="3">

                                    <b>200% After 72 Hours</b>
                                </td>
                            </tr>
                            <tr>
                                <td class="inheader">Plan</td>
                                <td class="inheader" width="200">Spent Amount ($)</td>
                                <td class="inheader" width="100" nowrap="">
                                    <nobr> Profit (%)</nobr>
                                </td>
                            </tr>
                            <tr>
                                <td class="item">200% After 72 Hours</td>
                                <td class="item" align="right">$15.00 - $30.00</td>
                                <td class="item" align="right">200.00</td>
                            </tr>

                        </tbody>
                    </table><br><br>

                    <table cellspacing="1" cellpadding="2" border="0" width="100%">
                        <tbody>
                            <tr>
                                <td colspan="3">
                                    <input type="radio" name="h_id" value="4" >

                                    <b>245% After 72 Hours</b>
                                </td>
                            </tr>
                            <tr>
                                <td class="inheader">Plan</td>
                                <td class="inheader" width="200">Spent Amount ($)</td>
                                <td class="inheader" width="100" nowrap="">
                                    <nobr> Profit (%)</nobr>
                                </td>
                            </tr>
                            <tr>
                                <td class="item">245% After 72 Hours</td>
                                <td class="item" align="right">$30.00 - $50.00</td>
                                <td class="item" align="right">245.00</td>
                            </tr>

                        </tbody>
                    </table><br><br>

                    <table cellspacing="1" cellpadding="2" border="0" width="100%">
                        <tbody>
                            <tr>
                                <td colspan="3">
                                    <input type="radio" name="h_id" value="5" onclick="updateCompound()">
                                    <input type="hidden" name="allow_internal_5" value="0">
                                    <input type="hidden" name="allow_external_5" value="1">
                                    <!--	<input type=radio name=h_id value='5'  > -->

                                    <b>375% After 72 Hours</b>
                                </td>
                            </tr>
                            <tr>
                                <td class="inheader">Plan</td>
                                <td class="inheader" width="200">Spent Amount ($)</td>
                                <td class="inheader" width="100" nowrap="">
                                    <nobr>Hourly Profit (%)</nobr>
                                </td>
                            </tr>
                            <tr>
                                <td class="item">375% After 72 Hours</td>
                                <td class="item" align="right">$50.00 - $200.00</td>
                                <td class="item" align="right">375.00</td>
                            </tr>

                        </tbody>
                    </table><br><br>



                    <table cellspacing="0" cellpadding="2" border="0">
                        <tbody>
                            <tr>
                                <td>Your account balance ($):</td>
                                <td align="right">${{ number_format($account_balance, 2)}}</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td align="right">
                                    <small>
                                    </small>
                                </td>
                            </tr>
                            <tr>
                                <td>Amount to Spend ($):</td>
                                <td align="right"><input type="text" name="amount" value="1.00" class="inpts" size="15"
                                        style="text-align:right;"></td>
                            </tr>


                            <tr>
                                <td colspan="2">
                                    <table cellspacing="0" cellpadding="2" border="0">
                                        <tbody id="external_deps">
                                            <tr>
                                                <td><input type=radio name=type value="Perfect Money" checked>
                                                </td>
                                                <td>Spend funds from PerfectMoney</td>
                                            </tr>
                                            <tr>
                                                <td><input type=radio name=type value="Payeer"></td>
                                                <td>Spend funds from Payeer</td>
                                            </tr>

                                            <tr>
                                                <td><input type=radio name=type value="BTC"></td>
                                                <td>Spend funds from Bitcoin</td>
                                            </tr>
                                            <tr>
                                                <td><input type=radio name=type value="LTC"></td>
                                                <td>Spend funds from Litecoin</td>
                                            </tr>

                                            <tr>
                                                <td><input type=radio name=type value="BCH"></td>
                                                <td>Spend funds from Bitcoin Cash</td>
                                            </tr>

                                            <tr>
                                                <td><input type=radio name=type value="ETH"></td>
                                                <td>Spend funds from Ethereum</td>
                                            </tr>

                                            <tr>
                                                <td><input type=radio name=type value="USDT-BSC(BEP20)"></td>
                                                <td>Spend funds from USDT-BSC(BEP20)</td>
                                            </tr>

                                            <tr>
                                                <td><input type=radio name=type value="Payeer Manual"></td>
                                                <td>Spend funds from Payeer manual</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><input type="submit" value="Spend" class="sbmt"></td>
                            </tr>
                        </tbody>
                    </table>


                </form>

                <script>
                    $(document).ready(function() {

                        // Initialize default minMoney and maxMoney
                        var minMoney = 1;
                        var maxMoney = 5;

                        // Update based on selected plan
                        $('input[name="h_id"]').change(function() {
                            let value = $(this).val();
                            if (value == 1) {
                                minMoney = 1;
                                maxMoney = 5;
                            } else if (value == 2) {
                                minMoney = 5;
                                maxMoney = 15;
                            } else if (value == 3) {
                                minMoney = 15;
                                maxMoney = 30;
                            } else if (value == 4) {
                                minMoney = 30;
                                maxMoney = 50;
                            } else if (value == 5) {
                                minMoney = 50;
                                maxMoney = 200;
                            }

                            $('.inpts').val(minMoney.toFixed(2));

                        });

                        let typingTimer;
                        let typingDelay = 1000;

                        $('.inpts').on('input', function() {
                            let $input = $(this);  // Save reference to current input

                            clearTimeout(typingTimer);

                            typingTimer = setTimeout(function() {
                                let inputValue = $input.val();

                                if (isNaN(inputValue)) {
                                    alert('Please enter a valid number');
                                    $input.val(minMoney.toFixed(2));  // Reset to min if invalid
                                    return;
                                }

                                let inputValueFloat = parseFloat(inputValue);

                                // Validate input within min and max range
                                if (inputValueFloat > maxMoney) {
                                    $input.val(maxMoney.toFixed(2));
                                } else if (inputValueFloat < minMoney) {
                                    $input.val(minMoney.toFixed(2));
                                }
                            }, typingDelay);
                        });

                    });
                </script>




            </div>
        </div>
    </div>
</div>

@endsection
