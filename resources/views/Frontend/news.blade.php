@extends('Frontend/layout.app')
@section('content')

<div class="banner_wrap banner_wrap_sub">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="banner_left inside">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <h1>News</h1>
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

<div class="inside_wrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table cellspacing="1" cellpadding="2" border="0" width="100%">
                    <tbody>
                        <tr>

                            <td colspan="3" align="center">No news found</td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection
