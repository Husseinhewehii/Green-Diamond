<?php

namespace Tests\Feature\Admin\ArticleCategory;

use App\Models\ArticleCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleCategoryFilterTest extends TestCase
{
    use RefreshDatabase, ArticleCategoryTestingTrait;

    public function testArticleCategoryIndexFilterTitleTranslatables()
    {
        $response = $this->get("/api/admin/articleCategories?filter[title]=".$this->firstArticleCategory->title);
        $response_article_categories = json_decode($response->content(), true)['data']['data'];
        $this->assertTrue(check_item_in_array_collection_contain_string($response_article_categories, 'title', $this->firstArticleCategory->title));
    }

    public function testArticleCategoryIndexFilterParentId()
    {
        $response = $this->get("/api/admin/articleCategories?filter[parent_id]=".$this->firstArticleCategory->parent_id);
        $response_article_categories = json_decode($response->content())->data->data;

        $relevant_article_categories = ArticleCategory::where('parent_id', $this->firstArticleCategory->parent_id)->count();
        $this->assertEquals(count($response_article_categories), $relevant_article_categories);
    }

    public function testArticleCategoryIndexFilterType()
    {
        $response = $this->get("/api/admin/articleCategories?filter[type]=".$this->firstArticleCategory->type);
        $response_article_categories = json_decode($response->content())->data->data;

        $relevant_article_categories = ArticleCategory::where('type', $this->firstArticleCategory->type)->count();
        $this->assertEquals(count($response_article_categories), $relevant_article_categories);
    }

    public function testArticleCategoryIndexFilterActive()
    {
        $response = $this->get("/api/admin/articleCategories?filter[active]=".$this->firstArticleCategory->active);
        $response_article_categories = json_decode($response->content())->data->data;

        $relevant_article_categories = ArticleCategory::where('active', $this->firstArticleCategory->active)->count();
        $this->assertEquals(count($response_article_categories), $relevant_article_categories);
    }
}
