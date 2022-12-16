<?php

namespace Tests\Feature\Admin\Setting;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class SettingValidationTest extends TestCase
{
    use RefreshDatabase, SettingTestingTrait;

    public function testSettingUpdateValidateValueRequiredEnglish()
    {
        $payLoad = ["value" => ""];
        $response = $this->put($this->updateUrl, $payLoad);
        assertDataHasError($response, "(value) field is required");
    }

    public function testSettingUpdateValidateValueRequiredArabic()
    {
        App::setLocale('ar');
        $payLoad = ["value" => ""];
        $response = $this->put($this->updateUrl, $payLoad);
        assertDataHasError($response, convert_arabic_to_unicode("(value) هذا الحقل مطلوب"));
    }
}
