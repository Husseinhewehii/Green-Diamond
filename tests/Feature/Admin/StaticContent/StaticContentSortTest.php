<?php

namespace Tests\Feature\Admin\StaticContent;

use App\Models\StaticContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StaticContentSortTest extends TestCase
{
    use RefreshDatabase, StaticContentTestingTrait;

    public function testStaticContentIndexSortKey()
    {
        $response = $this->get("/api/admin/static-content?sort=key");
        $response_static_contents = json_decode($response->content())->data;
        $first_static_content_sorted_by_key = StaticContent::orderBy('key')->first("key")->key;
        $this->assertEquals($response_static_contents[0]->key, $first_static_content_sorted_by_key);
    }

    public function testStaticContentIndexSortGroup()
    {
        $response = $this->get("/api/admin/static-content?sort=group");
        $response_static_contents = json_decode($response->content())->data;
        $first_static_content_sorted_by_group = StaticContent::orderBy('group')->first("group")->group;
        $this->assertEquals($response_static_contents[0]->group, $first_static_content_sorted_by_group);
    }
}
