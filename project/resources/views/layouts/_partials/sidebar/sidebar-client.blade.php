<li class="sidebar-item">
    <a class="sidebar-link waves-effect"
       href="#Dasboard"
       aria-expanded="false">
        <i class="fa fa-dashboard"></i>
        <span class="hide-menu">
            @lang('links.common.dashboard')
        </span>
    </a>
</li>

<li class="sidebar-item">
    <a class="sidebar-link has-arrow waves-effect" href="#" aria-expanded="false">
        <i class="fa fa-globe"></i>
        <span class="hide-menu">@lang('links.my_site.index')</span>
    </a>
    <ul aria-expanded="false" class="collapse first-level ml-3">
        <li class="sidebar-item">
            <a href="{{ route('client.template_images.index') }}" class="sidebar-link">
                <i class="fa fa-newspaper"></i>
                <span class="hide-menu">@lang('links.template_images.index')</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a href="#" class="sidebar-link">
                <i class="fa fa-server"></i>
                <span class="hide-menu">@lang('links.domains.index')</span>
            </a>
        </li>
    </ul>
</li>
