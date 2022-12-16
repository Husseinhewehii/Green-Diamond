<?php

namespace App\Models;

use App\Constants\Media_Collections;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Slider extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, LogsActivity, InteractsWithMedia;

    protected $fillable = ['group'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(Media_Collections::SLIDER_HOME_HEADER)->singleFile();
        $this->addMediaCollection(Media_Collections::SLIDER_PARTNER)->singleFile();
    }
}
