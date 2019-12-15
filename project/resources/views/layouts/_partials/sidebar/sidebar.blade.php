<aside class="left-sidebar" data-sidebarbg="skin6">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect"
                       href="/">
                        <i class="fa fa-dashboard"></i>
                        <span class="hide-menu">
                            @lang('links.common.dashboard')
                        </span>
                    </a>
                </li>

                @if (current_user()->can('orders view'))
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect"
                       href="{{route('users.index')}}">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="hide-menu">
                            @lang('links.common.orders')
                        </span>
                    </a>
                </li>
                @endif

                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect"
                       href="{{route('products.index')}}">
                        <i class=" fas fa-shopping-basket"></i>
                        <span class="hide-menu">
                            @lang('links.common.products')
                        </span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect"
                       href="{{route('users.index')}}">
                        <i class="fas fa-users"></i>
                        <span class="hide-menu">
                            @lang('links.common.clients')
                        </span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect"
                       href="{{route('users.index')}}">
                        <i class="fas fa-user"></i>
                        <span class="hide-menu">
                            @lang('links.common.users')
                        </span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect"
                       href="{{route('bills.index')}}">
                        <i class=" fas fa-calendar-alt"></i>
                        <span class="hide-menu">
                            @lang('links.common.financial_schedule')
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
