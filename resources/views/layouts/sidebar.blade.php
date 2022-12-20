{{--Left sidebar--}}
<nav class="mt-2">

    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link {{ Request::is('home*') ? "active":'' }}">
                <i class="fas fa-cog"></i>
                <sub><i class="fas fa-child"></i></sub>
                <p>Главная</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('paymentIndex') }}" class="nav-link {{ Request::is('payment*') ? "active":'' }}">
                <i class="fas fa-cog"></i>
                <sub><i class="fas fa-child"></i></sub>
                <p>@lang('cruds.payment.payment')</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('clientIndex') }}" class="nav-link {{ Request::is('client*') ? "active":'' }}">
                <i class="fas fa-cog"></i>
                <sub><i class="fas fa-child"></i></sub>
                <p>@lang('cruds.client.clients')</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('brandIndex') }}" class="nav-link {{ Request::is('brand*') ? "active":'' }}">
                <i class="fas fa-cog"></i>
                <sub><i class="fas fa-child"></i></sub>
                <p>@lang('cruds.brand.brands')</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('merchantIndex') }}" class="nav-link {{ Request::is('merchant*') ? "active":'' }}">
                <i class="fas fa-cog"></i>
                <sub><i class="fas fa-child"></i></sub>
                <p>@lang('cruds.merchant.merchants')</p>
            </a>
        </li>


        @canany([
  'permission.show',
  'roles.show',
  'user.show'
])
            <li class="nav-item has-treeview">
                <a href="#"
                   class="nav-link {{ (Request::is('permission*') || Request::is('role*') || Request::is('user*')) ? 'active':''}}">
                    <i class="fas fa-users-cog"></i>
                    <p>
                        @lang('cruds.userManagement.title')
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview"
                    style="display: {{ (Request::is('permission*') || Request::is('role*') || Request::is('user*')) ? 'block':'none'}};">
                    @can('permission.show')
                        <li class="nav-item">
                            <a href="{{ route('permissionIndex') }}"
                               class="nav-link {{ Request::is('permission*') ? "active":'' }}">
                                <i class="fas fa-key"></i>
                                <p> @lang('cruds.permission.title_singular')</p>
                            </a>
                        </li>
                    @endcan

                    @can('roles.show')
                        <li class="nav-item">
                            <a href="{{ route('roleIndex') }}"
                               class="nav-link {{ Request::is('role*') ? "active":'' }}">
                                <i class="fas fa-user-lock"></i>
                                <p> @lang('cruds.role.fields.roles')</p>
                            </a>
                        </li>
                    @endcan

                    @can('user.show')
                        <li class="nav-item">
                            <a href="{{ route('userIndex') }}"
                               class="nav-link {{ Request::is('user*') ? "active":'' }}">
                                <i class="fas fa-user-friends"></i>
                                <p> @lang('cruds.user.title')</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany

    </ul>

    {{--    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">--}}
    {{--        <li class="nav-item has-treeview">--}}
    {{--            <a href="" class="nav-link">--}}
    {{--                <i class="fas fa-palette"></i>--}}
    {{--                <p>--}}
    {{--                    @lang('global.theme')--}}
    {{--                    <i class="right fas fa-angle-left"></i>--}}
    {{--                </p>--}}
    {{--            </a>--}}
    {{--            <ul class="nav nav-treeview" style="display: none">--}}
    {{--                <li class="nav-item">--}}
    {{--                    <a href="{{ route('userSetTheme',[auth()->id(),'theme' => 'default']) }}" class="nav-link">--}}
    {{--                        <i class="nav-icon fas fa-circle text-info"></i>--}}
    {{--                        <p class="text">Default {{ auth()->user()->theme == 'default' ? '✅':'' }}</p>--}}
    {{--                    </a>--}}
    {{--                </li>--}}
    {{--                <li class="nav-item">--}}
    {{--                    <a href="{{ route('userSetTheme',[auth()->id(),'theme' => 'light']) }}" class="nav-link">--}}
    {{--                        <i class="nav-icon fas fa-circle text-white"></i>--}}
    {{--                        <p>Light {{ auth()->user()->theme == 'light' ? '✅':'' }}</p>--}}
    {{--                    </a>--}}
    {{--                </li>--}}
    {{--                <li class="nav-item">--}}
    {{--                    <a href="{{ route('userSetTheme',[auth()->id(),'theme' => 'dark']) }}" class="nav-link">--}}
    {{--                        <i class="nav-icon fas fa-circle text-gray"></i>--}}
    {{--                        <p>Dark {{ auth()->user()->theme == 'dark' ? '✅':'' }}</p>--}}
    {{--                    </a>--}}
    {{--                </li>--}}
    {{--            </ul>--}}
    {{--        </li>--}}
    {{--    </ul>--}}
    {{--    @can('card.main')--}}

    {{--    @endcan--}}
</nav>
