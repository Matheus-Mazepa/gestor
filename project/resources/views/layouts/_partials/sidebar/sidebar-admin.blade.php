<li class="sidebar-item">
    <a class="sidebar-link waves-effect"
       href="#Dasboard">
        <i class="fa fa-dashboard"></i>
        <span class="hide-menu">
            @lang('links.common.dashboard')
        </span>
    </a>
</li>

<li class="sidebar-item">
    <a class="sidebar-link waves-effect {{ is_active('admin.users.admin.index') }}"
       href="{{ route('admin.users.admin.index') }}">
        <i class="fa fa-users"></i>
          <span class="hide-menu">
            @lang('links.common.users')
        </span>
    </a>
</li>

<li class="sidebar-item">
    <a class="sidebar-link waves-effect {{ is_active('admin.template_images.index') }}"
       href="{{ route('admin.template_images.index') }}">
        <i class="fa fa-newspaper"></i>
        <span class="hide-menu">
            @lang('links.template_images.index')
        </span>
    </a>
</li>
