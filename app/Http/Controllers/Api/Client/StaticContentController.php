<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\StaticContent;
use Illuminate\Http\Request;

/**
 * @group Static Content Module
 */
class StaticContentController extends Controller
{
    /**
     * Get Static Content
     *
     * @queryParam group string Filter by group. Example: validation
     *
     */
    public function index(Request $request)
    {
        if($request->group){
            return ok_response($this->getStaticContentByGroup($request->group));
        }
        return ok_response($this->getALLStaticContent());
    }

    private function getStaticContentByGroup($item_group){
        $items = cachedLocalizedArray("all_static_content_".$item_group);
        if(!$items){
            $items = StaticContent::where('group', $item_group)->pluck('text', 'key')->toArray();
            cacheAndLocalizeArray($items, "all_static_content_".$item_group, current_locale());
        }
        return $items;
    }

    private function getALLStaticContent(){
        $items = cachedLocalizedArray("all_static_content");
        if(!$items){
            $items = StaticContent::pluck('text', 'key')->toArray();
            cacheAndLocalizeArray($items, "all_static_content", current_locale());
        }
        return $items;
    }
}
