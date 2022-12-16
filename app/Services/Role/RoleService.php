<?php

namespace App\Services\Role;

use App\Models\SystemRole as Role;
use App\Models\SystemPermission as Permission;

class RoleService
{
    public function createRole($request)
    {
        $role = Role::create($request->validated());
        $this->syncPermissions($role, $request->permission_ids);
    }

    public function updateRole($request, $role)
    {
        $role->update($request->validated());
        $role->syncPermissions($request->permission_ids);
    }

    public function syncPermissions($role, $permission_ids)
    {
        if(is_array($permission_ids)){
            $permissions = Permission::whereIn('id', $permission_ids)->get();
            $role->syncPermissions($permissions);
        }
    }
}
