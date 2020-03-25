@extends('layouts.auth')

@section('content')
    <div class="card card-signin my-5">
        <div class="card-body">
            <div class="row img-login">
                <img src="/assets/img/logo.png" alt="homepage" class="m-auto" style="height: 70px; transform: scale(1.8);">
            </div>
            <form class="form-signin" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-label-group">
                    <label for="email">
                        @lang('labels.auth.email')
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-control {{ has_error_class('email') }}"
                        autofocus>
                    @errorblock('email')
                </div>

                <div class="form-label-group">
                    <label for="password">
                        @lang('labels.auth.password')
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        value="{{ old('password') }}"
                        class="form-control {{ has_error_class('password') }}">
                    @errorblock('password')
                </div>

                <div class="form-label-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheckbox">
                        <label class="custom-control-label" for="customCheckbox">
                            @lang('phrases.auth.remember_me')
                        </label>
                    </div>
                </div>

                <button class="btn btn-lg btn-secondary btn-block text-uppercase" type="submit">
                    @lang('buttons.auth.sign_in')
                </button>

                <hr class="mt-3 mb-2">

                <div class="text-center">
                    <a class="small" href="{{ route('password.request') }}">
                        <i class="fa fa-unlock-alt mr-1 text-muted"></i>
                        @lang('links.auth.forgot_password')
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
