<div class="sidebar">
    <div class="scrollbar-inner sidebar-wrapper">
        <ul class="nav">
            @php $menus = \App\Helpers\SidebarHelper::fullMenu(); @endphp

            @foreach ($menus as $menu)
                @if (!$menu['permission'] || canAccess($menu['permission']))
                    <li>
                        <a href="{{ $menu['url'] }}">
                            <i class="{{ $menu['icon'] }}"></i>
                            {{ $menu['name'] }}
                        </a>
                    </li>
                @endif
            @endforeach

        </ul>
    </div>
</div>
