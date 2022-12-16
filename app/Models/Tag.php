<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Tags\Tag as SpatieTag;

class Tag extends SpatieTag{
    use LogsActivity, SoftDeletes;

    //mutator
    public function getNameTranslatablesAttribute(){
        return json_decode($this->attributes['name'], true);
    }
}
