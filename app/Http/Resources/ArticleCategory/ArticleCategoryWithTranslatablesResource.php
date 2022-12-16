<?php

namespace App\Http\Resources\ArticleCategory;

use App\Constants\Media_Collections;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleCategoryWithTranslatablesResource extends JsonResource
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
            'parent_id' => $this->parent_id,
            'type' => $this->type,
            'title' => $this->attributes('title')->data['title'],
            // 'photo' => $this->getFirstMediaUrl(Media_Collections::ARTICLE_CATEGORY),
            'active' => $this->active,
            'articleCategorychildren' => ArticleCategoryResource::collection($this->articleCategorychildren),
        ];
    }
}
