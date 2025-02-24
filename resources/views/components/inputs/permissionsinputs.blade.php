@php
    $modules = getDataByModel(App\Models\ModuleConfig::class);
@endphp
<hr>
<div class="col-md-{{ $col ?? 12 }}">
    <!-- Global "Check All" checkbox for all permissions -->
    <div class="mb-3">
        <label>
            <input type="checkbox" id="check-all"> Check All Permissions
        </label>
    </div>

    <table class="table table-bordered">
        <tbody>
            @foreach ($modules as $module)
                <tr>
                    <!-- Module Name with individual Check All -->
                    <td>
                        <input type="checkbox" class="check-all" data-module="{{ $module->module_name }}">
                        {{ __('translation.' . ucfirst($module->module_name)) }}
                    </td>
                    @php
                        $permissions = $module->actions;
                    @endphp

                    <!-- Loop over each permission for the module -->
                    @foreach ($permissions as $permission)
                        <td>
                            {{ __('translation.' . ucfirst($permission->action)) }}
                            <?php
                            $permission = App\Models\Permission::where('name', $module->module_name . '.' . $permission->action)->first()->id;
                            ?>
                            <input type="checkbox" name="permissions[]" value="{{ $permission }}"
                                class="module-permission {{ $module->module_name }}"
                                @if ($single->rolePermissions()->where('permission_id', $permission)->exists()) checked @endif>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Event listener for the global "Check All" checkbox (select all permissions)
        const globalCheckAll = document.getElementById('check-all');

        globalCheckAll.addEventListener('change', function() {
            // Select or deselect all checkboxes
            const allCheckboxes = document.querySelectorAll('input[type="checkbox"].module-permission');
            allCheckboxes.forEach(function(checkbox) {
                checkbox.checked = globalCheckAll.checked;
            });
        });

        // Event listener for individual "Check All" checkboxes for each module
        const checkAllElements = document.querySelectorAll('.check-all');

        checkAllElements.forEach(function(checkAllElement) {
            checkAllElement.addEventListener('change', function() {
                const moduleName = checkAllElement.getAttribute('data-module');

                // Get all checkboxes related to this module
                const checkboxes = document.querySelectorAll('.' + moduleName);
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = checkAllElement.checked;
                });
            });
        });
    });
</script>
