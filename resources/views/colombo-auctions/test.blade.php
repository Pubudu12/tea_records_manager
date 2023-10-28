<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/favicons/site.webmanifest') }}">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- meta title-->
    <title>Forbes & Walker | Admin Dashboard | Top Prices </title>

    @include('theme.css')

    {{-- page-CSS --}}
    @yield('page-css')

</head>
<body>

<!-- page-wrapper Start-->
<div class="page-wrapper">

    <!-- Page Header Start-->
    @include('theme.partials.header')
    <!-- Page Header Ends -->

    <!-- Page Body Start-->
    <div class="page-body-wrapper">

    <!-- side bar -->
    @include('theme.partials.sidebar')

        {{-- Content --}}
        @yield('content')

        <!-- footer start-->
        @include('theme.partials.footer')

    </div>

</div>



@include('theme.js')

{{-- page-js --}}
@yield('page-js')


</body>
</html>
<script>
    $(document).ready( function () {
    $('.dataListTable').DataTable();
} );
</script>
