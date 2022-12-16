<?php

namespace App\Services\Article;

use App\Constants\Media_Collections;
use App\Models\Article;

class ArticleService
{
    public function createArticle($request)
    {
        $article = Article::create($request->validated());
        add_media_item($article, $request->photo, Media_Collections::ARTICLE);
        add_tags($article, $request->tag_ids);
        add_multi_media_item($article, $request->media_gallery, Media_Collections::ARTICLE_GALLERY);
    }

    public function updateArticle($request, $article)
    {
        $article->update($request->validated());
        add_media_item($article, $request->photo, Media_Collections::ARTICLE);
        add_tags($article, $request->tag_ids);
        add_multi_media_item($article, $request->media_gallery, Media_Collections::ARTICLE_GALLERY);
    }
}
