@php
    $menus = \App\Helpers\SidebarHelper::menu();
    $current = request()->url();
@endphp

<div class="sidebar">
    <div class="scrollbar-inner sidebar-wrapper">
        <ul class="nav">

            @foreach($menus as $menu)

                {{-- DROPDOWN --}}
                @if(isset($menu['submenu']))

                    @php
                        $open = false;
                        foreach ($menu['submenu'] as $sub) {
                            if (str_contains($current, $sub['url'])) {
                                $open = true;
                            }
                        }
                    @endphp

                    @if(!$menu['permission'] || canAccess($menu['permission']))
                        <li class="nav-item {{ $open ? 'active submenu' : '' }}">
                            <a data-bs-toggle="collapse" href="#menu{{ Str::slug($menu['name']) }}">
                                <i class="{{ $menu['icon'] }}"></i>
                                <p>{{ $menu['name'] }}</p>
                                <span class="caret"></span>
                            </a>

                            <div class="collapse {{ $open ? 'show' : '' }}" id="menu{{ Str::slug($menu['name']) }}">
                                <ul class="nav nav-collapse">
                                    @foreach($menu['submenu'] as $sub)
                                        @if(!$sub['permission'] || canAccess($sub['permission']))
                                            <li class="{{ str_contains($current, $sub['url']) ? 'active' : '' }}">
                                                <a href="{{ $sub['url'] }}">
                                                    <span class="sub-item">
                                                        <i class="{{ $sub['icon'] }}"></i>
                                                        {{ $sub['name'] }}
                                                    </span>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endif

                {{-- SINGLE ITEM --}}
                @else
                    @if(!$menu['permission'] || canAccess($menu['permission']))
                        <li class="nav-item {{ str_contains($current, $menu['url']) ? 'active' : '' }}">
                            <a href="{{ $menu['url'] }}">
                                <i class="{{ $menu['icon'] }}"></i>
                                <p>{{ $menu['name'] }}</p>
                            </a>
                        </li>
                    @endif
                @endif

            @endforeach


        </ul>


            <form method="POST"
                action="{{ currentGuard() === 'saas'
                        ? route('saas.logout')
                        : route('tenant.logout', ['tenant' => currentTenant()]) }}"
                data-logout="true">
                @csrf
                <button type="button" style="margin-left: 22px;" class="btn btn-danger logoutBtn">Logout</button>
            </form>

    </div>
</div>
