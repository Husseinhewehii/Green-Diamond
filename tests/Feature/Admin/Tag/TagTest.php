<?php

namespace Tests\Feature\Admin\Tag;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase, TagTestingTrait;

    public function testTagSoftDelete(){
        $this->delete('/api/admin/tags/'.$this->firstTag->id);
        $this->assertSoftDeleted($this->firstTag);
        $this->assertDatabaseCount("tags", count($this->allTags));
    }

    public function testTagStoreActivityLog()
    {
        $this->post('/api/admin/tags', $this->tagPayLoad());
        $lastUser = Tag::orderBy('id', 'desc')->first();
        $data = [
            "causer_id" => $this->superAdmin->id,
            "subject_id" => $lastUser->id,
            "subject_type" => get_class($lastUser),
            "description" => "created",
        ];
        $this->assertDatabaseHas('activity_log', $data);
    }

    public function testTagUpdateActivityLog()
    {
        $this->put('/api/admin/tags/'.$this->firstTag->id, $this->tagPayLoad());
        $data = [
            "causer_id" => $this->superAdmin->id,
            "subject_id" => $this->firstTag->id,
            "subject_type" => get_class($this->firstTag),
            "description" => "updated",
        ];
        $this->assertDatabaseHas('activity_log', $data);
    }

    public function testTagDeleteActivityLog()
    {
        $this->delete('/api/admin/tags/'.$this->firstTag->id);
        $data = [
            "causer_id" => $this->superAdmin->id,
            "subject_id" => $this->firstTag->id,
            "subject_type" => get_class($this->firstTag),
            "description" => "deleted",
        ];
        $this->assertDatabaseHas('activity_log', $data);
    }
}
