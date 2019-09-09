<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('assets/css/app.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"> @yield('header')
</head>

<body>
<div id="app">
    @include('layouts.flash-messages')
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav">

                </ul>
            </div>

        </div>
    </nav>

    <vue-snotify></vue-snotify>

    <div class="container pt-3">
        <div class="container">
            <div class="row justify-content-md-center mt-5">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Login</div>
                        <div class="card-body">
                            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}

                                <div class="form-group row">
                                    <label for="email" class="col-lg-4 col-form-label text-lg-right">E-Mail Address</label>

                                    <div class="col-lg-6">
                                        <input
                                                id="email"
                                                type="email"
                                                class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                name="email"
                                                value="{{ old('email') }}"
                                                required
                                                autofocus
                                        >

                                        @if ($errors->has('email'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-lg-4 col-form-label text-lg-right">Password</label>

                                    <div class="col-lg-6">
                                        <input
                                                id="password"
                                                type="password"
                                                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                name="password"
                                                required
                                        >

                                        @if ($errors->has('password'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6 offset-lg-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-8 offset-lg-4">
                                        <button type="submit" class="btn btn-primary">
                                            Login
                                        </button>

                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            Forgot Your Password?
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
