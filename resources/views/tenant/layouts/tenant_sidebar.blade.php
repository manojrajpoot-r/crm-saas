<div class="sidebar">
    <div class="scrollbar-inner sidebar-wrapper">
        @php
        $menus = \App\Helpers\SidebarHelper::fullMenu();
        $current = request()->url();
        @endphp

<ul class="nav">

@foreach($menus as $menu)
@if($menu)

    {{-- Dropdown --}}
    @if(isset($menu['submenu']))
        @php
            $open = false;
            foreach($menu['submenu'] as $sub){
                if(str_contains($current, $sub['url'])) $open = true;
            }
        @endphp

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
                                    <span class="sub-item">{{ $sub['name'] }}</span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </li>

    {{-- Normal link --}}
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

@endif
@endforeach

</ul>

    </div>
</div>
