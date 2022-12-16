<?php

namespace App\Repositories\StaticContent;

use App\Models\StaticContent;
use Spatie\QueryBuilder\QueryBuilder;

class StaticContentRepository
{
    public function getStaticContent()
    {
        return QueryBuilder::for(StaticContent::class)
        ->allowedFilters(["key", "group"])
        ->allowedSorts(["key", "group"])
        ->get();
    }

}
