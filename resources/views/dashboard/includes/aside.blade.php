<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
    <div class="container">
        <!--begin::Header Menu-->
        <div id="kt_header_menu"
             class="header-menu header-menu-left header-menu-mobile header-menu-layout-default header-menu-root-arrow">

            <!--begin::Header Nav-->
            <ul class="menu-nav">
                <li class="menu-item {{ request()->is('/') ? 'menu-item-open menu-item-here' : '' }}">
                    <a href="{{route('dashboard.index')}}" class="menu-link">
                        <span class="menu-text">الرئسية</span>
                    </a>
                </li>
                @hasRoleOnModel('user')
                @can('read_user')
                <li class="menu-item {{ request()->is('users*') ? 'menu-item-open menu-item-here' : '' }}">
                    <a @can('read_user')
                       href="{{route('dashboard.users.index')}}"
                       @elsecan('create_product')
                       href="{{route('dashboard.users.create')}}"
                       @endcan
                       class="menu-link">
                        <span class="menu-text">المستخدمين</span>
                    </a>
                </li>
                @endcan
                @endhasRoleOnModel
                @hasRoleOnModel('role')
                @can('read_role')
                <li class="menu-item {{ request()->is('roles*') ? 'menu-item-open menu-item-here' : '' }}">
                    <a @can('read_role')
                       href="{{route('dashboard.roles.index')}}"
                       @elsecan('create_role')
                       href="{{route('dashboard.roles.create')}}"
                       @endcan
                       class="menu-link">
                        <span class="menu-text">القواعد</span>
                    </a>
                </li>
                @endcan
                @endhasRoleOnModel
                @hasRoleOnModel('product')
                @can('read_product')
                <li class="menu-item {{ request()->is('products*') ? 'menu-item-open menu-item-here' : '' }}">
                    <a @can('read_product')
                       href="{{route('dashboard.products.index')}}"
                       @elsecan('create_product')
                       href="{{route('dashboard.products.create')}}"
                       @endcan
                       class="menu-link">
                        <span class="menu-text">المنتجات</span>
                    </a>
                </li>
                @endcan
                @endhasRoleOnModel
                @hasRoleOnModel('expense')
                @can('read_expense')
                    <li class="menu-item {{ request()->is('expenses*') ? 'menu-item-open menu-item-here' : '' }}">
                        <a @can('read_expense')
                               href="{{route('dashboard.expenses.index')}}"
                           @elsecan('create_expense')
                               href="{{route('dashboard.expenses.create')}}"
                           @endcan
                           class="menu-link">
                            <span class="menu-text">المصروفات</span>
                        </a>
                    </li>
                @endcan
                @endhasRoleOnModel
                @hasRoleOnModel('company')
                @can('read_company')
                <li class="menu-item {{ request()->is('companies*') ? 'menu-item-open menu-item-here' : '' }}">
                    <a @can('read_company')
                       href="{{route('dashboard.companies.index')}}"
                       @elsecan('create_company')
                       href="{{route('dashboard.companies.create')}}"
                       @endcan
                       class="menu-link">
                        <span class="menu-text">المندوب</span>
                    </a>
                </li>
                @endcan
                @endhasRoleOnModel
               @hasRoleOnModel('supplier')
                @can('read_supplier')
                <li class="menu-item {{ request()->is('suppliers*') ? 'menu-item-open menu-item-here' : '' }}">
                    <a @can('read_supplier')
                       href="{{route('dashboard.suppliers.index')}}"
                       @elsecan('create_supplier')
                       href="{{route('dashboard.suppliers.create')}}"
                       @endcan
                       class="menu-link">
                        <span class="menu-text">المورد</span>
                    </a>
                </li>
                @endcan
                @endhasRoleOnModel
                @hasRoleOnModel('bill')
                @canany(['read_bill','read_own_bill'])
                <li class="menu-item {{ request()->is('bills*') ? 'menu-item-open menu-item-here' : '' }}">
                    <a @canany(['read_bill','read_own_bill'])
                       href="{{route('dashboard.bills.index')}}"
                       @elsecan('create_bill')
                       href="{{route('dashboard.bills.create')}}"
                       @endcanany
                       class="menu-link">
                        <span class="menu-text">الفواتير</span>
                    </a>
                </li>
                @endcanany
                @endhasRoleOnModel
                @hasRoleOnModel('report')
                @can('read_report')
                <li class="menu-item {{ request()->is('reports*') ? 'menu-item-open menu-item-here' : '' }}">
                    <a @can('read_report')
                       href="{{route('dashboard.reports.index')}}"
                       @endcan
                       class="menu-link">
                        <span class="menu-text">التقارير</span>
                    </a>
                </li>
                @endcan
                @endhasRoleOnModel
                @hasRoleOnModel('finance')
                @can('read_finance')
                    <li class="menu-item {{ request()->is('finance*') ? 'menu-item-open menu-item-here' : '' }}">
                        <a @can('read_finance')
                               href="{{route('dashboard.finance.index')}}"
                           @endcan
                           class="menu-link">
                            <span class="menu-text">الحسابات</span>
                        </a>
                    </li>
                @endcan
                @endhasRoleOnModel
                @hasRoleOnModel('delivery')
                @can('read_delivery')
                <li class="menu-item {{ request()->is('deliveries*') ? 'menu-item-open menu-item-here' : '' }}">
                    <a @can('read_delivery')
                       href="{{route('dashboard.deliveries.index')}}"
                       @endcan
                       class="menu-link">
                        <span class="menu-text">التسليم و المرتجعات</span>
                    </a>
                </li>
                 @endcan
                @endhasRoleOnModel
            </ul>
            <!--end::Header Nav-->
        </div>
        <!--end::Header Menu-->
    </div>
</div>
