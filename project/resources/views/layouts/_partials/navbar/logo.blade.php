<div>
    <a class="navbar-brand" href="{{ url('/') }}">
        <b class="logo-icon">
            <img src="{{ asset('/assets/img/logo-icon.png') }}" alt="homepage" class="dark-logo"/>
            <img src="{{ asset('/assets/img/logo-light-icon.png') }}" alt="homepage" class="light-logo"/>
        </b>
        <span class="logo-text">
            <img src="{{ asset('/assets/img/logo-text.png') }}" alt="homepage" class="dark-logo"/>
            <img src="{{ asset('/assets/img/logo-light-text.png') }}" class="light-logo" alt="homepage"/>
            {{ config('app.name') }}
        </span>
    </a>
</div>

