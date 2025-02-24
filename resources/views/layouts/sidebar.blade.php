<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                @foreach (getSidebarMenuItems() as $menu)
                    @php
                        $routes = array_map(function ($item) {
                            return $item['route'];
                        }, $menu['items']);
                    @endphp
                    @if (auth()->user()->hasPermissionsTo($routes))
                        <li class="menu-title">{{ $menu['title'] }}</li>
                        @foreach ($menu['items'] as $item)
                            @if (auth()->user()->hasPermissionTo($item['route']))
                                <li class="{{ $item['is_active'] ? 'active' : '' }} {{ $item['class'] }}">
                                    <a href="{{ !empty($item['route']) ? route($item['route']) : '' }}"
                                        @if ($item['is_active']) aria-current="page" @endif>
                                        <span>{{ $item['label'] }}</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>
