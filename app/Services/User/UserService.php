<?php

namespace App\Services\User;

use App\Models\User;
use App\Models\SystemRole as Role;

class UserService
{
    public function createUser($request)
    {
        $user = User::create($request->validated());
        $this->syncRoles($user, $request->role_ids);
    }

    public function updateUser($request, $user)
    {
        $user->update($request->validated());
        $this->syncRoles($user, $request->role_ids);
    }

    public function syncRoles($user, $role_ids)
    {
        if(is_array($role_ids)){
            $roles = Role::whereIn('id', $role_ids)->get();
            $user->syncRoles($roles);
        }
    }
}
