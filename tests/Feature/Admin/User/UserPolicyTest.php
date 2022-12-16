<?php

namespace Tests\Feature\Admin\User;

use App\Models\User;
use Database\Seeders\RolesAndPermissionsTestingSeeder;
use Database\Seeders\StaticContentSeeder;
use Database\Seeders\SuperAdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\SystemRole as Role;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UserPolicyTest extends TestCase
{
    use RefreshDatabase;

    protected $superAdmin;
    protected $admin;

    public function setUp() : void
    {
        parent::setUp();
        $this->seed(SuperAdminSeeder::class);
        $this->seed(StaticContentSeeder::class);
        $this->superAdmin = User::whereEmail('super@admin.com')->first();
        $this->admin = User::factory()->create();

        Artisan::call('passport:install');
        Passport::actingAs($this->superAdmin);
        $this->seed(RolesAndPermissionsTestingSeeder::class);
    }

    protected function userData($passedData = []){
        $data = [
            "first_name" => "admin first name",
            "last_name" => "admin last name",
            "email" => "admin@email.com",
            "phone" => "0112332122",
            "type" => 2,
            "active" => 1,
            'password' => "#21Rasda"
        ];
        return array_merge($data, $passedData);
    }


    public function testUserIndexCode403WithFormat()
    {
        $response = $this->get('/api/admin/users');
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }

    public function testUserStoreCode403WithFormat()
    {
        $response = $this->post('/api/admin/users', $this->userData());
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }

    public function testUserUpdateCode403WithFormat()
    {
        $response = $this->put('/api/admin/users/'.$this->admin->id);
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }

    public function testUserShowCode403WithFormat()
    {
        $response = $this->get('/api/admin/users/'.$this->admin->id);
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }

    public function testUserDeleteCode403WithFormat()
    {
        $response = $this->delete('/api/admin/users/'.$this->admin->id);
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }

    //add roles through user store

    public function userStoreWithSuperAdminRole()
    {
        $role = Role::where('name', 'super-admin')->first();
        $this->superAdmin->assignRole($role);
        $this->post('/api/admin/users', $this->userData(['role_ids' => [$role->id]]));
        $lastUser = User::orderBy('id', 'desc')->first();
        Passport::actingAs($lastUser);
    }

    public function testIndexCode200AfterUserStoreWithSuperAdminRole()
    {
        $this->userStoreWithSuperAdminRole();
        $response = $this->get('/api/admin/users');
        $response->assertOk();
    }

    public function testStoreCode201AfterUserStoreWithSuperAdminRole()
    {
        $this->userStoreWithSuperAdminRole();
        $data = [
            "email" => "test2@test2.com",
            "phone" => "01233238782"
        ];
        $response = $this->post('/api/admin/users', $this->userData($data));
        $response->assertCreated();
    }

    public function testUpdateCode200AfterUserStoreWithSuperAdminRole()
    {
        $this->userStoreWithSuperAdminRole();
        $response = $this->put('/api/admin/users/'.$this->admin->id);
        $response->assertOk();
    }

    public function testUserShowCode200AfterUserStoreWithSuperAdminRole()
    {
        $this->userStoreWithSuperAdminRole();
        $response = $this->get('/api/admin/users/'.$this->admin->id);
        $response->assertOk();
    }

    public function testUserDeleteCode200AfterUserStoreWithSuperAdminRole()
    {
        $this->userStoreWithSuperAdminRole();
        $response = $this->delete('/api/admin/users/'.$this->admin->id);
        $response->assertOk();
    }


    //add roles through user update

    public function userUpdateWithSuperAdminRole()
    {
        $role = Role::where('name', 'super-admin')->first();
        $this->superAdmin->assignRole($role);
        $this->put('/api/admin/users/'.$this->admin->id, ['role_ids' => [$role->id]]);
        Passport::actingAs($this->admin);
    }

    public function testIndexCode200AfterUserUpdateWithSuperAdminRole()
    {
        $this->userUpdateWithSuperAdminRole();
        $response = $this->get('/api/admin/users');
        $response->assertOk();
    }

    public function testUpdateCode201AfterUserUpdateWithSuperAdminRole()
    {
        $this->userUpdateWithSuperAdminRole();
        $data = [
            "email" => "test2@test2.com"
        ];
        $response = $this->post('/api/admin/users', $this->userData($data));
        $response->assertCreated();
    }

    public function testPutCode200AfterUserUpdateWithSuperAdminRole()
    {
        $this->userUpdateWithSuperAdminRole();
        $response = $this->put('/api/admin/users/'.$this->admin->id);
        $response->assertOk();
    }

    public function testUserShowCode200AfterUserUpdateWithSuperAdminRole()
    {
        $this->userUpdateWithSuperAdminRole();
        $response = $this->get('/api/admin/users/'.$this->admin->id);
        $response->assertOk();
    }

    public function testUserDeleteCode200AfterUserUpdateWithSuperAdminRole()
    {
        $this->userUpdateWithSuperAdminRole();
        $response = $this->delete('/api/admin/users/'.$this->admin->id);
        $response->assertOk();
    }
}
