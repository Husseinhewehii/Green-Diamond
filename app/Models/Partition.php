<?php

namespace App\Models;

use App\Constants\Media_Collections;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Partition extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, LogsActivity, InteractsWithMedia, HasTranslations;

    protected $fillable = ['title', 'sub_title', 'description', 'short_description', 'active'];
    public $translatable = ['title', 'sub_title',  'description', 'short_description'];

    //mutator
    public function getTitleTranslatablesAttribute(){
        return json_decode($this->attributes['title'], true);
    }

    public function getSubTitleTranslatablesAttribute(){
        return json_decode($this->attributes['sub_title'], true);
    }

    public function getDescriptionTranslatablesAttribute(){
        return json_decode($this->attributes['description'], true);
    }

    public function getShortDescriptionTranslatablesAttribute(){
        return json_decode($this->attributes['short_description'], true);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(Media_Collections::PARTITION)->singleFile();
    }
}
