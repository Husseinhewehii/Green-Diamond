<?php

namespace Tests\Feature\Admin\Tag;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagUnAuthenticatedTest extends TestCase
{
    use RefreshDatabase;

    protected $firstTag;

    public function setUp() : void
    {
        parent::setUp();
        $this->firstTag = Tag::factory()->create();
    }

    public function testTagIndexUnauthenticatedCode401WithFormat()
    {
        $response = $this->get('/api/admin/tags');
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

    public function testTagStoreUnauthenticatedCode401WithFormat()
    {
        $response = $this->post('/api/admin/tags');
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

    public function testTagUpdateUnauthenticatedCode401WithFormat()
    {
        $response = $this->put('api/admin/tags/'.$this->firstTag->id);
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

    public function testTagShowUnauthenticatedCode401WithFormat()
    {
        $response = $this->get('api/admin/tags/'.$this->firstTag->id);
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

    public function testTagDeleteUnauthenticatedCode401WithFormat()
    {
        $response = $this->delete('api/admin/tags/'.$this->firstTag->id);
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }
}
