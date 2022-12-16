<?php

namespace App\Repositories\ArticleCategory;

use App\Models\ArticleCategory;
use Spatie\QueryBuilder\QueryBuilder;

class ArticleCategoryRepository
{
    private function ArticleCategoriesFiltersAndSorts()
    {
        return ['title', 'active', 'type', 'parent_id'];
    }

    public function getArticleCategories()
    {
        return QueryBuilder::for(ArticleCategory::class)
        ->allowedFilters($this->ArticleCategoriesFiltersAndSorts())
        ->allowedSorts($this->ArticleCategoriesFiltersAndSorts())
        ->paginate(10);
    }


    public function getArticleCategoriesLimited($request)
    {
        return QueryBuilder::for(ArticleCategory::class)
        ->allowedFilters("type")
        ->with('articles')
        ->limit($request->limit)
        ->get();
    }
}
