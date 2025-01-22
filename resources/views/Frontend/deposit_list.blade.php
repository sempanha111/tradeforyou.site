@extends('Frontend/layout.app')
@section('content')
<div class="banner_wrap banner_wrap_sub">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="banner_left inside">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <h1>Your Deposits</h1>
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
</div>
<div class="member_inside">
    <div class="member-container">
        <div class="member-right">

            <div class="account_header">Total: ${{$account_balance}}</div>


            <table cellspacing="1" cellpadding="2" border="0" width="100%">
                <tbody>
                    <tr>
                        <td colspan="3" align="center">
                            <b style="color:#48c7cb;font-size:24px;">130% After 72 Hours</b>
                        </td>
                    </tr>

                    <tr>
                        <td class="inheader">Plan</td>
                        <td class="inheader" width="300">Deposit Amount</td>
                        <td class="inheader" width="100" nowrap="" align="right">
                            <nobr> Profit (%)</nobr>
                        </td>
                    </tr>



                    <tr>
                        <td class="item">130% After 72 Hours</td>
                        <td class="item" align="left">$1.00 - $5.00</td>
                        <td class="item" align="right">130.00</td>
                    </tr>
                </tbody>
            </table>
            <table cellspacing="0" cellpadding="2" border="0" width="100%">
                <tbody>

                    @if ($plan1->isNotEmpty())
                    <tr>
                        <td class="inheader">Your Deposits: <br> Date</td>
                        <td class="inheader" width="300"><br> Amount</td>
                    </tr>
                    @foreach ($plan1 as $plan1)
                    @php
                    $start_plan = Carbon\Carbon::now()->format('l, F j g:i A');
                    $end_plan = Carbon\Carbon::parse($plan1->end_plan);
                    $current_date = Carbon\Carbon::now();
                    $total_hours_left = $current_date->diffInHours($end_plan, false); // Get total difference in hours

                    // Ensure it's not negative
                    $total_hours_left = max($total_hours_left, 0);

                    // Calculate days and hours
                    $days_left = floor($total_hours_left / 24);
                    $hours_left = $total_hours_left % 24;


                    @endphp
                    @if ($current_date->lt($end_plan))

                    <tr>
                        <td class="item" align="center">
                            <b>{{ $start_plan }}</b><br>
                            Expire in {{ $days_left }} day{{ $days_left > 1 ? 's' : '' }} and {{ $hours_left }} hour{{
                            $hours_left > 1 ? 's' : '' }}
                        </td>
                        <td class="item" width="300" align="right">
                            <b>${{ $plan1->amount }}</b>
                            <img src="{{ asset('assets_backend/images/small_crypto/' . strtolower($plan1->money) . '.gif')}}"
                                alt="">
                        </td>
                    </tr>

                    <table cellspacing="1" cellpadding="2" border="0" width="100%">
                        <tbody>
                            <tr>
                                <td class="item">Deposit Total: </td>
                                <td class="item" width="300">${{ $plan1->amount }}</td>
                            </tr>
                            <tr>
                                <td class="item">Profit Today: </td>
                                <td class="item" width="300">
                                    ${{ $plan1->history->whereBetween('created_at', [$startOfDay, $endOfDay])
                                    ->sum('amount');}}</td>
                            </tr>
                            <tr>
                                <td class="item">Total Profit: </td>
                                <td class="item" width="300">${{ $plan1->history->sum('amount')}}</td>
                            </tr>
                        </tbody>
                    </table>


                    <table cellspacing="1" cellpadding="2" border="0" width="100%">


                        @endif

                        @endforeach
                        @else
                        <tr>
                            <td colspan="4"><b>No deposits for this plan</b></td>
                        </tr>
                        @endif
                </tbody>
            </table>


            <br>


            <table cellspacing="1" cellpadding="2" border="0" width="100%">
                <tbody>
                    <tr>
                        <td colspan="3" align="center">
                            <b style="color:#48c7cb;font-size:24px;">175% After 72 Hours</b>
                        </td>
                    </tr>

                    <tr>
                        <td class="inheader">Plan</td>
                        <td class="inheader" width="300">Deposit Amount</td>
                        <td class="inheader" width="100" nowrap="" align="right">
                            <nobr> Profit (%)</nobr>
                        </td>
                    </tr>



                    <tr>
                        <td class="item">175% After 72 Hours</td>
                        <td class="item" align="left">$5.00 - $10.00</td>
                        <td class="item" align="right">175.00</td>
                    </tr>
                </tbody>
            </table>
            <table cellspacing="0" cellpadding="2" border="0" width="100%">
                <tbody>

                    @if ($plan2->isNotEmpty())
                    <tr>
                        <td class="inheader">Your Deposits: <br> Date</td>
                        <td class="inheader" width="300"><br> Amount</td>
                    </tr>
                    @foreach ($plan2 as $plan2)
                    @php
                    $start_plan = Carbon\Carbon::now()->format('l, F j g:i A');
                    $end_plan = Carbon\Carbon::parse($plan2->end_plan);
                    $current_date = Carbon\Carbon::now();
                    $total_hours_left = $current_date->diffInHours($end_plan, false); // Get total difference in hours

                    // Ensure it's not negative
                    $total_hours_left = max($total_hours_left, 0);

                    // Calculate days and hours
                    $days_left = floor($total_hours_left / 24);
                    $hours_left = $total_hours_left % 24;


                    @endphp
                    @if ($current_date->lt($end_plan))

                    <tr>
                        <td class="item" align="center">
                            <b>{{ $start_plan }}</b><br>
                            Expire in {{ $days_left }} day{{ $days_left > 1 ? 's' : '' }} and {{ $hours_left }} hour{{
                            $hours_left > 1 ? 's' : '' }}
                        </td>
                        <td class="item" width="300" align="right">
                            <b>${{ $plan2->amount }}</b>
                            <img src="{{ asset('assets_backend/images/small_crypto/' . strtolower($plan2->money) . '.gif')}}"
                                alt="">
                        </td>
                    </tr>

                    <table cellspacing="1" cellpadding="2" border="0" width="100%">
                        <tbody>
                            <tr>
                                <td class="item">Deposit Total: </td>
                                <td class="item" width="300">${{ $plan2->amount }}</td>
                            </tr>
                            <tr>
                                <td class="item">Profit Today: </td>
                                <td class="item" width="300">
                                    ${{ $plan2->history->whereBetween('created_at', [$startOfDay, $endOfDay])
                                    ->sum('amount');}}</td>
                            </tr>
                            <tr>
                                <td class="item">Total Profit: </td>
                                <td class="item" width="300">${{ $plan2->history->sum('amount')}}</td>
                            </tr>
                        </tbody>
                    </table>


                    <table cellspacing="1" cellpadding="2" border="0" width="100%">


                        @endif

                        @endforeach
                        @else
                        <tr>
                            <td colspan="4"><b>No deposits for this plan</b></td>
                        </tr>
                        @endif
                </tbody>
            </table>


            <br>



            <table cellspacing="1" cellpadding="2" border="0" width="100%">
                <tbody>
                    <tr>
                        <td colspan="3" align="center">
                            <b style="color:#48c7cb;font-size:24px;">200% After 72 Hours</b>
                        </td>
                    </tr>

                    <tr>
                        <td class="inheader">Plan</td>
                        <td class="inheader" width="300">Deposit Amount</td>
                        <td class="inheader" width="100" nowrap="" align="right">
                            <nobr> Profit (%)</nobr>
                        </td>
                    </tr>



                    <tr>
                        <td class="item">200% After 72 Hours</td>
                        <td class="item" align="left">$15.00 - $30.00</td>
                        <td class="item" align="right">200.00</td>
                    </tr>
                </tbody>
            </table>
            <table cellspacing="0" cellpadding="2" border="0" width="100%">
                <tbody>

                    @if ($plan3->isNotEmpty())
                    <tr>
                        <td class="inheader">Your Deposits: <br> Date</td>
                        <td class="inheader" width="300"><br> Amount</td>
                    </tr>
                    @foreach ($plan3 as $plan3)
                    @php
                    $start_plan = Carbon\Carbon::now()->format('l, F j g:i A');
                    $end_plan = Carbon\Carbon::parse($plan3->end_plan);
                    $current_date = Carbon\Carbon::now();
                    $total_hours_left = $current_date->diffInHours($end_plan, false); // Get total difference in hours

                    // Ensure it's not negative
                    $total_hours_left = max($total_hours_left, 0);

                    // Calculate days and hours
                    $days_left = floor($total_hours_left / 24);
                    $hours_left = $total_hours_left % 24;


                    @endphp
                    @if ($current_date->lt($end_plan))

                    <tr>
                        <td class="item" align="center">
                            <b>{{ $start_plan }}</b><br>
                            Expire in {{ $days_left }} day{{ $days_left > 1 ? 's' : '' }} and {{ $hours_left }} hour{{
                            $hours_left > 1 ? 's' : '' }}
                        </td>
                        <td class="item" width="300" align="right">
                            <b>${{ $plan3->amount }}</b>
                            <img src="{{ asset('assets_backend/images/small_crypto/' . strtolower($plan3->money) . '.gif')}}"
                                alt="">
                        </td>
                    </tr>

                    <table cellspacing="1" cellpadding="2" border="0" width="100%">
                        <tbody>
                            <tr>
                                <td class="item">Deposit Total: </td>
                                <td class="item" width="300">${{ $plan3->amount }}</td>
                            </tr>
                            <tr>
                                <td class="item">Profit Today: </td>
                                <td class="item" width="300">
                                    ${{ $plan3->history->whereBetween('created_at', [$startOfDay, $endOfDay])
                                    ->sum('amount');}}</td>
                            </tr>
                            <tr>
                                <td class="item">Total Profit: </td>
                                <td class="item" width="300">${{ $plan3->history->sum('amount')}}</td>
                            </tr>
                        </tbody>
                    </table>


                    <table cellspacing="1" cellpadding="2" border="0" width="100%">


                        @endif

                        @endforeach
                        @else
                        <tr>
                            <td colspan="4"><b>No deposits for this plan</b></td>
                        </tr>
                        @endif
                </tbody>
            </table>


            <br>


            <table cellspacing="1" cellpadding="2" border="0" width="100%">
                <tbody>
                    <tr>
                        <td colspan="3" align="center">
                            <b style="color:#48c7cb;font-size:24px;">245% After 72 Hours</b>
                        </td>
                    </tr>

                    <tr>
                        <td class="inheader">Plan</td>
                        <td class="inheader" width="300">Deposit Amount</td>
                        <td class="inheader" width="100" nowrap="" align="right">
                            <nobr> Profit (%)</nobr>
                        </td>
                    </tr>



                    <tr>
                        <td class="item">245% After 72 Hours</td>
                        <td class="item" align="left">$30.00 - $50.00</td>
                        <td class="item" align="right">245.00</td>
                    </tr>
                </tbody>
            </table>
            <table cellspacing="0" cellpadding="2" border="0" width="100%">
                <tbody>

                    @if ($plan4->isNotEmpty())
                    <tr>
                        <td class="inheader">Your Deposits: <br> Date</td>
                        <td class="inheader" width="300"><br> Amount</td>
                    </tr>
                    @foreach ($plan4 as $plan4)
                    @php
                    $start_plan = Carbon\Carbon::now()->format('l, F j g:i A');
                    $end_plan = Carbon\Carbon::parse($plan4->end_plan);
                    $current_date = Carbon\Carbon::now();
                    $total_hours_left = $current_date->diffInHours($end_plan, false); // Get total difference in hours

                    // Ensure it's not negative
                    $total_hours_left = max($total_hours_left, 0);

                    // Calculate days and hours
                    $days_left = floor($total_hours_left / 24);
                    $hours_left = $total_hours_left % 24;


                    @endphp
                    @if ($current_date->lt($end_plan))

                    <tr>
                        <td class="item" align="center">
                            <b>{{ $start_plan }}</b><br>
                            Expire in {{ $days_left }} day{{ $days_left > 1 ? 's' : '' }} and {{ $hours_left }} hour{{
                            $hours_left > 1 ? 's' : '' }}
                        </td>
                        <td class="item" width="300" align="right">
                            <b>${{ $plan4->amount }}</b>
                            <img src="{{ asset('assets_backend/images/small_crypto/' . strtolower($plan4->money) . '.gif')}}"
                                alt="">
                        </td>
                    </tr>

                    <table cellspacing="1" cellpadding="2" border="0" width="100%">
                        <tbody>
                            <tr>
                                <td class="item">Deposit Total: </td>
                                <td class="item" width="300">${{ $plan4->amount }}</td>
                            </tr>
                            <tr>
                                <td class="item">Profit Today: </td>
                                <td class="item" width="300">
                                    ${{ $plan4->history->whereBetween('created_at', [$startOfDay, $endOfDay])
                                    ->sum('amount');}}</td>
                            </tr>
                            <tr>
                                <td class="item">Total Profit: </td>
                                <td class="item" width="300">${{ $plan4->history->sum('amount')}}</td>
                            </tr>
                        </tbody>
                    </table>


                    <table cellspacing="1" cellpadding="2" border="0" width="100%">


                        @endif

                        @endforeach
                        @else
                        <tr>
                            <td colspan="4"><b>No deposits for this plan</b></td>
                        </tr>
                        @endif
                </tbody>
            </table>

            <br>


            <table cellspacing="1" cellpadding="2" border="0" width="100%">
                <tbody>
                    <tr>
                        <td colspan="3" align="center">
                            <b style="color:#48c7cb;font-size:24px;">375% After 72 Hours</b>
                        </td>
                    </tr>

                    <tr>
                        <td class="inheader">Plan</td>
                        <td class="inheader" width="300">Deposit Amount</td>
                        <td class="inheader" width="100" nowrap="" align="right">
                            <nobr> Profit (%)</nobr>
                        </td>
                    </tr>



                    <tr>
                        <td class="item">375% After 72 Hours</td>
                        <td class="item" align="left">$50.00 - $200.00</td>
                        <td class="item" align="right">375.00</td>
                    </tr>
                </tbody>
            </table>
            <table cellspacing="0" cellpadding="2" border="0" width="100%">
                <tbody>

                    @if ($plan5->isNotEmpty())
                    <tr>
                        <td class="inheader">Your Deposits: <br> Date</td>
                        <td class="inheader" width="300"><br> Amount</td>
                    </tr>
                    @foreach ($plan5 as $plan5)
                    @php

                    $start_plan = Carbon\Carbon::now()->format('l, F j g:i A');
                    $end_plan = Carbon\Carbon::parse($plan5->end_plan);
                    $current_date = Carbon\Carbon::now();
                    $total_hours_left = $current_date->diffInHours($end_plan, false); // Get total difference in hours

                    // Ensure it's not negative
                    $total_hours_left = max($total_hours_left, 0);

                    // Calculate days and hours
                    $days_left = floor($total_hours_left / 24);
                    $hours_left = $total_hours_left % 24;


                    @endphp
                    @if ($current_date->lt($end_plan))

                    <tr>
                        <td class="item" align="center">
                            <b>{{ $start_plan }}</b><br>
                            Expire in {{ $days_left }} day{{ $days_left > 1 ? 's' : '' }} and {{ $hours_left }} hour{{
                            $hours_left > 1 ? 's' : '' }}
                        </td>
                        <td class="item" width="300" align="right">
                            <b>${{ $plan5->amount }}</b>
                            <img src="{{ asset('assets_backend/images/small_crypto/' . strtolower($plan5->money) . '.gif')}}"
                                alt="">
                        </td>
                    </tr>

                    <table cellspacing="1" cellpadding="2" border="0" width="100%">
                        <tbody>
                            <tr>
                                <td class="item">Deposit Total: </td>
                                <td class="item" width="300">${{ $plan5->amount }}</td>
                            </tr>
                            <tr>
                                <td class="item">Profit Today: </td>
                                <td class="item" width="300">
                                    ${{ $plan5->history->whereBetween('created_at', [$startOfDay, $endOfDay])
                                    ->sum('amount');}}</td>
                            </tr>
                            <tr>
                                <td class="item">Total Profit: </td>
                                <td class="item" width="300">${{ $plan5->history->sum('amount')}}</td>
                            </tr>
                        </tbody>
                    </table>


                    <table cellspacing="1" cellpadding="2" border="0" width="100%">


                        @endif

                        @endforeach
                        @else
                        <tr>
                            <td colspan="4"><b>No deposits for this plan</b></td>
                        </tr>
                        @endif
                </tbody>
            </table>

            <br>


        </div>
    </div>
</div>

@endsection
