<?php

namespace Tests\Feature\Admin\Partition;

use App\Models\Partition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PartitionResponseTest extends TestCase
{
    use RefreshDatabase, PartitionTestingTrait;

    public function testPartitionIndexCode200WithFormat()
    {
        $response = $this->get('/api/admin/partitions');
        $response->assertOk();
        $response->assertJson(assertPaginationFormat($this->allPartitionsInFormat->toArray()));
        $pats = Partition::paginate(10);
        $this->assertInstanceOf('Illuminate\Pagination\LengthAwarePaginator', $pats);
        $this->assertTrue(assertCheckPaginatedResponseHasPhotoLink($response, 0));
    }

    public function testPartitionUpdateCode200WithFormatEnglish()
    {
        $data['title'] = ["en" => "english title udpate"];
        $data['sub_title'] = ["en" => "english sub_title udpate"];
        $data['description'] = ["en" => "english description udpate"];
        $data['short_description'] = ["en" => "english short_description udpate"];

        $response = $this->put('/api/admin/partitions/'.$this->firstPartition->id, $this->partitionPayload($data));
        $response->assertOk();

        $data['title'] = $data['title']["en"];
        $data['sub_title'] = $data['sub_title']["en"];
        $data['description'] = $data['description']["en"];
        $data['short_description'] = $data['short_description']["en"];
        $response->assertJson(assertPaginationFormat([$this->partitionResponseData("en", $data)]));
        $this->assertTrue(assertCheckPaginatedResponseHasPhotoLink($response, 0));
    }

    // public function testPartitionUpdateCode200WithFormatArabic()
    // {
    //     $this->preCreateRecords("ar");
    //     $data['title'] = ["ar" => "arabic title udpate"];
    //     $data['sub_title'] = ["ar" => "arabic sub_title udpate"];
    //     $data['description'] = ["ar" => "arabic description udpate"];
    //     $data['short_description'] = ["ar" => "arabic short_description udpate"];
    //     dd($this->firstPartition, Partition::count());
    //     $response = $this->put('/api/admin/partitions/'.$this->firstPartition->id, $this->partitionPayload($data));
    //     $response->assertOk();

    //     $data['title'] = $data['title']["ar"];
    //     $data['sub_title'] = $data['sub_title']["ar"];
    //     $data['description'] = $data['description']["ar"];
    //     $data['short_description'] = $data['short_description']["ar"];
    //     $response->assertJson(assertPaginationFormat([$this->partitionResponseData("ar", $data)]));
    //     $this->assertTrue(assertCheckPaginatedResponseHasPhotoLink($response, 0));
    // }

    public function testPartitionShowCode200WithFormat()
    {
        $response = $this->get('/api/admin/partitions/'.$this->firstPartition->id);
        $response->assertOk();
        $response->assertJson(assertDataContent($this->partitionResponseDataFormat($this->firstPartition, true)));
        $this->assertTrue(assertCheckResponseHasPhotoLink($response));
    }

    public function testPartitionShowNotFoundCode404WithFormat()
    {
        $response = $this->get('/api/admin/partitions/'."123213213213");
        $response->assertNotFound();
        $response->assertJson(assertNotFoundFormat());
    }
}
