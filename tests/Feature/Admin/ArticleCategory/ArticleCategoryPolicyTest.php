<?php

namespace Tests\Feature\Admin\ArticleCategory;

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

class ArticleCategoryPolicyTest extends TestCase
{
    use RefreshDatabase;

    protected $superAdmin;
    protected $firstArticleCategory;

    public function setUp() : void
    {
        parent::setUp();
        $this->seed(SuperAdminSeeder::class);
        $this->seed(StaticContentSeeder::class);
        $this->superAdmin = User::whereEmail('super@admin.com')->first();

        $this->firstArticleCategory = ArticleCategory::factory()->create();

        Artisan::call('passport:install');
        Passport::actingAs($this->superAdmin);
        $this->seed(RolesAndPermissionsTestingSeeder::class);
    }

    protected function articleCategoryPayload($passedData = []){
        $data = [
            'title' => [
                "en" => "english title",
                "ar" => "arabic title",
            ],
            'active' => 1
        ];
        return array_merge($data, $passedData);
    }

    public function testArticleCategoryIndexCode403WithFormat()
    {
        $response = $this->get('/api/admin/articleCategories');
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }

    public function testArticleCategoryStoreCode403WithFormat()
    {
        $response = $this->post('/api/admin/articleCategories', $this->articleCategoryPayload());
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }

    public function testArticleCategoryUpdateCode403WithFormat()
    {
        $response = $this->put('/api/admin/articleCategories/'.$this->firstArticleCategory->id, $this->articleCategoryPayload());
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }

    public function testArticleCategoryShowCode403WithFormat()
    {
        $response = $this->get('/api/admin/articleCategories/'.$this->firstArticleCategory->id);
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }

    public function testArticleCategoryDeleteCode403WithFormat()
    {
        $response = $this->delete('/api/admin/articleCategories/'.$this->firstArticleCategory->id);
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }
}
