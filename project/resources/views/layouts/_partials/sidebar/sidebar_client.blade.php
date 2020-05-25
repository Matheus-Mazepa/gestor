<aside class="left-sidebar" data-sidebarbg="skin6">
    <div class="scroll-sidebar">
        <nav class="navbar navbar-expand-lg navbar-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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

                    @if (current_user()->can('orders view'))
                        <li class="nav-item ">
                            <a class="nav-link"
                               href="{{route('client.users.index')}}">
                                <i class="fa fa-shopping-cart"></i>
                                <span class="hide-menu">
                                    @lang('links.common.orders')
                                </span>
                            </a>
                        </li>
                    @endif
                    @if (current_user()->can('products view') || current_user()->can('categories view'))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="{{route('client.products.index')}}"
                               id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                <i class=" fa fa-shopping-basket"></i>
                                <span class="hide-menu">
                                    @lang('links.common.products')
                                </span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="nav-link"
                                   href="{{route('client.products.index')}}">
                                    @lang('links.common.products')
                                </a>
                                <a class="nav-link"
                                   href="{{route('client.categories.index')}}">
                                    @lang('links.common.categories')
                                </a>
                            </div>
                        </li>
                    @endif

                    @if (current_user()->can('clients view'))
                        <li class="nav-item ">
                            <a class="nav-link"
                               href="{{route('client.clients.index')}}">
                                <i class="fa fa-users"></i>
                                <span class="hide-menu">
                                    @lang('links.common.clients')
                                </span>
                            </a>
                        </li>
                    @endif

                    @if (current_user()->can('users view'))
                        <li class="nav-item ">
                            <a class="nav-link"
                               href="{{route('client.users.index')}}">
                                <i class="fa fa-user"></i>
                                <span class="hide-menu">
                                    @lang('links.common.users')
                                </span>
                            </a>
                        </li>
                    @endif

                    @if (current_user()->can('financial_schedule view'))
                        <li class="nav-item ">
                            <a class="nav-link"
                               href="{{route('client.bills.index')}}">
                                <i class=" fa fa-calendar"></i>
                                <span class="hide-menu">
                                    @lang('links.common.financial_schedule')
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
