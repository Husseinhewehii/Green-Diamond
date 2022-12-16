<?php

namespace Tests\Feature\Admin\Role;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\SystemRole as Role;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class RoleTest extends TestCase
{
    use RefreshDatabase, RoleTestingTrait;

    public function testRoleSoftDelete(){
        $this->delete('/api/admin/roles/'.$this->lastRole->id);
        $this->assertSoftDeleted($this->lastRole);
        $this->assertDatabaseCount("roles", count($this->allRoles));
    }

    public function testRoleStoreActivityLog()
    {
        $this->post('/api/admin/roles', $this->rolePayLoad());
        $lastUser = Role::orderBy('id', 'desc')->first();
        $data = [
            "causer_id" => $this->superAdmin->id,
            "subject_id" => $lastUser->id,
            "subject_type" => get_class($lastUser),
            "description" => "created",
        ];
        $this->assertDatabaseHas('activity_log', $data);
    }

    public function testRoleUpdateActivityLog()
    {
        $this->put('/api/admin/roles/'.$this->lastRole->id, $this->rolePayLoad());
        $data = [
            "causer_id" => $this->superAdmin->id,
            "subject_id" => $this->lastRole->id,
            "subject_type" => get_class($this->lastRole),
            "description" => "updated",
        ];
        $this->assertDatabaseHas('activity_log', $data);
    }

    public function testRoleDeleteActivityLog()
    {
        $this->delete('/api/admin/roles/'.$this->lastRole->id);
        $data = [
            "causer_id" => $this->superAdmin->id,
            "subject_id" => $this->lastRole->id,
            "subject_type" => get_class($this->lastRole),
            "description" => "deleted",
        ];
        $this->assertDatabaseHas('activity_log', $data);
    }

    public function testUserStoreCanPermission()
    {
        $permission = Permission::first();
        $data = [
            'permission_ids' => [$permission->id]
        ];

        $this->put('/api/admin/roles/'.$this->lastRole->id, $this->rolePayLoad($data));
        $lastUser = User::orderBy('id', 'desc')->first();
        $lastUser->syncRoles($this->lastRole);

        $this->assertTrue($lastUser->can($permission->name));
    }

    public function testUserUpdateCanPermission()
    {
        $permission = Permission::first();
        $data = [
            'permission_ids' => [$permission->id]
        ];

        $this->post('/api/admin/roles', $this->rolePayLoad($data));
        $lastUser = User::orderBy('id', 'desc')->first();
        $newRoleCreated = Role::orderBy('id', 'desc')->first();
        $lastUser->syncRoles($newRoleCreated);

        $this->assertTrue($lastUser->can($permission->name));
    }
}
