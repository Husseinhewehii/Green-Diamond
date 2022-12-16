<?php

namespace Tests\Feature\Admin\Setting;

use App\Models\Setting;
use Database\Seeders\SettingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingtUnAuthenticatedTest extends TestCase
{
    use RefreshDatabase;
    protected $updateUrl;
    protected $firstSetting;

    public function setUp() : void
    {
        parent::setUp();
        $this->seed(SettingSeeder::class);
        $this->firstSetting = Setting::first();
        $this->updateUrl = '/api/admin/settings/'.$this->firstSetting->id;
    }

    public function testSettingIndexUnauthenticatedCode401()
    {
        $response = $this->get('/api/admin/settings');
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

    public function testSettingUpdateOneByKeyUnauthenticatedCode401()
    {
        $response = $this->put($this->updateUrl);
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }
}
