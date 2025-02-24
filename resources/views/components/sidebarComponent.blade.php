@php
    $user = user();
@endphp
@if ($user->hasAnyPermission([$model . '.list', $model . '.add']))
    <li class="{{ strpos($routeName, $model) !== false ? 'mm-active' : '' }}">

        <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class="{{ $icon }}"></i>
            <span key="t-invoices">@lang('translation.' . ucfirst($model))</span>
        </a>
        <ul class="sub-menu" aria-expanded="{{ strpos($routeName, $model) !== false ? 'true' : 'false' }}">
            @if ($user->hasPermissionTo($model . '.list'))
                <li>
                    <a class="{{ strpos($routeName, $model) !== false && strpos($routeName, 'add') === false ? 'active' : '' }}"
                        href="{{ route($model . '.list') }}" key="t-invoice-list">
                        @lang('translation.' . ucfirst($model))
                    </a>
                </li>
            @endif
            @if ($subModules)
                @foreach ($subModules as $subModule)
                    <li>
                        <a class="{{ strpos($routeName, $subModule->module_name) !== false && strpos($routeName, 'add') !== false ? 'active' : '' }}"
                            href="{{ route($subModule->module_name . '.list') }}" key="t-invoice-detail">
                            @lang('translation.' . ucfirst($subModule->module_name))
                        </a>
                    </li>
                @endforeach
            @endif
        </ul>
    </li>
@endif
