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

class Employee extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, LogsActivity, InteractsWithMedia, HasTranslations;
    // protected $fillable = ['name','position','description','email','social_media','phone','type','active'];
    protected $fillable = ['name', 'position', 'description', 'type', 'active'];
    public $translatable = ['position', 'description'];

    // protected $casts = [
    //     'social_media' => 'array'
    // ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(Media_Collections::EMPLOYEE)->singleFile();
    }
}
