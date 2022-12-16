<?php

namespace Tests\Feature\Admin\Setting;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingFilterTest extends TestCase
{
    use RefreshDatabase, SettingTestingTrait;

    public function testSettingIndexFilterKey()
    {
        $response = $this->get("/api/admin/settings?filter[key]=".$this->firstSetting->key);
        $response_settings = json_decode($response->content())->data;

        $all_relevant_settings = Setting::where('key', $this->firstSetting->key)->count();
        $this->assertEquals(count($response_settings), $all_relevant_settings);
    }

    public function testSettingIndexFilterGroup()
    {
        $response = $this->get("/api/admin/settings?filter[group]=".$this->firstSetting->group);
        $response_settings = json_decode($response->content())->data;

        $all_relevant_settings = Setting::where('group', $this->firstSetting->group)->count();
        $this->assertEquals(count($response_settings), $all_relevant_settings);
    }
}
