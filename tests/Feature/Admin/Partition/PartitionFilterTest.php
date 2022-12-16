<?php

namespace Tests\Feature\Admin\Partition;

use App\Models\Partition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PartitionFilterTest extends TestCase
{
    use RefreshDatabase, PartitionTestingTrait;

    public function testPartitionIndexFilterTitleTranslatables()
    {
        $response = $this->get("/api/admin/partitions?filter[title]=".$this->firstPartition->title);
        $response_partitions = json_decode($response->content(), true)['data']['data'];
        $this->assertTrue(check_item_in_array_collection_contain_string($response_partitions, 'title', $this->firstPartition->title));
    }

    public function testPartitionIndexFilterSubTitleTranslatables()
    {
        $response = $this->get("/api/admin/partitions?filter[sub_title]=".$this->firstPartition->sub_title);
        $response_partitions = json_decode($response->content(), true)['data']['data'];
        $this->assertTrue(check_item_in_array_collection_contain_string($response_partitions, 'sub_title', $this->firstPartition->sub_title));
    }

    public function testPartitionIndexFilterDecriptionTranslatables()
    {
        $response = $this->get("/api/admin/partitions?filter[description]=".$this->firstPartition->description);
        $response_partitions = json_decode($response->content(), true)['data']['data'];
        $this->assertTrue(check_item_in_array_collection_contain_string($response_partitions, 'description', $this->firstPartition->description));
    }

    public function testPartitionIndexFilterShortDescriptionranslatables()
    {
        $response = $this->get("/api/admin/partitions?filter[short_description]=".$this->firstPartition->short_description);
        $response_partitions = json_decode($response->content(), true)['data']['data'];
        $this->assertTrue(check_item_in_array_collection_contain_string($response_partitions, 'short_description', $this->firstPartition->short_description));
    }

    public function testPartitionIndexFilterActive()
    {
        $response = $this->get("/api/admin/partitions?filter[active]=".$this->firstPartition->active);
        $response_partitions = json_decode($response->content())->data->data;

        $relevant_partitions = Partition::where('active', $this->firstPartition->active)->count();
        $this->assertEquals(count($response_partitions), $relevant_partitions);
    }
}
