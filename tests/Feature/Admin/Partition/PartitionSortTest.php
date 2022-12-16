<?php

namespace Tests\Feature\Admin\Partition;

use App\Models\Partition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PartitionSortTest extends TestCase
{
    use RefreshDatabase, PartitionTestingTrait;

    public function testPartitionIndexSortTitle()
    {
        $response = $this->get("/api/admin/partitions?sort=sub_title");
        $response_partitions = json_decode($response->content())->data->data;
        $first_partitions_sorted_by_title = Partition::orderBy('title')->first("title")->title;
        $this->assertEquals($response_partitions[0]->title, $first_partitions_sorted_by_title);
    }

    public function testPartitionIndexSortSubTitle()
    {
        $response = $this->get("/api/admin/partitions?sort=sub_title");
        $response_partitions = json_decode($response->content())->data->data;
        $first_partitions_sorted_by_sub_title = Partition::orderBy('sub_title')->first("sub_title")->sub_title;
        $this->assertEquals($response_partitions[0]->sub_title, $first_partitions_sorted_by_sub_title);
    }

    public function testPartitionIndexSortDescription()
    {
        $response = $this->get("/api/admin/partitions?sort=description");
        $response_partitions = json_decode($response->content())->data->data;
        $first_partitions_sorted_by_description = Partition::orderBy('description')->first("description")->description;
        $this->assertEquals($response_partitions[0]->description, $first_partitions_sorted_by_description);
    }

    public function testPartitionIndexSortShortDescription()
    {
        $response = $this->get("/api/admin/partitions?sort=short_description");
        $response_partitions = json_decode($response->content())->data->data;
        $first_partitions_sorted_by_short_description = Partition::orderBy('short_description')->first("short_description")->short_description;
        $this->assertEquals($response_partitions[0]->short_description, $first_partitions_sorted_by_short_description);
    }

    public function testPartitionIndexSortActive()
    {
        $response = $this->get("/api/admin/partitions?sort=active");
        $response_partitions = json_decode($response->content())->data->data;
        $first_partitions_sorted_by_active = Partition::orderBy('active')->first("active")->active;
        $this->assertEquals($response_partitions[0]->active, $first_partitions_sorted_by_active);
    }
}
