<?php

namespace Tests\Feature\Admin\Tag;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagResponseTest extends TestCase
{
    use RefreshDatabase, TagTestingTrait;

    public function testTagIndexCode200WithFormat()
    {
        $response = $this->get('/api/admin/tags');
        $response->assertOk();
        $response->assertJson(assertPaginationFormat($this->allTagsInFormat->toArray()));
    }

    public function testTagStoreCode201WithFormatEnglish()
    {
        $response = $this->post('/api/admin/tags', $this->tagPayload());
        $response->assertCreated();
        $response->assertJson(assertCreatedPaginationFormat([...$this->allTagsInFormat, $this->tagResponseData("en")]));
    }

    public function testTagStoreCode201WithFormatArabic()
    {
        $this->preCreateRecords("ar");
        $response = $this->post('/api/admin/tags', $this->tagPayload());
        $response->assertCreated();
        $response->assertJson(assertCreatedPaginationFormat([...$this->allTagsInFormat, $this->tagResponseData("ar")]));
    }

    public function testTagUpdateCode200WithFormatEnglish()
    {
        $data['name'] = ["en" => "english name udpate"];

        $response = $this->put('/api/admin/tags/'.$this->firstTag->id, $this->tagPayload($data));
        $response->assertOk();

        $data['name'] = $data['name']["en"];

        $response->assertJson(assertPaginationFormat([$this->tagResponseData("en", $data)]));
    }

    public function testTagUpdateCode200WithFormatArabic()
    {
        $this->preCreateRecords("ar");

        $data['name'] = ["ar" => "arabic name udpate"];

        $response = $this->put('/api/admin/tags/'.$this->firstTag->id, $this->tagPayload($data));
        $response->assertOk();

        $data['name'] = $data['name']["ar"];

        $response->assertJson(assertPaginationFormat([$this->tagResponseData("ar", $data)]));
    }

    public function testTagShowCode200WithFormat()
    {
        $response = $this->get('/api/admin/tags/'.$this->firstTag->id);
        $response->assertOk();
        $response->assertJson(assertDataContent(assertTagResponseDataFormat($this->firstTag, true)));
    }

    public function testTagDeleteCode200WithFormat()
    {
        $response = $this->delete('/api/admin/tags/'.$this->firstTag->id);
        $response->assertOk();
        $response->assertJson(assertPaginationFormat());
    }

    public function testTagShowNotFoundCode404WithFormat()
    {
        $response = $this->get('/api/admin/tags/'."123213213213");
        $response->assertNotFound();
        $response->assertJson(assertNotFoundFormat());
    }
}
