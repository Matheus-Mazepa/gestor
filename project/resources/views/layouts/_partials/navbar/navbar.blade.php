<header class="topbar" data-navbarbg="skin5">
    <nav class="navbar top-navbar navbar-expand-md navbar-light bg-primary">
        <div class="navbar-header">
           @include('layouts._partials.navbar.logo')

            <a class="nav-toggler waves-effect waves-light d-block d-md-none"
               data-toggle="collapse"
               href="#collapseLogout"
               role="button"
               aria-expanded="false"
               aria-controls="collapseLogout">
                <i class="fa fa-bars"></i>
            </a>
        </div>

        <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
            <div class="navbar-nav float-left mr-auto">
                {{-- LOGO --}}
            </div>

            <ul class="navbar-nav float-right">
                @include('layouts._partials.navbar.profile')
            </ul>
        </div>
    </nav>
</header>
