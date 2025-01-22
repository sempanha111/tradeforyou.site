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
                                <h4 class="card-title">Deposite</h4>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th> User </th>
                                                <th> Amount </th>
                                                <th> Amount Crypto </th>
                                                <th> Wallet </th>
                                                <th> Payer Account </th>
                                                <th> TransactionsID </th>
                                                <th> Plan </th>
                                                <th> Status </th>
                                                <th> Delete </th>
                                                <th> Created_at </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($deposits as $key => $deposit)
                                                <tr>
                                                    <td>
                                                        <img src="/assets_backend/images/faces/face1.jpg"
                                                            class="me-2" alt="image"> {{ $deposit->user->name }}
                                                    </td>
                                                    <td>$ {{ $deposit->amount }} </td>
                                                    <td> {{ $deposit->amount_crypto }} </td>
                                                    <td> {{ $deposit->money }} </td>
                                                    <td> {{ $deposit->payer_account }} </td>
                                                    <td>
                                                        {{ $deposit->transaction_id }}
                                                    </td>
                                                    <td> {{ $deposit->plan }} </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn {{ $deposit->status === 'Approved' ? 'btn-success' : 'btn-danger'}}  btn-sm dropdown-toggle" type="button" id="dropdownMenuSizeButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> {{ $deposit->status }} </button>
                                                            <div class="dropdown-menu " aria-labelledby="dropdownMenuSizeButton3" data-popper-placement="bottom-start" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate3d(0px, 33.6px, 0px);">
                                                                @if($deposit->status === 'Approved')
                                                                    <a class="dropdown-item" href="{{ route('pending',$deposit->id)}}">Pending</a>
                                                                @else
                                                                    <a class="dropdown-item" href="{{ route('approved', $deposit->id) }}">Approved</a>
                                                                @endif

                                                            </div>
                                                          </div>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('delete_deposit', $deposit->id)}}">
                                                        <button type="button" class="btn btn-inverse-danger btn-icon">
                                                            <i class="mdi mdi-delete"></i>
                                                        </button></a>
                                                    </td>
                                                    <td> {{ $deposit->created_at }} </td>
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
