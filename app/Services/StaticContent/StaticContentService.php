<?php

namespace App\Services\StaticContent;

use App\Models\StaticContent;

class StaticContentService
{
    public function updateStaticContent($request, $staticContent)
    {
        $staticContent->update($request->validated());
        localizedFunction([$this, 'cacheAllStaticContent'], []);
        localizedFunction([$this, 'cacheGroupStaticContent'], [$staticContent]);
    }

    public function cacheAllStaticContent($locale){
        $allStaticContent = StaticContent::pluck('text', 'key')->toArray();
        cacheAndLocalizeArray($allStaticContent, "all_static_content", $locale);
    }

    public function cacheGroupStaticContent($staticContent, $locale){
        $groupedStaticContents = StaticContent::where('group', $staticContent->group)->pluck('text', 'key')->toArray();
        cacheAndLocalizeArray($groupedStaticContents, "all_static_content_".$staticContent->group, $locale);
    }
}
