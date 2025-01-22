@extends('Backend/layout/app')

@section('content')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        @include('Backend/layout/sidebar')
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">withdraw</h4>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th> User Id </th>
                                                <th> User Name </th>
                                                <th> Amount </th>
                                                <th> Wallet </th>
                                                <th> WalletID </th>
                                                <th> Status </th>
                                                <th> Edit </th>
                                                <th> Delete </th>
                                                <th> Created_at </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($withdraws as $key => $withdraw)
                                                <tr>
                                                    <td>{{ $withdraw->user->id }}</td>
                                                    <td>
                                                        <img src="http://127.0.0.1:8000/assets_backend/images/faces/face1.jpg"
                                                            class="me-2" alt="image"> {{ $withdraw->user->name }}
                                                    </td>
                                                    <td> ${{ $withdraw->withdraw_request }} </td>
                                                    <td> {{ $withdraw->money }} </td>
                                                    <td>
                                                        @if($withdraw->money == 'Perfect Money')
                                                         {{ $withdraw->user->perfect_money }}
                                                        @elseif($withdraw->money == 'Payeer')
                                                        {{ $withdraw->user->payeer }}
                                                        @elseif($withdraw->money == 'BTC')
                                                        {{ $withdraw->user->bitcoin }}
                                                        @elseif($withdraw->money == 'LTC')
                                                        {{ $withdraw->user->litecoin }}
                                                        @elseif($withdraw->money == 'ETH')
                                                        {{ $withdraw->user->ethereum }}
                                                        @elseif($withdraw->money == 'BCH')
                                                        {{ $withdraw->user->bitcoin_cash }}
                                                        @elseif($withdraw->money == 'USDT-BSC(BEP20)')
                                                        {{ $withdraw->user->usdt_bsc_bep20 }}
                                                        @endif

                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn {{ $withdraw->status === 'Approved' ? 'btn-success' : 'btn-danger'}}  btn-sm dropdown-toggle" type="button" id="dropdownMenuSizeButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> {{ $withdraw->status }} </button>
                                                            <div class="dropdown-menu " aria-labelledby="dropdownMenuSizeButton3" data-popper-placement="bottom-start" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate3d(0px, 33.6px, 0px);">
                                                                @if($withdraw->status === 'Approved')
                                                                    <a class="dropdown-item" href="{{ route('withdraw_admin_pending',$withdraw->id)}}">Pending</a>
                                                                @else
                                                                <a class="dropdown-item" href="{{ route('withdraw_admin_complete', $withdraw->id) }}">Approved</a>
                                                                @endif

                                                            </div>
                                                          </div>
                                                    </td>
                                                    <td>

                                                        <a href="{{ route('completewithdraw_edit', $withdraw->id)}}">
                                                        <button type="button" class="btn btn-inverse-danger btn-icon">
                                                            <i class="fa fa-edit"></i>
                                                        </button></a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('delete_withdraw', $withdraw->id)}}">
                                                        <button type="button" class="btn btn-inverse-danger btn-icon">
                                                            <i class="mdi mdi-delete"></i>
                                                        </button></a>
                                                    </td>
                                                    <td> {{ $withdraw->created_at }} </td>
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
        </div>
        <!-- main-panel ends -->
    </div>
@endsection
