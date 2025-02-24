@if (user()->hasAnyPermission(['roles.add', 'roles.edits']))
    @include('components.inputs.inputSelect', [
        'col' => '6',
        'name' => 'role_ids[]',
        'class' => 'select2',
        'attrs' => 'multiple',
        'selectData' => getDataByModel('App\Models\Role'),
        'label' => __('translation.User roles'),
        'value' => $single?->roles()?->pluck('id')->toArray(),
    ])
@endif
