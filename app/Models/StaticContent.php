<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class StaticContent extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, HasTranslations;
    protected $fillable = ['text'];
    public $translatable = ['text'];
}
