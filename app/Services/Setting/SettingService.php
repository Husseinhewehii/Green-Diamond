<?php

namespace App\Services\Setting;

use App\Models\Setting;

class SettingService
{
    public function updateSetting($request, $setting)
    {
        $setting->update($request->validated());
    }
}
