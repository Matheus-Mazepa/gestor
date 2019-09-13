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

<li class="sidebar-item">
    <a class="sidebar-link waves-effect waves-dark sidebar-link"
       href="{{ route('admin.users.index') }}"
       aria-expanded="false">
        <i class="fa fa-user"></i>
        <span class="hide-menu">
            @lang('links.common.users')
        </span>
    </a>
</li>

