<?php

namespace Tests\Feature\Admin\Article;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleUnAuthenticatedTest extends TestCase
{
    use RefreshDatabase;

    protected $firstArticleCategory;
    protected $firstArticle;

    public function setUp() : void
    {
        parent::setUp();
        $this->firstArticleCategory = ArticleCategory::factory()->create();
        $this->firstArticle = Article::factory()->create();
    }

    public function testArticleIndexUnauthenticatedCode401WithFormat()
    {
        $response = $this->get('/api/admin/articles');
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

    public function testArticleStoreUnauthenticatedCode401WithFormat()
    {
        $response = $this->post('/api/admin/articles');
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

    public function testArticleUpdateUnauthenticatedCode401WithFormat()
    {
        $response = $this->put('api/admin/articles/'.$this->firstArticle->id);
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

    public function testArticleShowUnauthenticatedCode401WithFormat()
    {
        $response = $this->get('api/admin/articles/'.$this->firstArticle->id);
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

    public function testArticleDeleteUnauthenticatedCode401WithFormat()
    {
        $response = $this->delete('api/admin/articles/'.$this->firstArticle->id);
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }
}
