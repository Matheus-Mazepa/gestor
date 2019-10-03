<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <div class="nav-item">
            <a class="nav-link waves-effect {{ is_active('admin.users.admin.index') }}"
               href="{{ route('admin.users.admin.index') }}">
                <i class="fas fa-user-shield mr-2"></i>
                @lang('headings.users.admins.index')
            </a>
        </div>

        <div class="nav-item">
            <a class="nav-link waves-effect {{ is_active('admin.users.client.index') }}"
               href="{{ route('admin.users.client.index') }}">
                <i class="fas fa-user mr-2"></i>
                @lang('headings.users.clients.index')
            </a>
        </div>
    </div>
</nav>
