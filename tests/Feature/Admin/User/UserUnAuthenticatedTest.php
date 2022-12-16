<?php

namespace Tests\Feature\Admin\User;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserUnAuthenticatedTest extends TestCase
{
    use RefreshDatabase;
    protected $updateUrl;
    protected $firstUser;

    public function setUp() : void
    {
        parent::setUp();
        $this->firstUser = User::factory()->create();
    }

    public function testUserIndexUnauthenticatedCode401WithFormat()
    {
        $response = $this->get('/api/admin/users');
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

    public function testUserStoreUnauthenticatedCode401WithFormat()
    {
        $response = $this->post('/api/admin/users');
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

    public function testUserUpdateUnauthenticatedCode401WithFormat()
    {
        $response = $this->put('api/admin/users/'.$this->firstUser->id);
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

    public function testUserShowUnauthenticatedCode401WithFormat()
    {
        $response = $this->get('api/admin/users/'.$this->firstUser->id);
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

    public function testUserDeleteUnauthenticatedCode401WithFormat()
    {
        $response = $this->delete('api/admin/users/'.$this->firstUser->id);
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }
}
