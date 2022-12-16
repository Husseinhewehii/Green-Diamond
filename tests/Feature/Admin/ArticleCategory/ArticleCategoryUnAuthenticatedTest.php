<?php

namespace Tests\Feature\Admin\ArticleCategory;

use App\Models\ArticleCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleCategoryUnAuthenticatedTest extends TestCase
{
    use RefreshDatabase;

    protected $firstArticleCategory;
    public function setUp() : void
    {
        parent::setUp();
        $this->firstArticleCategory = ArticleCategory::factory()->create();
    }

    public function testArticleCategoryIndexUnauthenticatedCode401WithFormat()
    {
        $response = $this->get('/api/admin/articleCategories');
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

    public function testArticleCategoryStoreUnauthenticatedCode401WithFormat()
    {
        $response = $this->post('/api/admin/articleCategories');
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

    public function testArticleCategoryUpdateUnauthenticatedCode401WithFormat()
    {
        $response = $this->put('api/admin/articleCategories/'.$this->firstArticleCategory->id);
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

    public function testArticleCategoryShowUnauthenticatedCode401WithFormat()
    {
        $response = $this->get('api/admin/articleCategories/'.$this->firstArticleCategory->id);
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

    public function testArticleCategoryDeleteUnauthenticatedCode401WithFormat()
    {
        $response = $this->delete('api/admin/articleCategories/'.$this->firstArticleCategory->id);
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }
}
