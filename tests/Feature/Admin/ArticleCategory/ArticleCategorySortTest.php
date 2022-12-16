<?php

namespace Tests\Feature\Admin\ArticleCategory;

use App\Models\ArticleCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleCategorySortTest extends TestCase
{
    use RefreshDatabase, ArticleCategoryTestingTrait;

    public function testArticleCategoryIndexSortTitle()
    {
        $response = $this->get("/api/admin/articleCategories?sort=title");
        $response_article_categories = json_decode($response->content())->data->data;
        $first_article_category_sorted_by_title = ArticleCategory::orderBy('title')->first("title")->title;
        $this->assertEquals($response_article_categories[0]->title, $first_article_category_sorted_by_title);
    }

    public function testArticleCategoryIndexSortType()
    {
        $response = $this->get("/api/admin/articleCategories?sort=type");
        $response_article_categories = json_decode($response->content())->data->data;
        $first_article_category_sorted_by_type = ArticleCategory::orderBy('type')->first("type")->type;
        $this->assertEquals($response_article_categories[0]->type, $first_article_category_sorted_by_type);
    }

    public function testArticleCategoryIndexSortParentId()
    {
        $response = $this->get("/api/admin/articleCategories?sort=parent_id");
        $response_article_categories = json_decode($response->content())->data->data;
        $first_article_category_sorted_by_parent_id = ArticleCategory::orderBy('parent_id')->first("parent_id")->parent_id;
        $this->assertEquals($response_article_categories[0]->parent_id, $first_article_category_sorted_by_parent_id);
    }

    public function testArticleCategoryIndexSortActive()
    {
        $response = $this->get("/api/admin/articleCategories?sort=active");
        $response_article_categories = json_decode($response->content())->data->data;
        $first_article_category_sorted_by_active = ArticleCategory::orderBy('active')->first("active")->active;
        $this->assertEquals($response_article_categories[0]->active, $first_article_category_sorted_by_active);
    }
}
