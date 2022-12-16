<?php

namespace Tests\Feature\Admin\ArticleCategory;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleCategoryTest extends TestCase
{
    use RefreshDatabase, ArticleCategoryTestingTrait;

    public function testArticleCategorySoftDelete(){
        $this->delete('/api/admin/articleCategories/'.$this->firstArticleCategory->id);
        $this->assertSoftDeleted($this->firstArticleCategory);
        $this->assertDatabaseCount("article_categories", count($this->allArticleCategories));
    }

    public function testArticleCategoryStoreActivityLog()
    {
        $this->post('/api/admin/articleCategories', $this->articleCategoryPayLoad());
        $lastUser = ArticleCategory::orderBy('id', 'desc')->first();
        $data = [
            "causer_id" => $this->superAdmin->id,
            "subject_id" => $lastUser->id,
            "subject_type" => get_class($lastUser),
            "description" => "created",
        ];
        $this->assertDatabaseHas('activity_log', $data);
    }

    public function testArticleCategoryUpdateActivityLog()
    {
        $this->put('/api/admin/articleCategories/'.$this->firstArticleCategory->id, $this->articleCategoryPayLoad());
        $data = [
            "causer_id" => $this->superAdmin->id,
            "subject_id" => $this->firstArticleCategory->id,
            "subject_type" => get_class($this->firstArticleCategory),
            "description" => "updated",
        ];
        $this->assertDatabaseHas('activity_log', $data);
    }

    public function testArticleCategoryDeleteActivityLog()
    {
        $this->delete('/api/admin/articleCategories/'.$this->firstArticleCategory->id);
        $data = [
            "causer_id" => $this->superAdmin->id,
            "subject_id" => $this->firstArticleCategory->id,
            "subject_type" => get_class($this->firstArticleCategory),
            "description" => "deleted",
        ];
        $this->assertDatabaseHas('activity_log', $data);
    }

    public function testArticleCategoryDeleteCascadeArticle(){
        $firstArticle = Article::factory()->create();
        $this->delete('/api/admin/articleCategories/'.$this->firstArticleCategory->id);
        $this->assertSoftDeleted($firstArticle);
    }
}
