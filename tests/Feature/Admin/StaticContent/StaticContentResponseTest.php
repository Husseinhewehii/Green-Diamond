<?php

namespace Tests\Feature\Admin\StaticContent;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StaticContentResponseTest extends TestCase
{
    use RefreshDatabase, StaticContentTestingTrait;

    public function testStaticContentIndexCode200WithFormat()
    {
        $response = $this->get('/api/admin/static-content');
        $response->assertOk();
        $response->assertJson(assertDataContent([$this->staticContentFormat()]));
    }

    public function testStaticContentPutCode200WithFormat()
    {
        $response = $this->put($this->updateUrl, $this->staticContentPayLoad());
        $response->assertOk();
        $response->assertJson(assertDataContent([$this->staticContentPayLoad()]));
    }

    public function testStaticContentUpdateValidateTextLocalesOnlySuccessEnglish()
    {
        $text = [
            "en" => "english test",
        ];

        $payLoad = $this->staticContentPayLoad(["text" => $text]);

        $response = $this->put($this->updateUrl, $payLoad);
        $response->assertOk();
    }

    public function testStaticContentUpdateValidateTextLocalesOnlySuccessArabic()
    {
        $text = [
            "ar" => "arabic test",
        ];

        $payLoad = $this->staticContentPayLoad(["text" => $text]);

        $response = $this->put($this->updateUrl, $payLoad);
        $response->assertOk();
    }
}
