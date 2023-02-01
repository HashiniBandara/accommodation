<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
    <!--begin::Menu Container-->
    <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1"
        data-menu-dropdown-timeout="500">
        <!--begin::Menu Nav-->
        <ul class="menu-nav">
            @if (AdminServiceProvider::getAuthUserPermission(AdminServiceProvider::BACKEND_DASHBOARD_ROUTE))
                <li class="menu-item" aria-haspopup="true">
                    <a href="{{ route(AdminServiceProvider::BACKEND_DASHBOARD_ROUTE) }}" class="menu-link">
                        <i class="fas fa-layer-group menu-icon"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
            @endif

            @if (AdminServiceProvider::getAuthUserPermission('', 'pages'))
                <li class="menu-section">
                    <h4 class="menu-text">Pages</h4>
                </li>
                <li class="menu-item menu-item-submenu">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <i class="fas fa-scroll menu-icon"></i>
                        <span class="menu-text">Pages</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu menu-submenu-classic menu-submenu-right">
                        <ul class="menu-subnav">

                            @if (AdminServiceProvider::getAuthUserPermission(SettingsRoutePath::HOME_PAGE))
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ route(SettingsRoutePath::HOME_PAGE) }}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                        <span class="menu-text">Home Page</span>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </li>
            @endif

            {{-- accommodation types --}}
            @if (AdminServiceProvider::getAuthUserPermission('', 'user_role'))
                <li class="menu-item menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <i class="fas fa-hotel menu-icon"></i>
                        <span class="menu-text">Accommodation Types</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu menu-submenu-classic menu-submenu-right">
                        <ul class="menu-subnav">

                            @if (AdminServiceProvider::getAuthUserPermission(AdminServiceProvider::ACCOMMODATION_TYPE_CREATE_ROUTE))
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ route(AdminServiceProvider::ACCOMMODATION_TYPE_CREATE_ROUTE) }}"
                                        class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                        <span class="menu-text">Add New Type</span>
                                    </a>
                                </li>
                            @endif

                            @if (AdminServiceProvider::getAuthUserPermission(AdminServiceProvider::ACCOMMODATION_LIST_VIEW_ROUTE))
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ route(AdminServiceProvider::ACCOMMODATION_LIST_VIEW_ROUTE) }}"
                                        class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                        <span class="menu-text">View All Types</span>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </li>
            @endif

            @if (AdminServiceProvider::getAuthUserPermission('', 'user_role'))
                <li class="menu-item menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <i class="fas fa-warehouse menu-icon"></i>
                        <span class="menu-text">Accommodations</span>
                        <i class="menu-arrow"></i>
                    </a>

                    <div class="menu-submenu menu-submenu-classic menu-submenu-right">
                        <ul class="menu-subnav">

                            @if (AdminServiceProvider::getAuthUserPermission(AdminServiceProvider::ACCOMMODATION_DETAILS_CREATE_ROUTE))
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ route(AdminServiceProvider::ACCOMMODATION_DETAILS_CREATE_ROUTE) }}"
                                        class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                        <span class="menu-text">Accommodation Details</span>
                                    </a>
                                </li>
                            @endif

                            @if (AdminServiceProvider::getAuthUserPermission(AdminServiceProvider::ACCOMMODATION_DETAILS_LIST_VIEW_ROUTE))
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ route(AdminServiceProvider::ACCOMMODATION_DETAILS_LIST_VIEW_ROUTE) }}"
                                        class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                        <span class="menu-text">View Accommodation Details</span>
                                    </a>
                                </li>
                            @endif

                            {{-- @if (AdminServiceProvider::getAuthUserPermission(AdminServiceProvider::VIEW_ACCOMMODATION_CREATE_ROUTE))
                            <li class="menu-item" aria-haspopup="true">
                                <a href="{{ route(AdminServiceProvider::VIEW_ACCOMMODATION_CREATE_ROUTE) }}"
                                    class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                    <span class="menu-text">View Accommodation</span>
                                </a>
                            </li>
                        @endif --}}

                        </ul>
                    </div>
                </li>
            @endif

            @if (AdminServiceProvider::getAuthUserPermission('', 'user_role') |
                    AdminServiceProvider::getAuthUserPermission('', 'user') |
                    AdminServiceProvider::getAuthUserPermission('', 'theme_setting') |
                    AdminServiceProvider::getAuthUserPermission('', 'email_setting'))
                <li class="menu-section">
                    <h4 class="menu-text">Settings</h4>
                </li>
            @endif

            @if (AdminServiceProvider::getAuthUserPermission('', 'user_role'))
                <li class="menu-item menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <i class="fas fa-users-cog menu-icon"></i>
                        <span class="menu-text">User Roles</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu menu-submenu-classic menu-submenu-right">
                        <ul class="menu-subnav">

                            @if (AdminServiceProvider::getAuthUserPermission(AdminServiceProvider::USER_ROLE_CREATE_ROUTE))
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ route(AdminServiceProvider::USER_ROLE_CREATE_ROUTE) }}"
                                        class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                        <span class="menu-text">Add New Role</span>
                                    </a>
                                </li>
                            @endif

                            @if (AdminServiceProvider::getAuthUserPermission(AdminServiceProvider::USER_ROLE_LIST_ROUTE))
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ route(AdminServiceProvider::USER_ROLE_LIST_ROUTE) }}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                        <span class="menu-text">View All Roles</span>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </li>
            @endif

            @if (AdminServiceProvider::getAuthUserPermission('', 'user'))
                <li class="menu-item menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <i class="fas fa-user menu-icon"></i>
                        <span class="menu-text">Users</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu menu-submenu-classic menu-submenu-right">
                        <ul class="menu-subnav">

                            @if (AdminServiceProvider::getAuthUserPermission(AdminServiceProvider::USER_CREATE_ROUTE))
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ route(AdminServiceProvider::USER_CREATE_ROUTE) }}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                        <span class="menu-text">Add New User</span>
                                    </a>
                                </li>
                            @endif

                            @if (AdminServiceProvider::getAuthUserPermission(AdminServiceProvider::USER_LIST_ROUTE))
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ route(AdminServiceProvider::USER_LIST_ROUTE) }}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                        <span class="menu-text">View All Users</span>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </li>
            @endif

            @if (AdminServiceProvider::getAuthUserPermission('', 'theme_setting'))
                <li class="menu-item">
                    <a href="{{ route(SettingsRoutePath::THEME) }}" class="menu-link menu-toggle">
                        <i class="fas fa-paint-roller menu-icon"></i>
                        <span class="menu-text">Theme Settings</span>
                    </a>
                </li>
            @endif

            @if (AdminServiceProvider::getAuthUserPermission('', 'email_setting'))
                <li class="menu-item">
                    <a href="{{ route(SettingsRoutePath::EMAIL) }}" class="menu-link menu-toggle">
                        <i class="fas fa-at menu-icon"></i>
                        <span class="menu-text">Email Settings</span>
                    </a>
                </li>
            @endif

        </ul>
        <!--end::Menu Nav-->
    </div>
    <!--end::Menu Container-->
</div>
