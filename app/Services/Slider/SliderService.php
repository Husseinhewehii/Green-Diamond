<?php

namespace App\Services\Slider;

use App\Constants\Media_Collections;
use App\Models\Slider;

class SliderService
{
    public function createSlider($request)
    {
        $slider = Slider::create($request->validated());
        add_media_item($slider, $request->photo, "slider_".$slider->group);
    }
}
