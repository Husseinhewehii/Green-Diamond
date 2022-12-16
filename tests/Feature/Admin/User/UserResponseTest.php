<?php

namespace Tests\Feature\Admin\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserResponseTest extends TestCase
{
    use RefreshDatabase, UserTestingTrait;

    public function testUserIndexCode200WithFormat()
    {
        $response = $this->get('/api/admin/users');
        $response->assertOk();
        $response->assertJson(assertPaginationFormat([$this->userFormat($this->superAdmin)]));
    }

    public function testUserShowCode200WithFormat()
    {
        $response = $this->get('/api/admin/users/'.$this->admin->id);
        $response->assertOk();
        $response->assertJson(assertDataContent($this->userFormat($this->admin)));
    }

    public function testUserStoreCode201WithFormat()
    {
        $response = $this->post('/api/admin/users', $this->userPayload());
        $response->assertCreated();
        $usersResponse = [...$this->allUsersInFormat, $this->userData()];
        $response->assertJson(assertCreatedPaginationFormat($usersResponse));
    }

    public function testUserDeleteCode200WithFormat()
    {
        $response = $this->delete('/api/admin/users/'.$this->admin->id);
        $response->assertOk();
        $response->assertJson(assertPaginationFormat([$this->userFormat($this->superAdmin)]));
    }

    public function testUserUpdateCode200WithFormat()
    {
        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload());
        $response->assertOk();
        $usersResponse = [$this->userFormat($this->superAdmin), $this->userData()];
        $response->assertJson(assertPaginationFormat($usersResponse));
    }

    public function testUserShowNotFoundCode404WithFormat()
    {
        $response = $this->get('/api/admin/users/'."123213213213");
        $response->assertNotFound();
        $response->assertJson(assertNotFoundFormat());
    }

    public function testUserUpdateSameEmailAndSamePhone()
    {
        $data = ['email' => $this->admin->email, 'phone' => $this->admin->phone];
        $response = $this->put('/api/admin/users/'.$this->admin->id, $this->userPayload($data));
        $response->assertOk();
    }
}
