<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $modules = getSidebarMenuItems();
        foreach ($modules as $module) {
            foreach ($module['items'] as $item) {
                // Get route name (remove ".index" from it)
                if (!empty($item['route'])) {

                    $routeName = $item['route'];
                    $permissionName = str_replace('.index', '', $routeName);

                    // Create permission
                    $permissions[] = [
                        'name' => $permissionName,
                        'guard_name' => 'web',
                    ];
                }
            }
        }
        Permission::where('name', 'root')->delete();
        foreach ($permissions as $permission) {
            if ($permission['name'] != 'root') {
                if (!Permission::where('name', $permission['name'])->exists()) {
                    Permission::create($permission);
                }
            }
        }
    }
}
