<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasRoles;
    use LogsActivityTrait;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'guard',
    ];
    protected $casts = [
        'name' => 'json'
    ];
    public function rolePermissions()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions', 'role_id', 'permission_id');
    }
    public function hasPermission($permission)
    {
        return $this->rolePermissions()->where('id', $permission->id)->exists();
    }
    public function handleSync()
    {
        if (request('permissions'))
            $this->rolePermissions()->sync(request('permissions'));
        else
            $this->rolePermissions()->sync(Permission::whereIn('name', config('constants.default_routes'))->pluck('id')->toArray());
    }
    function checkBeforeDelete()
    {
        if ($this->id == 1)
            return false;
        else
            return true;
    }
}
