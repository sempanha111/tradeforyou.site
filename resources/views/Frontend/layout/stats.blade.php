<div class="stat-middle">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="stat"> <img src="{{ asset('assets/images/stat1.png')}}" alt="">
                <h3>{{$total_member + 9 }}</h3>
                <p>Total Members</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="stat"> <img src="{{ asset('assets/images/stat2.png')}}" alt="">
                <h3>$ {{$total_deposit + 128 }}</h3>
                <p>Total Deposited</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="stat"> <img src="{{ asset('assets/images/stat3.png')}}" alt="">
                <h3>{{$days}}</h3>
                <p>Days Online</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="stat"> <img src="{{ asset('assets/images/stat4.png')}}" alt="">
                <h3>$ {{$total_withdraw + 5 }}</h3>
                <p>Total Withdrawal</p>
            </div>
        </div>
    </div>
</div>
