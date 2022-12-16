<?php

namespace Tests\Feature\Admin\Role;

use App\Models\User;
use Database\Seeders\RolesAndPermissionsTestingSeeder;
use Database\Seeders\StaticContentSeeder;
use Database\Seeders\SuperAdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\TestCase;
use App\Models\SystemRole as Role;

class RolePolicyTest extends TestCase
{
    use RefreshDatabase;

    protected $superAdmin;
    protected $lastRole;

    public function setUp() : void
    {
        parent::setUp();
        $this->seed(SuperAdminSeeder::class);
        $this->seed(StaticContentSeeder::class);
        $this->superAdmin = User::whereEmail('super@admin.com')->first();
        $this->lastRole = Role::factory()->create();

        Artisan::call('passport:install');
        Passport::actingAs($this->superAdmin);
        $this->seed(RolesAndPermissionsTestingSeeder::class);
    }

    protected function rolePayLoad($passedData = []){
        $data = [
            'name' => "role name",
            'active' => 1,
        ];
        return array_merge($data, $passedData);
    }

    public function testRoleIndexCode403WithFormat()
    {
        $response = $this->get('/api/admin/roles');
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }

    public function testRoleStoreCode403WithFormat()
    {
        $response = $this->post('/api/admin/roles', $this->rolePayLoad());
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }

    public function testRoleUpdateCode403WithFormat()
    {
        $response = $this->put('/api/admin/roles/'.$this->lastRole->id, $this->rolePayLoad());
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }

    public function testRoleShowCode403WithFormat()
    {
        $response = $this->get('/api/admin/roles/'.$this->lastRole->id);
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }

    public function testRoleDeleteCode403WithFormat()
    {
        $response = $this->delete('/api/admin/roles/'.$this->lastRole->id);
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }
}
