<?php

namespace App\Services\ArticleCategory;

use App\Constants\Media_Collections;
use App\Models\ArticleCategory;

class ArticleCategoryService
{
    public function createArticleCategory($request)
    {
        $articleCategory = ArticleCategory::create($request->validated());
        // add_media_item($articleCategory, $request->photo, Media_Collections::ARTICLE_CATEGORY);
    }

    public function updateArticleCategory($request, $articleCategory)
    {
        $articleCategory->update($request->validated());
        // add_media_item($articleCategory, $request->photo, Media_Collections::ARTICLE_CATEGORY);
    }
}
