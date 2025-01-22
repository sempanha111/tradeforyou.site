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
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                          <div class="card-body">
                            <h4 class="card-title">Complete withdraw</h4>
                            <p class="card-description"> Set Information for withdrawal </p>
                            <form class="forms-sample" action="{{ route('approved_withdraw_update') }}" method="POST">
                                @csrf
                              <div class="form-group">
                                <input type="hidden" name="id" value="{{ $id }}">
                                <label for="exampleInputName1">Batch</label>
                                <input type="text" class="form-control" id="exampleInputName1" placeholder="batch" name="batch" value="{{ $withdraw->batch }}">
                                @error('batch')
                                    {{ $message }}
                                @enderror
                              </div>

                              <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                              <a href="{{ route('withdraw_admin')}}" class="btn btn-light">Cancel</a>
                            </form>
                          </div>
                        </div>
                      </div>
                </div>
            </div>
        </div>
        <!-- main-panel ends -->
    </div>
@endsection
