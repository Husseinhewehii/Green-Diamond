<?php

namespace Tests\Feature\Admin\StaticContent;

use App\Models\StaticContent;
use Database\Seeders\StaticContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StaticContentUnAuthenticatedTest extends TestCase
{
    use RefreshDatabase;
    protected $updateUrl;
    protected $firstStaticContent;

    public function setUp() : void
    {
        parent::setUp();
        $this->seed(StaticContentSeeder::class);
        $this->firstStaticContent = StaticContent::first();
        $this->updateUrl = 'api/admin/static-content/'.$this->firstStaticContent->id;
    }

    public function testStaticContentIndexUnauthenticatedCode401WithFormat()
    {
        $response = $this->get('/api/admin/static-content');
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

    public function testStaticContentPutUnauthenticatedCode401WithFormat()
    {
        $response = $this->put($this->updateUrl);
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }
}
