<?php

namespace Tests\Feature\Admin\Setting;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingTest extends TestCase
{
    use RefreshDatabase, SettingTestingTrait;

    public function testSettingPutValueUpdated()
    {
        $this->put($this->updateUrl, $this->settingPayLoad());

        $updatedSetting = Setting::find($this->firstSetting->id);
        $this->assertEquals($updatedSetting->value, $this->settingPayLoad()['value']);
    }

    public function testSettingSoftDelete(){
        $setting = $this->settings[0];
        $setting->delete();
        $this->assertSoftDeleted($setting);
        $this->assertDatabaseCount("settings", count($this->settings));
    }

    public function testSettingPutActivityLog()
    {
        $this->put($this->updateUrl, $this->settingPayLoad());
        $data = [
            "causer_id" => $this->superAdmin->id,
            "subject_id" => $this->firstSetting->id,
            "subject_type" => get_class($this->firstSetting),
            "description" => "updated",
        ];
        $this->assertDatabaseHas('activity_log', $data);
    }
}
