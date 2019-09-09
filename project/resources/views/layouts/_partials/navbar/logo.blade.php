<div>
    <a class="navbar-brand" href="{{ url('/') }}">
        <b class="logo-icon">
            <img src="{{ asset('/assets/img/logo-icon.png') }}" alt="homepage" class="dark-logo"/>
            <img src="{{ asset('/assets/img/logo-light-icon.png') }}" alt="homepage" class="light-logo"/>
        </b>
        <span class="logo-text">
            <img src="{{ asset('/assets/img/logo-text.png') }}" alt="homepage" class="dark-logo"/>
            <img src="{{ asset('/assets/img/logo-light-text.png') }}" class="light-logo" alt="homepage"/>
            {{ config('app.name', 'Laravel') }}
        </span>
    </a>
    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
        <i class="ti-menu ti-close"></i>
    </a>
</div>

