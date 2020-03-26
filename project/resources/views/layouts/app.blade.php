<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon.png') }}">

    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    <link href="{{ mix('assets/css/app.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    @yield('header')
</head>

<body>
<div id="app">
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    @include('layouts.flash-messages')

    <div id="main-wrapper">

        @include('layouts._partials.navbar.navbar')
        @if (is_user_admin())
            @include('layouts._partials.sidebar.sidebar_admin')
        @else
            @include('layouts._partials.sidebar.sidebar_client')
        @endif

        <div class="page-wrapper">
            @include('layouts._partials.breadcrumb.breadcrumb')

            <div class="container-fluid">
                <vue-snotify></vue-snotify>
                @yield('custom-template')
                @yield('content')
            </div>

            <footer class="footer text-center">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; {{ config('app.name') }} {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ mix('assets/js/manifest.js') }}"></script>
<script src="{{ mix('assets/js/vendor.js') }}"></script>
<script src="{{ mix('assets/js/app.js') }}"></script>

@yield('footer')
</body>
</html>
