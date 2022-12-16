<?php

namespace App\Http\Resources\Partition;

use App\Constants\Media_Collections;
use Illuminate\Http\Resources\Json\JsonResource;

class PartitionWithTranslatablesResource extends JsonResource
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
            'key' => $this->key,
            'group' => $this->group,
            'title' => $this->attributes('title')->data['title'],
            'sub_title' => $this->attributes('sub_title')->data['sub_title'],
            'description' => $this->attributes('description')->data['description'],
            'short_description' => $this->attributes('short_description')->data['short_description'],
            'photo' => $this->getFirstMediaUrl(Media_Collections::PARTITION) ?? "https://shahpourpouyan.com/wp-content/uploads/2018/10/orionthemes-placeholder-image-1.png",
            'active' => $this->active,
        ];
    }
}
