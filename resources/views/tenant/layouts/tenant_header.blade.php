
    <div class="logo-header">
        <a href="{{ currentTenant() ? tenantRoute('dashboard','saas.dashboard.index') : route('saas.dashboard.index') }}"
           class="logo">
            {{ currentTenant() ? 'Tenant Dashboard' : 'SAAS Dashboard' }}
        </a>

        <button class="navbar-toggler sidenav-toggler ml-auto" type="button">
            <span class="navbar-toggler-icon"></span>
        </button>

        <button class="topbar-toggler more">
            <i class="la la-ellipsis-v"></i>
        </button>
    </div>

    <nav class="navbar navbar-header navbar-expand-lg">
        <div class="container-fluid">

            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">

                {{-- NOTIFICATION --}}
                {{-- <li class="nav-item dropdown hidden-caret">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        <i class="la la-bell"></i>
                        <span class="notification">3</span>
                    </a>
                    <ul class="dropdown-menu notif-box animated fadeIn">
                        <li>
                            <div class="dropdown-title">You have 3 new notifications</div>
                        </li>
                    </ul>
                </li> --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" data-toggle="dropdown" id="notifBell">
                            <i class="la la-bell"></i>
                            <span class="notification d-none" id="notifCount">0</span>
                        </a>

                        <ul class="dropdown-menu notif-box" id="notifList">
                            <li class="dropdown-title">Notifications</li>
                            <li class="text-center p-2">Loading...</li>
                        </ul>
                    </li>


                {{-- PROFILE --}}
                <li class="nav-item dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#">
                        <span class="profile-username">
                            {{ auth()->user()->name ?? 'User' }}
                        </span>
                    </a>

                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <li>
                            <div class="user-box">
                                <div class="u-text">
                                    <h4>{{ auth()->user()->name ?? '' }}</h4>
                                    <p class="text-muted">{{ auth()->user()->email ?? '' }}</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <form method="POST"
                                  action="{{ currentGuard() === 'saas'
                                            ? route('saas.logout')
                                            : tenantRoute('logout','') }}">
                                @csrf
                                <button class="btn btn-danger btn-block">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>

            </ul>

        </div>
    </nav>
