<?php

namespace App\Models;

use App\Constants\Media_Collections;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class ArticleCategory extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, LogsActivity, HasTranslations, InteractsWithMedia, CascadeSoftDeletes;
    protected $fillable = ['parent_id', 'title', 'active', 'type'];
    public $translatable = ['title'];
    protected $cascadeDeletes = ['articles'];

    //reltaions
    public function articleCategorychildren()
    {
        return $this->hasMany(ArticleCategory::class, "parent_id", "id");
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    //mutator
    public function getTitleTranslatablesAttribute(){
        return json_decode($this->attributes['title'], true);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(Media_Collections::ARTICLE_CATEGORY)->singleFile();
    }
}
