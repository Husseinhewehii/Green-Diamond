<?php

namespace Tests\Feature\Admin\Setting;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingResponseTest extends TestCase
{
    use RefreshDatabase, SettingTestingTrait;

    public function testSettingIndexCode200WithFormat()
    {
        $response = $this->get('/api/admin/settings');
        $response->assertOk();
        $response->assertJson(assertDataContent([$this->settingFormat()]));
    }

    public function testSettingUpdateCode200WithFormat()
    {
        $response = $this->put($this->updateUrl, $this->settingPayLoad());
        $response->assertOk();
        $response->assertJson(assertDataContent([$this->settingPayLoad()]));
    }
}
