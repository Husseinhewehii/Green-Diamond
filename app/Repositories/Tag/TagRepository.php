<?php

namespace App\Repositories\Tag;

use App\Models\Tag;
use Spatie\QueryBuilder\QueryBuilder;

class TagRepository
{
    public function getTags()
    {
        return QueryBuilder::for(Tag::class)
        ->allowedFilters(["name", "type", "slug", 'active'])
        ->allowedSorts(["name", "type", "slug", 'active'])
        ->paginate(10);
    }

}
