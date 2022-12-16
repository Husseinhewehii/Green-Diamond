<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RouteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRouteApplicationJson()
    {
        $response = $this->get('/api/admin/test');
        $response->assertHeader('Accept', 'application/json');
        $response->assertHeader('Content-Type', 'application/json');
    }

    public function testRouteAcceptLanguageArabic()
    {
        $response = $this->get('/api/admin/test');
        $response->withHeaders(['Accept-Language' => 'ar']);
        $response->assertHeader('Accept-Language', 'ar');
    }

    public function testApiRouteUnauthenticatedResponseFormat()
    {
        $response = $this->get('/api/admin/auth/test');
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }
}
