<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Purple Admin</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets_backend/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_backend/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_backend/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_backend/vendors/font-awesome/css/font-awesome.min.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('assets_backend/vendors/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets_backend/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_backend/vendors/toastr/toastr.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('assets_backend/css/style.css') }}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('assets_backend/images/favicon.png') }}" />
</head>

<body>

    @include('Backend/layout/nav')
    @yield('content')

    <script>
        $(document).ready(function () {
            @if (Session::has('success') || Session::has('error') || Session::has('warning'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut": 10000,
                "positionClass": "toast-bottom-left",
            };
            // Display toastr message based on session data
            @if (Session::has('success'))
                var toastrMessage = toastr.success("{{ session('success') }}");
            @elseif (Session::has('error'))
                var toastrMessage = toastr.error("{{ session('error') }}");
            @elseif (Session::has('warning'))
                var toastrMessage = toastr.warning("{{ session('warning') }}");
            @endif

            // Add hover event listener to restart timeout on hover
            toastrMessage.hover(
                function() {
                    toastr.options.timeOut = 0; // Set timeout to 0 to prevent auto-close
                },
                
            );
        @endif
        });
    </script>

    <script src="{{ asset('assets_backend/vendors/js/vendor.bundle.base.js') }}"></script>

    <script src="{{ asset('assets_backend/vendors/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets_backend/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets_backend/vendors/toastr/toastr.min.js') }}"></script>

    <script src="{{ asset('assets_backend/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets_backend/js/misc.js') }}"></script>
    <script src="{{ asset('assets_backend/js/settings.js') }}"></script>
    <script src="{{ asset('assets_backend/js/todolist.js') }}"></script>
    <script src="{{ asset('assets_backend/js/jquery.cookie.js') }}"></script>

    <script src="{{ asset('assets_backend/js/dashboard.js') }}"></script>

</body>

</html>
