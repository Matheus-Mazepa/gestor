@extends('layouts.auth')

@section('content')
    <div class="card card-signin my-5">
        <div class="card-body">
            <div class="card-title text-center">
                @lang('headings.auth.reset_password')
            </div>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form class="form-signin" method="POST" action="{{ url('/password/email') }}">
                @csrf

                <div class="form-label-group">
                    <label for="email">Email address</label>
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

                <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">
                    @lang('buttons.auth.recover')
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
