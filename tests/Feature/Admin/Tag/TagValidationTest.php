<?php

namespace Tests\Feature\Admin\Tag;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class TagValidationTest extends TestCase
{
    use RefreshDatabase, TagTestingTrait;

    public function testTagStoreValidateRequiredItemsEnglish()
    {
        $data = [
            "name" => "",
            "active" => "",
        ];

        $errors = [
            "(name) field is required",
            "(active) field is required"
        ];
        $response = $this->post('/api/admin/tags', $this->tagPayload($data));
        assertDataHasError($response, $errors);
    }

    public function testTagStoreValidateRequiredItemsArabic()
    {
        App::setLocale('ar');
        $data = [
            "name" => "",
            "active" => "",
        ];
        $errors = [
            convert_arabic_to_unicode("(name) هذا الحقل مطلوب"),
            convert_arabic_to_unicode("(active) هذا الحقل مطلوب"),
        ];
        $response = $this->post('/api/admin/tags', $this->tagPayload($data));
        assertDataHasError($response, $errors);
    }

    //Article Store
    public function testTagStoreValidateNameArrayEnglish()
    {
        $data = ["name" => "qwewqe"];
        $response = $this->post('/api/admin/tags', $this->tagPayload($data));
        assertDataHasError($response, "(name) field format is incorrect");
    }

    public function testTagStoreValidateNameArrayArabic()
    {
        App::setLocale('ar');
        $data = ["name" => "qwewqe"];
        $response = $this->post('/api/admin/tags', $this->tagPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("(name) تنسيق هذا الحقل غير سليم"));
    }

    public function testTagStoreValidateNameAllowedLocalesEnglish()
    {
        $name = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $data =  ["name" => $name];

        $response = $this->post('/api/admin/tags', $this->tagPayload($data));
        assertDataHasError($response, "allowed languages for this field (name) (en,ar)");
    }

    public function testTagStoreValidateNameAllowedLocalesArabic()
    {
        App::setLocale('ar');
        $name = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $data =  ["name" => $name];

        $response = $this->post('/api/admin/tags', $this->tagPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("اللغات المسموح بها لهذا الحقل (name) (en,ar)"));
    }

    public function testTagStoreValidateActiveBooleanEnglish()
    {
        $data = ["active" => 4];
        $response = $this->post('/api/admin/tags', $this->tagPayload($data));
        assertDataHasError($response, "(active) (0,1) are the valid values for this field");
    }

    public function testTagStoreValidateActiveBooleanArabic()
    {
        App::setLocale("ar");
        $data = ["active" => "123"];
        $response = $this->post('/api/admin/tags', $this->tagPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(active)", "(0,1)", "هذه المعايير هي المسموح بها لحذ الحقل")));
    }

    // Tag Update
    public function testTagUpdateValidateNameArrayEnglish()
    {
        $data = ["name" => "qwewqe"];
        $response = $this->put('/api/admin/tags/'.$this->firstTag->id, $this->tagPayload($data));
        assertDataHasError($response, "(name) field format is incorrect");
    }

    public function testTagUpdateValidateNameArrayArabic()
    {
        App::setLocale('ar');
        $data = ["name" => "qwewqe"];
        $response = $this->put('/api/admin/tags/'.$this->firstTag->id, $this->tagPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("(name) تنسيق هذا الحقل غير سليم"));
    }

    public function testTagUpdateValidateNameAllowedLocalesEnglish()
    {
        $name = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $data =  ["name" => $name];

        $response = $this->put('/api/admin/tags/'.$this->firstTag->id, $this->tagPayload($data));
        assertDataHasError($response, "allowed languages for this field (name) (en,ar)");
    }

    public function testTagUpdateValidateNameAllowedLocalesArabic()
    {
        App::setLocale('ar');
        $name = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $data =  ["name" => $name];

        $response = $this->put('/api/admin/tags/'.$this->firstTag->id, $this->tagPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("اللغات المسموح بها لهذا الحقل (name) (en,ar)"));
    }

    public function testTagUpdateValidateActiveBooleanEnglish()
    {
        $data = ["active" => 4];
        $response = $this->put('/api/admin/tags/'.$this->firstTag->id, $this->tagPayload($data));
        assertDataHasError($response, "(active) (0,1) are the valid values for this field");
    }

    public function testTagUpdateValidateActiveBooleanArabic()
    {
        App::setLocale("ar");
        $data = ["active" => 4];
        $response = $this->put('/api/admin/tags/'.$this->firstTag->id, $this->tagPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(active)", "(0,1)", "هذه المعايير هي المسموح بها لحذ الحقل")));
    }
}
