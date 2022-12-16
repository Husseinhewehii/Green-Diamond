<?php

namespace Tests\Feature\Admin\Article;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsTestingSeeder;
use Database\Seeders\StaticContentSeeder;
use Database\Seeders\SuperAdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ArticlePolicyTest extends TestCase
{
    use RefreshDatabase;

    protected $superAdmin;
    protected $firstArticle;
    protected $firstArticleCategory;

    public function setUp() : void
    {
        parent::setUp();
        $this->seed(SuperAdminSeeder::class);
        $this->seed(StaticContentSeeder::class);
        $this->superAdmin = User::whereEmail('super@admin.com')->first();

        $this->firstArticleCategory = ArticleCategory::factory()->create();
        $this->firstArticle = Article::factory()->create();

        Artisan::call('passport:install');
        Passport::actingAs($this->superAdmin);
        $this->seed(RolesAndPermissionsTestingSeeder::class);
    }

    protected function articlePayload($passedData = []){
        $data = [
            'title' => [
                "en" => "english title",
                "ar" => "arabic title",
            ],
            'active' => 1
        ];
        return array_merge($data, $passedData);
    }

    public function testArticleIndexCode403WithFormat()
    {
        $response = $this->get('/api/admin/articles');
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }

    public function testArticleStoreCode403WithFormat()
    {
        $response = $this->post('/api/admin/articles', $this->articlePayload());
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }

    public function testArticleUpdateCode403WithFormat()
    {
        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload());
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }

    public function testArticleShowCode403WithFormat()
    {
        $response = $this->get('/api/admin/articles/'.$this->firstArticle->id);
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }

    public function testArticleDeleteCode403WithFormat()
    {
        $response = $this->delete('/api/admin/articles/'.$this->firstArticle->id);
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }
}
