<?php

namespace Tests\Feature\Admin\Tag;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagFilterTest extends TestCase
{
    use RefreshDatabase, TagTestingTrait;

    public function testTagIndexFilterNameTranslatables()
    {
        $response = $this->get("/api/admin/tags?filter[name]=".$this->firstTag->name);
        $response_tags = json_decode($response->content(), true)['data']['data'];
        $this->assertTrue(check_item_in_array_collection_contain_string($response_tags, 'name', $this->firstTag->name));
    }

    public function testTagIndexFilterActive()
    {
        $response = $this->get("/api/admin/tags?filter[active]=".$this->firstTag->active);
        $response_tags = json_decode($response->content())->data->data;

        $relevant_tags = Tag::where('active', $this->firstTag->active)->count();
        $this->assertEquals(count($response_tags), $relevant_tags);
    }
}
