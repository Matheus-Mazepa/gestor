<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic"
       href=""
       data-toggle="dropdown"
       aria-haspopup="true"
       aria-expanded="false">
        <span class="text-light mr-2">{{ current_user()->name }}</span>
        <img src="{{ asset('assets/img/users/1.jpg') }}" alt="user" class="rounded-circle" width="31">
    </a>

    <div class="dropdown-menu dropdown-menu-right user-dd animated">
        <a class="dropdown-item" href="javascript:void(0)">
            <i class="fa fa-user mr-3 ml-2"></i>
            @lang('links.common.my_profile')
        </a>
        <a class="dropdown-item" href="{{ route('logout') }}"
           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <i class="fa fa-power-off mr-3 ml-2"></i>
            @lang('links.auth.logout')
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</li>
