<?php

namespace Tests\Feature\Admin\Article;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleSortTest extends TestCase
{
    use RefreshDatabase, ArticleTestingTrait;

    public function testArticleIndexSortTitle()
    {
        $response = $this->get("/api/admin/articles?sort=title");
        $response_articles = json_decode($response->content())->data->data;
        $first_articles_sorted_by_title = Article::orderBy('title')->first("title")->title;
        $this->assertEquals($response_articles[0]->title, $first_articles_sorted_by_title);
    }

    public function testArticleIndexSortDescription()
    {
        $response = $this->get("/api/admin/articles?sort=description");
        $response_articles = json_decode($response->content())->data->data;
        $first_articles_sorted_by_description = Article::orderBy('description')->first("description")->description;
        $this->assertEquals($response_articles[0]->description, $first_articles_sorted_by_description);
    }

    public function testArticleIndexSortShortDescription()
    {
        $response = $this->get("/api/admin/articles?sort=short_description");
        $response_articles = json_decode($response->content())->data->data;
        $first_articles_sorted_by_short_description = Article::orderBy('short_description')->first("short_description")->short_description;
        $this->assertEquals($response_articles[0]->short_description, $first_articles_sorted_by_short_description);
    }

    public function testArticleIndexSortActive()
    {
        $response = $this->get("/api/admin/articles?sort=active");
        $response_articles = json_decode($response->content())->data->data;
        $first_articles_sorted_by_active = Article::orderBy('active')->first("active")->active;
        $this->assertEquals($response_articles[0]->active, $first_articles_sorted_by_active);
    }
}
