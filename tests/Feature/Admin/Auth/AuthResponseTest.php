<?php

namespace Tests\Feature\Admin\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class AuthResponseTest extends TestCase
{
    use RefreshDatabase, AuthTestingTrait;

    public function testAdminLoginCode200()
    {
        $response = $this->post($this->loginUrl, $this->loginPayload());
        $response->assertOk();
    }

    public function testAdminLoginHasToken()
    {
        $response = $this->post($this->loginUrl, $this->loginPayload());
        $this->assertNotEmpty(json_decode($response->content())->data->token);
        $this->assertNotEquals(json_decode($response->content())->data->token, "");
    }

    public function testAdminLoginPayload()
    {
        $response = $this->post($this->loginUrl, $this->loginPayload());
        $response->assertJson(assertDataContent($this->loginResponseData()));
    }

    public function testAdminLogout()
    {
        Passport::actingAs($this->user);
        $response = $this->post('/api/admin/logout');
        $response->assertOk();
    }
}
