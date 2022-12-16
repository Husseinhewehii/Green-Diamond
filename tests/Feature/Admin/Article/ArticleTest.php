<?php

namespace Tests\Feature\Admin\Article;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase, ArticleTestingTrait;

    public function testArticleSoftDelete(){
        $this->delete('/api/admin/articles/'.$this->firstArticle->id);
        $this->assertSoftDeleted($this->firstArticle);
        $this->assertDatabaseCount("articles", count($this->allArticles));
    }

    public function testArticleStoreActivityLog()
    {
        $this->post('/api/admin/articles', $this->articlePayLoad());
        $lastUser = Article::orderBy('id', 'desc')->first();
        $data = [
            "causer_id" => $this->superAdmin->id,
            "subject_id" => $lastUser->id,
            "subject_type" => get_class($lastUser),
            "description" => "created",
        ];
        $this->assertDatabaseHas('activity_log', $data);
    }

    public function testArticleUpdateActivityLog()
    {
        $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayLoad());
        $data = [
            "causer_id" => $this->superAdmin->id,
            "subject_id" => $this->firstArticle->id,
            "subject_type" => get_class($this->firstArticle),
            "description" => "updated",
        ];
        $this->assertDatabaseHas('activity_log', $data);
    }

    public function testArticleDeleteActivityLog()
    {
        $this->delete('/api/admin/articles/'.$this->firstArticle->id);
        $data = [
            "causer_id" => $this->superAdmin->id,
            "subject_id" => $this->firstArticle->id,
            "subject_type" => get_class($this->firstArticle),
            "description" => "deleted",
        ];
        $this->assertDatabaseHas('activity_log', $data);
    }
}
