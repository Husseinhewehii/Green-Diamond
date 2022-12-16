<?php

namespace Tests\Feature\Admin\StaticContent;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class StaticContentValidations extends TestCase
{
    use RefreshDatabase, StaticContentTestingTrait;

    public function testStaticContentUpdateValidateTextRequiredEnglish()
    {
        $payLoad = ["text" => ""];
        $response = $this->put($this->updateUrl, $payLoad);
        assertDataHasError($response, "(text) field is required");
    }

    public function testStaticContentUpdateValidateTextRequiredArabic()
    {
        App::setLocale('ar');
        $payLoad = ["text" => ""];
        $response = $this->put($this->updateUrl, $payLoad);
        assertDataHasError($response, convert_arabic_to_unicode("(text) هذا الحقل مطلوب"));
    }

    public function testStaticContentUpdateValidateTextArrayEnglish()
    {
        $payLoad = ["text" => "qwewqe"];
        $response = $this->put($this->updateUrl, $payLoad);
        assertDataHasError($response, "(text) field format is incorrect");
    }

    public function testStaticContentUpdateValidateTextArrayArabic()
    {
        App::setLocale('ar');
        $payLoad = ["text" => "qwewqe"];
        $response = $this->put($this->updateUrl, $payLoad);
        assertDataHasError($response, convert_arabic_to_unicode("(text) تنسيق هذا الحقل غير سليم"));
    }

    public function testStaticContentUpdateValidateTextAllowedLocalesEnglish()
    {
        $text = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $payLoad =  ["text" => $text];

        $response = $this->put($this->updateUrl, $payLoad);
        assertDataHasError($response, "allowed languages for this field (text) (en,ar)");
    }

    public function testStaticContentUpdateValidateTextAllowedLocalesArabic()
    {
        App::setLocale('ar');
        $text = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $payLoad =  ["text" => $text];

        $response = $this->put($this->updateUrl, $payLoad);
        assertDataHasError($response, convert_arabic_to_unicode("اللغات المسموح بها لهذا الحقل (text) (en,ar)"));
    }
}
