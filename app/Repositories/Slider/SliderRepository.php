<?php

namespace App\Repositories\Slider;

use App\Models\Slider;
use Spatie\QueryBuilder\QueryBuilder;

class SliderRepository
{
    public function getSliders()
    {
        return QueryBuilder::for(Slider::class)
        ->allowedFilters(['group'])
        ->paginate(10);
    }

    public function getSlidersWithoutPagination()
    {
        return QueryBuilder::for(Slider::class)
        ->allowedFilters(['group'])
        ->get();
    }
}
