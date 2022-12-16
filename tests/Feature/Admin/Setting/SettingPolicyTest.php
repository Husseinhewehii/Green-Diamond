<?php

namespace Tests\Feature\Admin\Setting;

use App\Models\Setting;
use App\Models\User;
use Database\Seeders\SettingSeeder;
use Database\Seeders\SuperAdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\TestCase;

class SettingPolicyTest extends TestCase
{
    use RefreshDatabase;

    protected $superAdmin;
    protected $firstSetting;
    protected $settings;
    protected $updateUrl;
    protected $payloadSetting;

    public function setUp() : void
    {
        parent::setUp();

        $this->seed(SettingSeeder::class);
        $this->firstSetting = Setting::first();

        $this->seed(SuperAdminSeeder::class);
        $this->superAdmin = User::whereEmail('super@admin.com')->first();

        Artisan::call('passport:install');
        Passport::actingAs($this->superAdmin);

        $this->payloadSetting = [
            'value' => "abc",
        ];
        $this->updateUrl = '/api/admin/settings/'.$this->firstSetting->id;
    }

    public function testSettingIndexCode403()
    {
        $response = $this->get('/api/admin/settings');
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }

    public function testSettingPutCode403()
    {
        $response = $this->put($this->updateUrl, $this->payloadSetting);
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }
}
