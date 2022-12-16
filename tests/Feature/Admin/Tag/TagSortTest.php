<?php

namespace Tests\Feature\Admin\Tag;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagSortTest extends TestCase
{
    use RefreshDatabase, TagTestingTrait;

    public function testTagIndexSortTitle()
    {
        $response = $this->get("/api/admin/tags?sort=name");
        $response_tags = json_decode($response->content())->data->data;
        $first_tags_sorted_by_name = Tag::orderBy('name')->first("name")->name;
        $this->assertEquals($response_tags[0]->name, $first_tags_sorted_by_name);
    }

    public function testTagIndexSortActive()
    {
        $response = $this->get("/api/admin/tags?sort=active");
        $response_tags = json_decode($response->content())->data->data;
        $first_tags_sorted_by_active = Tag::orderBy('active')->first("active")->active;
        $this->assertEquals($response_tags[0]->active, $first_tags_sorted_by_active);
    }
}
