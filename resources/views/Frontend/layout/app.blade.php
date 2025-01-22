<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tradeforyou - Best Investment Platform</title>
    <link rel="icon" href="{{ asset('assets/images/favicon.gif')}}">
    <link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/styles/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/styles/animate.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/styles/customf500.css')}}" rel="stylesheet" type="text/css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="UTF-8"
        src="https://translate.googleapis.com/translate_static/js/element/main_vi.js"></script>
    <script src="{{ asset('assets/js/setting230f4.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <link rel="stylesheet" href="{{ asset('assets_backend/vendors/toastr/toastr.css') }}">
    <script src="{{ asset('assets_backend/vendors/toastr/toastr.min.js') }}"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>



    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">


    <style>
        .auth-container {
            display: inline-block;
        }

        @media screen and (min-width:992px) {
            .auth-container {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
        }
    </style>


</head>

<body>




    @include('Frontend/layout/header')

    @yield('content')


    @include('Frontend/layout/footer')

    <script>
        var routes = {
            getLastStats: "{{ route('getLastStats') }}",
            getLastTransactions: "{{ route('getLastTransactions') }}",
            checkstatusdeposit: "{{ route('checkstatusdeposit') }}",
        };
    </script>


    <script src="{{ asset('assets_backend/js/myjs.js') }}"></script>

</body>

<script>




</script>




</html>
