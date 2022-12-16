<?php

namespace App\Models;

use App\Constants\Media_Collections;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;
use Spatie\Translatable\HasTranslations;

class Article extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, LogsActivity, HasTranslations, HasTags, InteractsWithMedia;
    protected $fillable = ['article_category_id', 'title','description', 'short_description', 'active'];
    public $translatable = ['title', 'description', 'short_description'];

    //mutator
    public function getTitleTranslatablesAttribute(){
        return json_decode($this->attributes['title'], true);
    }

    public function getDescriptionTranslatablesAttribute(){
        return json_decode($this->attributes['description'], true);
    }

    public function getShortDescriptionTranslatablesAttribute(){
        return json_decode($this->attributes['short_description'], true);
    }

    //reltaions
    public function articleCategory()
    {
        return $this->belongsTo(ArticleCategory::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(Media_Collections::ARTICLE)->singleFile();
    }


}
