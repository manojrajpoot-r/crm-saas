@php
    $menus = \App\Helpers\SidebarHelper::menu();
    $current = request()->url();
@endphp

<div class="sidebar">
    <div class="scrollbar-inner sidebar-wrapper">
        <ul class="nav">


            @foreach($menus as $menu)

                @if(isset($menu['submenu']))
                    @php
                        $open = false;
                        foreach ($menu['submenu'] as $sub) {
                            if (str_contains($current, $sub['url'])) {
                                $open = true;
                            }
                        }
                    @endphp

                    <li class="nav-item {{ $open ? 'active submenu' : '' }}">
                        <a data-bs-toggle="collapse" href="#menu{{ Str::slug($menu['name']) }}">
                            <i class="{{ $menu['icon'] }}"></i>
                            <p>{{ $menu['name'] }}</p>
                            <span class="caret"></span>
                        </a>

                        <div class="collapse {{ $open ? 'show' : '' }}"
                             id="menu{{ Str::slug($menu['name']) }}">
                            <ul class="nav nav-collapse">
                                @foreach($menu['submenu'] as $sub)
                                    <li class="{{ str_contains($current, $sub['url']) ? 'active' : '' }}">
                                        <a href="{{ $sub['url'] }}">
                                            <span class="sub-item">
                                                <i class="{{ $sub['icon'] }}"></i>
                                                {{ $sub['name'] }}
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>

                @else
                    <li class="nav-item {{ str_contains($current, $menu['url']) ? 'active' : '' }}">

                        @if(isset($menu['url']))
                            <a href="{{ $menu['url'] }}">
                                <i class="{{ $menu['icon'] }}"></i>
                                <p>{{ $menu['name'] }}</p>
                            </a>
                        @endif

                    </li>
               @endif
            @endforeach

                 <li class="nav-item sidebar-profile">
                    <a href="{{ tenantRoute('employee.my-profile') }}" class="d-flex align-items-center">
                        <div class="profile-img-wrapper">
                            <img src="{{ auth()->user()->employee->profile
                                ? asset('uploads/employees/profile/'.auth()->user()->employee->profile)
                                : asset('assets/img/default-user.png') }}"
                                class="profile-img">

                            <span class="status-dot online"></span>
                        </div>

                        <span class="ms-2">My Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ tenantRoute('employee.change-password') }}" class="nav-link d-flex align-items-center gap-2">
                        <i class="la la-lock text-warning"></i>
                        <span>Change Password</span>
                    </a>
                </li>

            <li class="nav-item">
            <form method="POST"
                action="{{ currentGuard() === 'saas'
                            ? route('saas.logout')
                            : route('tenant.logout', ['tenant' => currentTenant()]) }}">
                @csrf
                <button type="submit" style="margin-left:22px"
                        class="btn btn-danger">
                    Logout
                </button>
            </form>
            </li>
        </ul>
    </div>
</div>
