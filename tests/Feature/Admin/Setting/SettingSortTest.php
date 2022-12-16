<?php

namespace Tests\Feature\Admin\Setting;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingSortTest extends TestCase
{
    use RefreshDatabase, SettingTestingTrait;

    public function testSettingIndexSortKey()
    {
        $response = $this->get("/api/admin/settings?sort=key");
        $response_settings = json_decode($response->content())->data;
        $first_setting_sorted_by_key = Setting::orderBy('key')->first("key")->key;
        $this->assertEquals($response_settings[0]->key, $first_setting_sorted_by_key);
    }

    public function testSettingIndexSortGroup()
    {
        $response = $this->get("/api/admin/settings?sort=group");
        $response_settings = json_decode($response->content())->data;
        $first_setting_sorted_by_group = Setting::orderBy('group')->first("group")->group;
        $this->assertEquals($response_settings[0]->group, $first_setting_sorted_by_group);
    }
}
