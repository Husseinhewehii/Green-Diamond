<?php

namespace Tests\Feature\Admin\Role;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\SystemRole as Role;

class RoleUnAuthenticatedTest extends TestCase
{
    use RefreshDatabase;

    protected $lastRole;
    public function setUp() : void
    {
        parent::setUp();
        $this->lastRole = Role::factory()->create();
    }

    public function testRoleIndexUnauthenticatedCode401WithFormat()
    {
        $response = $this->get('/api/admin/roles');
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

    public function testRoleStoreUnauthenticatedCode401WithFormat()
    {
        $response = $this->post('/api/admin/roles');
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

    public function testRoleUpdateUnauthenticatedCode401WithFormat()
    {
        $response = $this->put('api/admin/roles/'.$this->lastRole->id);
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

    public function testRoleShowUnauthenticatedCode401WithFormat()
    {
        $response = $this->get('api/admin/roles/'.$this->lastRole->id);
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

    public function testRoleDeleteUnauthenticatedCode401WithFormat()
    {
        $response = $this->delete('api/admin/roles/'.$this->lastRole->id);
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }
}
