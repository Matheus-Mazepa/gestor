<aside class="left-sidebar" data-sidebarbg="skin6">
    <div class="scroll-sidebar">
        <nav class="navbar navbar-expand-lg navbar-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item ">
                        <a class="nav-link"
                           href="/">
                            <i class="fa fa-dashboard"></i>
                            <span class="hide-menu">
                            @lang('links.common.dashboard')
                        </span>
                        </a>
                    </li>

                    @if (current_user()->can('users_admin view'))
                        <li class="nav-item ">
                            <a class="nav-link"
                               href="{{route('admin.users-admin.index')}}">
                                <i class="fa fa-user"></i>
                                <span class="hide-menu">
                                    @lang('links.common.users_admin')
                                </span>
                            </a>
                        </li>
                    @endif

                    @if (current_user()->can('companies view'))
                        <li class="nav-item ">
                            <a class="nav-link"
                               href="{{route('admin.companies.index')}}">
                                <i class="fa fa-building"></i>
                                <span class="hide-menu">
                                    @lang('links.common.companies')
                                </span>
                            </a>
                        </li>
                    @endif
                </ul>

                <ul class="navbar-nav float-right">
                    @include('layouts._partials.navbar.profile')
                </ul>
            </div>
        </nav>
    </div>
</aside>