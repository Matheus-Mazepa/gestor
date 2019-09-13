<aside class="left-sidebar" data-sidebarbg="skin6">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="p-3">
                    <a href="#"
                       class="btn btn-block btn-primary text-white no-block d-flex align-items-center">
                        <i class="fa fa-plus-square"></i>
                        <span class="hide-menu ml-5">
                            @lang('links.common.create_new')
                        </span>
                    </a>
                </li>

                @if (is_user_type('admin'))
                    @include('layouts._partials.sidebar.sidebar-admin')
                @endif

                @if (is_user_type('client'))
                    @include('layouts._partials.sidebar.sidebar-client')
                @endif

                <li class="collapse p-3 upgrade-btn" id="collapseLogout">
                    <a class="btn btn-block btn-danger text-white"
                       href="{{ route('logout') }}"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="fa fa-power-off mr-3"></i>
                        @lang('links.auth.logout')
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>
