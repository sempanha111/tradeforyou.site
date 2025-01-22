<div class="lasttenwrap1">
    <div class="container1">
        <div class="row1" style="text-align: center;">
            <div class="col-lg-61">
                <div class="toptenstat bounceInUp wow">
                    <div class="head1" style="text-align: center; font-size: 20px; margin-bottom: 30px; font-weight: bold;">
                        Last 10 Deposits
                    </div>
                    <div class="infos">
                        <table cellspacing="0" cellpadding="2" border="0" width="100%" style="border-spacing: 6px; border-collapse: separate; margin-bottom: 30px;">
                            <tbody>
                                @foreach($depositData as $deposit)
                                    <tr>
                                        <td class="menutxt"><img src="{{ asset($deposit['image']) }}"></td>
                                        <td class="menutxt">${{ number_format($deposit['amount'], 2) }}</td>
                                        <td class="menutxt">{{ $deposit['username'] }}</td>
                                        <td class="menutxt">{{ $deposit['date'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-61">
                <div class="toptenstat bounceInUp wow1">
                    <div class="head1" style="text-align: center; font-size: 20px; margin-bottom: 30px; font-weight: bold;">
                        Last 10 Withdrawals
                    </div>
                    <div class="infos">
                        <table cellspacing="0" cellpadding="2" border="0" width="100%" style="border-spacing: 6px; border-collapse: separate; margin-bottom: 30px;">
                            <tbody>
                                @foreach($withdrawalData as $withdrawal)
                                    <tr>
                                        <td class="menutxt"><img src="{{ asset($withdrawal['image']) }}"></td>
                                        <td class="menutxt">${{ number_format($withdrawal['amount'], 2) }}</td>
                                        <td class="menutxt">{{ $withdrawal['username'] }}</td>
                                        <td class="menutxt">{{ $withdrawal['date'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
