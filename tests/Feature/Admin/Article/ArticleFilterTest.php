<?php

namespace Tests\Feature\Admin\Article;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleFilterTest extends TestCase
{
    use RefreshDatabase, ArticleTestingTrait;

    public function testArticleIndexFilterTitleTranslatables()
    {
        $response = $this->get("/api/admin/articles?filter[title]=".$this->firstArticle->title);
        $response_articles = json_decode($response->content(), true)['data']['data'];
        $this->assertTrue(check_item_in_array_collection_contain_string($response_articles, 'title', $this->firstArticle->title));
    }

    public function testArticleIndexFilterDescriptionTranslatables()
    {
        $response = $this->get("/api/admin/articles?filter[description]=".$this->firstArticle->description);
        $response_articles = json_decode($response->content(), true)['data']['data'];
        $this->assertTrue(check_item_in_array_collection_contain_string($response_articles, 'description', $this->firstArticle->description));
    }

    public function testArticleIndexFilterShortDescriptionTranslatables()
    {
        $response = $this->get("/api/admin/articles?filter[short_description]=".$this->firstArticle->short_description);
        $response_articles = json_decode($response->content(), true)['data']['data'];
        $this->assertTrue(check_item_in_array_collection_contain_string($response_articles, 'short_description', $this->firstArticle->short_description));
    }

    public function testArticleIndexFilterActive()
    {
        $response = $this->get("/api/admin/articles?filter[active]=".$this->firstArticle->active);
        $response_articles = json_decode($response->content())->data->data;

        $relevant_articles = Article::where('active', $this->firstArticle->active)->count();
        $this->assertEquals(count($response_articles), $relevant_articles);
    }
}
