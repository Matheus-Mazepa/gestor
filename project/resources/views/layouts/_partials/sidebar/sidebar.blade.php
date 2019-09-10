<aside class="left-sidebar" data-sidebarbg="skin6">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="p-3">
                    <a href="javascript:void(0)"
                       class="btn btn-block create-btn text-white no-block d-flex align-items-center">
                        <i class="fa fa-plus-square"></i>
                        <span class="hide-menu ml-5">
                            @lang('links.common.create_new')
                        </span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link"
                       href="#Dasboard"
                       aria-expanded="false">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span class="hide-menu">
                            @lang('links.common.dashboard')
                        </span>
                    </a>
                </li>

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
