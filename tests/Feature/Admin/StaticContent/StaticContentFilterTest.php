<?php

namespace Tests\Feature\Admin\StaticContent;

use App\Models\StaticContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StaticContentFilterTest extends TestCase
{
    use RefreshDatabase, StaticContentTestingTrait;

    public function testStaticContentIndexFilterKey()
    {
        $staticContent = $this->staticContents[0];
        $response = $this->get("/api/admin/static-content?filter[key]=".$staticContent->key);
        $response_static_contents = json_decode($response->content())->data;

        $all_relevant_static_contents = StaticContent::where('key', $staticContent->key)->count();
        $this->assertEquals(count($response_static_contents), $all_relevant_static_contents);
    }

    public function testStaticContentIndexFilterGroup()
    {
        $staticContent = $this->staticContents[0];
        $response = $this->get("/api/admin/static-content?filter[group]=".$staticContent->group);
        $response_static_contents = json_decode($response->content())->data;
        $response_static_contents_filtered_by_group = array_filter($response_static_contents, function($item) use ($staticContent){
            return $item->group == $staticContent->group;
        });

        $all_relevant_static_contents = StaticContent::where('group', $staticContent->group)->count();
        $this->assertEquals(count($response_static_contents_filtered_by_group), $all_relevant_static_contents);
    }
}
