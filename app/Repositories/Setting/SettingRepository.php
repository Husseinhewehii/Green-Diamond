<?php

namespace App\Repositories\Setting;

use App\Models\Setting;
use Spatie\QueryBuilder\QueryBuilder;

class SettingRepository
{
    public function getSettings()
    {
        return QueryBuilder::for(Setting::class)
        ->allowedFilters(["key", "group"])
        ->allowedSorts(["key", "group"])
        ->get();
    }

}
