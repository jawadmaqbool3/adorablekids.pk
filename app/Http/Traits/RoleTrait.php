<?php

namespace App\Http\Traits;

use App\Models\Role;
use App\Models\UserRole;

/**
 * 
 */
trait RoleTrait
{
    public function hasPermission($permission)
    {
        return Role::where('id', $this->role->id)
            ->whereHas('permissions', function ($query) use ($permission) {
                $query->where('name', $permission);
            })->exists();
    }
    public function hasRole($role)
    {
        return $this->role->name == $role;
    }

    public function role()
    {
        return $this->hasOneThrough(
            Role::class,
            UserRole::class,
            'user_id',
            'id',
            'id',
            'role_id',
        );
    }
}
