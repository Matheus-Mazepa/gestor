<header class="topbar" data-navbarbg="skin5">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header" data-logobg="skin5">
           @include('layouts._partials.navbar.logo')
        </div>

        <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
            <ul class="navbar-nav float-left mr-auto">
                @include('layouts._partials.navbar.search')
            </ul>

            <ul class="navbar-nav float-right">
                @include('layouts._partials.navbar.profile')
            </ul>
        </div>
    </nav>
</header>
