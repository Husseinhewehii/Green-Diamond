<?php

namespace Tests\Feature\Admin\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, UserTestingTrait;

    public function testUserSoftDelete(){
        $this->delete('/api/admin/users/'.$this->admin->id);
        $this->assertSoftDeleted($this->admin);
        $this->assertDatabaseCount("users", count($this->allUsers));
    }

    public function testUserStoreActivityLog()
    {
        $this->post('/api/admin/users', $this->userPayload());
        $lastUser = User::orderBy('id', 'desc')->first();
        $data = [
            "causer_id" => $this->superAdmin->id,
            "subject_id" => $lastUser->id,
            "subject_type" => get_class($lastUser),
            "description" => "created",
        ];
        $this->assertDatabaseHas('activity_log', $data);
    }

    public function testUserUpdateActivityLog()
    {
        $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload());
        $data = [
            "causer_id" => $this->superAdmin->id,
            "subject_id" => $this->admin->id,
            "subject_type" => get_class($this->admin),
            "description" => "updated",
        ];
        $this->assertDatabaseHas('activity_log', $data);
    }

    public function testUserDeleteActivityLog()
    {
        $this->delete('/api/admin/users/'.$this->admin->id);
        $data = [
            "causer_id" => $this->superAdmin->id,
            "subject_id" => $this->admin->id,
            "subject_type" => get_class($this->admin),
            "description" => "deleted",
        ];
        $this->assertDatabaseHas('activity_log', $data);
    }
}
