@extends('layouts.auth')

@section('content-size', 'col-sm-10 col-md-8 col-lg-6')
@section('content')

    <div class="card card-signin mt-3 mb-5">
        <div class="card-body">
            <div class="card-title text-center">
                @lang('headings.auth.create_new_password')
            </div>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form class="form-signin" method="POST" action="{{ url('/password/email') }}">
                @csrf

                <div class="form-label-group">
                    <label for="email">
                        @lang('labels.auth.email')
                    </label>
                    <input
                            type="email"
                            id="email"
                            class="form-control {{ has_error_class('email') }}"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="@lang('placeholders.auth.email')"
                            autofocus>
                    @errorblock('email')
                </div>

                <div class="form-label-group">
                    <label for="password">
                        @lang('labels.auth.new_password')
                    </label>
                    <input
                            type="password"
                            id="password"
                            class="form-control {{ has_error_class('password') }}"
                            name="password"
                            value="{{ old('password') }}"
                            placeholder="@lang('placeholders.auth.new_password')"
                            autofocus>
                    @errorblock('password')
                </div>

                <div class="form-label-group">
                    <label for="passwordConfirmation">
                        @lang('labels.auth.password_confirmation')
                    </label>
                    <input
                            type="password"
                            id="passwordConfirmation"
                            class="form-control {{ has_error_class('password_confirmation') }}"
                            name="password_confirmation"
                            value="{{ old('password_confirmation') }}"
                            placeholder="@lang('placeholders.auth.password_confirmation')"
                            autofocus>
                    @errorblock('password_confirmation')
                </div>

                <button class="btn btn-lg btn-primary btn-block text-uppercase btn-auth" type="submit">
                    @lang('buttons.auth.reset_password')
                </button>

                <hr class="mt-3">

                <div class="text-center mt-3">
                    <a class="small text-muted" href="{{ route('login') }}">
                        <i class="fa fa-arrow-left mr-1 "></i>
                        @lang('links.auth.back_to_login_page')
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
