<?php

namespace App\Repositories\Partition;

use App\Models\Partition;
use Spatie\QueryBuilder\QueryBuilder;

class PartitionRepository
{
    public function getPartitions()
    {
        return QueryBuilder::for(Partition::class)
        ->allowedFilters(['key', 'group', 'title', 'sub_title', 'description', 'short_description', 'active'])
        ->allowedSorts(['title', 'sub_title', 'description', 'short_description', 'active'])
        ->paginate(10);
    }

    public function getPartitionsWithoutPagination()
    {
        return QueryBuilder::for(Partition::class)
        ->allowedFilters(['key', 'group', 'title', 'sub_title', 'description', 'short_description', 'active'])
        ->allowedSorts(['title', 'sub_title', 'description', 'short_description', 'active'])
        ->get();
    }

}
