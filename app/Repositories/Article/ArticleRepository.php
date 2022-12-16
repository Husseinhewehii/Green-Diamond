<?php

namespace App\Repositories\Article;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ArticleRepository
{
    private function ArticlesFiltersAndSorts()
    {
        return ['title', 'active', 'article_category_id', 'short_description', 'description'];
    }

    public function getArticles()
    {
        return QueryBuilder::for(Article::class)
        ->allowedFilters($this->ArticlesFiltersAndSorts())
        ->allowedSorts($this->ArticlesFiltersAndSorts())
        ->paginate(10);
    }

    public function getArticlesLimited($request)
    {
        return QueryBuilder::for(Article::class)
        ->allowedFilters(
            AllowedFilter::callback('article_category_type', function (Builder $query, $value){
                $query->whereHas('articleCategory', function($q) use ($value){
                    $q->where('type', $value);
                });
            })
        )
        ->limit($request->limit)
        ->get();
    }

}
