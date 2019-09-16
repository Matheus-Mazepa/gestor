<ul class="nav nav-pills flex-column flex-lg-row">
    {{-- @can('users maintain admin') --}}
        <li class="nav-item">
            <a class="nav-link waves-effect waves-dark {{ is_active('admin.users.admin.index', 'active', true) }}"
            href="{{ route('admin.users.admin.index') }}">
                <i class="fas fa-user-shield mr-2"></i>@lang('headings.users.admins.index')
            </a>
        </li>
    {{-- @endcan --}}

    {{-- @can('users maintain client') --}}
        <li class="nav-item">
            <a class="nav-link waves-effect waves-dark {{ is_active('admin.users.client.index', 'active', true) }}"
            href="{{ route('admin.users.client.index') }}">
                <i class="fas fa-user mr-2"></i>@lang('headings.users.clients.index')
            </a>
        </li>
    {{-- @endcan --}}
</ul>
