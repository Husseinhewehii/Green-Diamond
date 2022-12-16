<?php

namespace App\Http\Resources\Article;

use App\Constants\Media_Collections;
use App\Http\Resources\Tag\TagResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleWithTranslatablesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'article_category_id' => $this->article_category_id,
            'title' => $this->attributes('title')->data['title'],
            'description' => $this->attributes('description')->data['description'],
            'short_description' => $this->attributes('short_description')->data['short_description'],
            'photo' => $this->getFirstMediaUrl(Media_Collections::ARTICLE),
            'active' => $this->active,
            'tags' => TagResource::collection($this->tags),
            'media_gallery' => get_media_gallery_filtered($this, Media_Collections::ARTICLE_GALLERY),
        ];
    }
}
