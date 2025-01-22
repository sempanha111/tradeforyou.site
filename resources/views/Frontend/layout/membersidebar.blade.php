<div class="membersidebar">
    <ul>
        <li><a href="{{ route('dashboard')}}"><i class="far fa-id-card"></i> Account</a></li>
        <li><a href="{{ route('deposit')}}"><i class="fas fa-coins"></i> Make Deposit</a></li>
        <li><a href="{{ route('deposit_list')}}"><i class="fas fa-chart-bar"></i> Deposit List</a>
        </li>

        <li><a href="{{ route('deposit_history')}}"><i class="fas fa-clipboard-list"></i> Deposits
                History</a></li>

        <li><a href="{{ route('withdraw')}}"><i class="fas fa-wallet"></i> Withdraw Funds</a></li>


        <li><a href="{{ route('earning_history')}}"><i class="fas fa-clipboard-list"></i> Earnings History</a>
        </li>

        <li><a href="{{ route('withdraw_history')}}"><i class="fas fa-clipboard-list"></i> Withdrawals
                History</a></li>


        <li><a href="{{ route('referrals')}}"><i class="far fa-user"></i> Your Referrals</a> </li>
        <li><a href="{{ route('edit_account')}}"><i class="fas fa-cog"></i> Edit Account</a> </li>

        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="javascript:void(0)" onclick="this.closest('form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </form>
        </li>
    </ul>
</div>
