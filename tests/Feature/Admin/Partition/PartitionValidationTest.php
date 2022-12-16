<?php

namespace Tests\Feature\Admin\Partition;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class PartitionValidationTest extends TestCase
{
    use RefreshDatabase, PartitionTestingTrait;

    // public function testPartitionStoreValidateRequiredItemsEnglish()
    // {
    //     $data = [
    //         "title" => "",
    //         "sub_title" => "",
    //         "description" => "",
    //         "short_description" => "",
    //         "photo" => "",
    //         "active" => "",
    //     ];
    //     $errors = [
    //         "(title) field is required",
    //         "(sub_title) field is required",
    //         "(description) field is required",
    //         "(short_description) field is required",
    //         "(photo) field is required",
    //         "(active) field is required",
    //     ];
    //     $response = $this->post('/api/admin/partitions', $this->partitionPayload($data));
    //     assertDataHasError($response, $errors);
    // }

    // public function testPartitionStoreValidateRequiredItemsArabic()
    // {
    //     App::setLocale('ar');
    //     $data = [
    //         "title" => "",
    //         "sub_title" => "",
    //         "description" => "",
    //         "short_description" => "",
    //         "photo" => "",
    //         "active" => "",
    //     ];
    //     $errors = [
    //         convert_arabic_to_unicode("(title) هذا الحقل مطلوب"),
    //         convert_arabic_to_unicode("(sub_title) هذا الحقل مطلوب"),
    //         convert_arabic_to_unicode("(description) هذا الحقل مطلوب"),
    //         convert_arabic_to_unicode("(short_description) هذا الحقل مطلوب"),
    //         convert_arabic_to_unicode("(photo) هذا الحقل مطلوب"),
    //         convert_arabic_to_unicode("(active) هذا الحقل مطلوب"),
    //     ];
    //     $response = $this->post('/api/admin/partitions', $this->partitionPayload($data));
    //     assertDataHasError($response, $errors);
    // }

    //Partition Store
    // public function testPartitionStoreValidateTitleArrayEnglish()
    // {
    //     $data = ["title" => "qwewqe"];
    //     $response = $this->post('/api/admin/partitions', $this->partitionPayload($data));
    //     assertDataHasError($response, "(title) field format is incorrect");
    // }

    // public function testPartitionStoreValidateTitleArrayArabic()
    // {
    //     App::setLocale('ar');
    //     $data = ["title" => "qwewqe"];
    //     $response = $this->post('/api/admin/partitions', $this->partitionPayload($data));
    //     assertDataHasError($response, convert_arabic_to_unicode("(title) تنسيق هذا الحقل غير سليم"));
    // }

    // public function testPartitionStoreValidateTitleAllowedLocalesEnglish()
    // {
    //     $title = [
    //         "en" => "english test",
    //         "es" => "espanol test",
    //         "ta" => "tamil test"
    //     ];

    //     $data =  ["title" => $title];

    //     $response = $this->post('/api/admin/partitions', $this->partitionPayload($data));
    //     assertDataHasError($response, "allowed languages for this field (title) (en,ar)");
    // }

    // public function testPartitionStoreValidateTitleAllowedLocalesArabic()
    // {
    //     App::setLocale('ar');
    //     $title = [
    //         "en" => "english test",
    //         "es" => "espanol test",
    //         "ta" => "tamil test"
    //     ];

    //     $data =  ["title" => $title];

    //     $response = $this->post('/api/admin/partitions', $this->partitionPayload($data));
    //     assertDataHasError($response, convert_arabic_to_unicode("اللغات المسموح بها لهذا الحقل (title) (en,ar)"));
    // }

    // public function testPartitionStoreValidateSubTitleArrayEnglish()
    // {
    //     $data = ["sub_title" => "qwewqe"];
    //     $response = $this->post('/api/admin/partitions', $this->partitionPayload($data));
    //     assertDataHasError($response, "(sub_title) field format is incorrect");
    // }

    // public function testPartitionStoreValidateSubTitleArrayArabic()
    // {
    //     App::setLocale('ar');
    //     $data = ["sub_title" => "qwewqe"];
    //     $response = $this->post('/api/admin/partitions', $this->partitionPayload($data));
    //     assertDataHasError($response, convert_arabic_to_unicode("(sub_title) تنسيق هذا الحقل غير سليم"));
    // }

    // public function testPartitionStoreValidateSubTitleAllowedLocalesEnglish()
    // {
    //     $sub_title = [
    //         "en" => "english test",
    //         "es" => "espanol test",
    //         "ta" => "tamil test"
    //     ];

    //     $data =  ["sub_title" => $sub_title];

    //     $response = $this->post('/api/admin/partitions', $this->partitionPayload($data));
    //     assertDataHasError($response, "allowed languages for this field (sub_title) (en,ar)");
    // }

    // public function testPartitionStoreValidateSubTitleAllowedLocalesArabic()
    // {
    //     App::setLocale('ar');
    //     $sub_title = [
    //         "en" => "english test",
    //         "es" => "espanol test",
    //         "ta" => "tamil test"
    //     ];

    //     $data =  ["sub_title" => $sub_title];

    //     $response = $this->post('/api/admin/partitions', $this->partitionPayload($data));
    //     assertDataHasError($response, convert_arabic_to_unicode("اللغات المسموح بها لهذا الحقل (sub_title) (en,ar)"));
    // }

    // public function testPartitionStoreValidateDescriptionArrayEnglish()
    // {
    //     $data = ["description" => "qwewqe"];
    //     $response = $this->post('/api/admin/partitions', $this->partitionPayload($data));
    //     assertDataHasError($response, "(description) field format is incorrect");
    // }

    // public function testPartitionStoreValidateDescriptionArrayArabic()
    // {
    //     App::setLocale('ar');
    //     $data = ["description" => "qwewqe"];
    //     $response = $this->post('/api/admin/partitions', $this->partitionPayload($data));
    //     assertDataHasError($response, convert_arabic_to_unicode("(description) تنسيق هذا الحقل غير سليم"));
    // }

    // public function testPartitionStoreValidateDescriptionAllowedLocalesEnglish()
    // {
    //     $description = [
    //         "en" => "english test",
    //         "es" => "espanol test",
    //         "ta" => "tamil test"
    //     ];

    //     $data =  ["description" => $description];

    //     $response = $this->post('/api/admin/partitions', $this->partitionPayload($data));
    //     assertDataHasError($response, "allowed languages for this field (description) (en,ar)");
    // }

    // public function testPartitionStoreValidateDescriptionAllowedLocalesArabic()
    // {
    //     App::setLocale('ar');
    //     $description = [
    //         "en" => "english test",
    //         "es" => "espanol test",
    //         "ta" => "tamil test"
    //     ];

    //     $data =  ["description" => $description];

    //     $response = $this->post('/api/admin/partitions', $this->partitionPayload($data));
    //     assertDataHasError($response, convert_arabic_to_unicode("اللغات المسموح بها لهذا الحقل (description) (en,ar)"));
    // }
    // public function testPartitionStoreValidateShortDescriptionArrayEnglish()
    // {
    //     $data = ["short_description" => "qwewqe"];
    //     $response = $this->post('/api/admin/partitions', $this->partitionPayload($data));
    //     assertDataHasError($response, "(short_description) field format is incorrect");
    // }

    // public function testPartitionStoreValidateShortDescriptionArrayArabic()
    // {
    //     App::setLocale('ar');
    //     $data = ["short_description" => "qwewqe"];
    //     $response = $this->post('/api/admin/partitions', $this->partitionPayload($data));
    //     assertDataHasError($response, convert_arabic_to_unicode("(short_description) تنسيق هذا الحقل غير سليم"));
    // }

    // public function testPartitionStoreValidateShortDescriptionAllowedLocalesEnglish()
    // {
    //     $short_description = [
    //         "en" => "english test",
    //         "es" => "espanol test",
    //         "ta" => "tamil test"
    //     ];

    //     $data =  ["short_description" => $short_description];

    //     $response = $this->post('/api/admin/partitions', $this->partitionPayload($data));
    //     assertDataHasError($response, "allowed languages for this field (short_description) (en,ar)");
    // }

    // public function testPartitionStoreValidateShortDescriptionAllowedLocalesArabic()
    // {
    //     App::setLocale('ar');
    //     $short_description = [
    //         "en" => "english test",
    //         "es" => "espanol test",
    //         "ta" => "tamil test"
    //     ];

    //     $data =  ["short_description" => $short_description];

    //     $response = $this->post('/api/admin/partitions', $this->partitionPayload($data));
    //     assertDataHasError($response, convert_arabic_to_unicode("اللغات المسموح بها لهذا الحقل (short_description) (en,ar)"));
    // }

    // public function testPartitionStoreValidatePhotoSizeEnglish()
    // {
    //     $data['photo'] = UploadedFile::fake()->create('test.png', $kilobytes = 5001);

    //     $response = $this->post('/api/admin/partitions', $this->partitionPayload($data));
    //     assertDataHasError($response, "(photo) (5000) is maximum size for this file");
    // }

    // public function testPartitionStoreValidatePhotoSizeArabic()
    // {
    //     App::setLocale("ar");
    //     $data['photo'] = UploadedFile::fake()->create('test.png', $kilobytes = 5001);

    //     $response = $this->post('/api/admin/partitions', $this->partitionPayload($data));
    //     assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(photo)", "(5000)", "هذا هو الحجم الأقصى لهذا الملف")));
    // }

    // public function testPartitionStoreValidatePhotoTypeEnglish()
    // {
    //     $data['photo'] = UploadedFile::fake()->create('test.mp3', $kilobytes = 5001);

    //     $response = $this->post('/api/admin/partitions', $this->partitionPayload($data));
    //     assertDataHasError($response, "(photo) (jpeg,jpg,png) are the valid types for this file");
    // }

    // public function testPartitionStoreValidatePhotoTypeArabic()
    // {
    //     App::setLocale("ar");
    //     $data['photo'] = UploadedFile::fake()->create('test.mp4', $kilobytes = 5001);

    //     $response = $this->post('/api/admin/partitions', $this->partitionPayload($data));
    //     assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(photo)", "(jpeg,jpg,png)", "هذه هي الأنواع الصالحة لهذا الملف")));
    // }

    // public function testPartitionStoreValidateActiveBooleanEnglish()
    // {
    //     $response = $this->post('/api/admin/partitions', $this->partitionPayload(["active" => 4]));
    //     assertDataHasError($response, "(active) (0,1) are the valid values for this field");
    // }

    // public function testPartitionStoreValidateActiveBooleanArabic()
    // {
    //     App::setLocale("ar");
    //     $response = $this->post('/api/admin/partitions', $this->partitionPayload(["active" => "123"]));
    //     assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(active)", "(0,1)", "هذه المعايير هي المسموح بها لحذ الحقل")));
    // }

    //Partition Update
    public function testPartitionUpdateValidateTitleArrayEnglish()
    {
        $data = ["title" => "qwewqe"];
        $response = $this->put('/api/admin/partitions/'.$this->firstPartition->id, $this->partitionPayload($data));
        assertDataHasError($response, "(title) field format is incorrect");
    }

    public function testPartitionUpdateValidateTitleArrayArabic()
    {
        App::setLocale('ar');
        $data = ["title" => "qwewqe"];
        $response = $this->put('/api/admin/partitions/'.$this->firstPartition->id, $this->partitionPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("(title) تنسيق هذا الحقل غير سليم"));
    }

    public function testPartitionUpdateValidateTitleAllowedLocalesEnglish()
    {
        $title = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $data =  ["title" => $title];

        $response = $this->put('/api/admin/partitions/'.$this->firstPartition->id, $this->partitionPayload($data));
        assertDataHasError($response, "allowed languages for this field (title) (en,ar)");
    }

    public function testPartitionUpdateValidateTitleAllowedLocalesArabic()
    {
        App::setLocale('ar');
        $title = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $data =  ["title" => $title];

        $response = $this->put('/api/admin/partitions/'.$this->firstPartition->id, $this->partitionPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("اللغات المسموح بها لهذا الحقل (title) (en,ar)"));
    }

    public function testPartitionUpdateValidateSubTitleArrayEnglish()
    {
        $data = ["sub_title" => "qwewqe"];
        $response = $this->put('/api/admin/partitions/'.$this->firstPartition->id, $this->partitionPayload($data));
        assertDataHasError($response, "(sub_title) field format is incorrect");
    }

    public function testPartitionUpdateValidateSubTitleArrayArabic()
    {
        App::setLocale('ar');
        $data = ["sub_title" => "qwewqe"];
        $response = $this->put('/api/admin/partitions/'.$this->firstPartition->id, $this->partitionPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("(sub_title) تنسيق هذا الحقل غير سليم"));
    }

    public function testPartitionUpdateValidateSubTitleAllowedLocalesEnglish()
    {
        $sub_title = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $data =  ["sub_title" => $sub_title];

        $response = $this->put('/api/admin/partitions/'.$this->firstPartition->id, $this->partitionPayload($data));
        assertDataHasError($response, "allowed languages for this field (sub_title) (en,ar)");
    }

    public function testPartitionUpdateValidateSubTitleAllowedLocalesArabic()
    {
        App::setLocale('ar');
        $sub_title = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $data =  ["sub_title" => $sub_title];

        $response = $this->put('/api/admin/partitions/'.$this->firstPartition->id, $this->partitionPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("اللغات المسموح بها لهذا الحقل (sub_title) (en,ar)"));
    }

    public function testPartitionUpdateValidateDescriptionArrayEnglish()
    {
        $data = ["description" => "qwewqe"];
        $response = $this->put('/api/admin/partitions/'.$this->firstPartition->id, $this->partitionPayload($data));
        assertDataHasError($response, "(description) field format is incorrect");
    }

    public function testPartitionUpdateValidateDescriptionArrayArabic()
    {
        App::setLocale('ar');
        $data = ["description" => "qwewqe"];
        $response = $this->put('/api/admin/partitions/'.$this->firstPartition->id, $this->partitionPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("(description) تنسيق هذا الحقل غير سليم"));
    }

    public function testPartitionUpdateValidateDescriptionAllowedLocalesEnglish()
    {
        $description = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $data =  ["description" => $description];

        $response = $this->put('/api/admin/partitions/'.$this->firstPartition->id, $this->partitionPayload($data));
        assertDataHasError($response, "allowed languages for this field (description) (en,ar)");
    }

    public function testPartitionUpdateValidateDescriptionAllowedLocalesArabic()
    {
        App::setLocale('ar');
        $description = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $data =  ["description" => $description];

        $response = $this->put('/api/admin/partitions/'.$this->firstPartition->id, $this->partitionPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("اللغات المسموح بها لهذا الحقل (description) (en,ar)"));
    }

    public function testPartitionUpdateValidateShortDescriptionArrayEnglish()
    {
        $data = ["short_description" => "qwewqe"];
        $response = $this->put('/api/admin/partitions/'.$this->firstPartition->id, $this->partitionPayload($data));
        assertDataHasError($response, "(short_description) field format is incorrect");
    }

    public function testPartitionUpdateValidateShortDescriptionArrayArabic()
    {
        App::setLocale('ar');
        $data = ["short_description" => "qwewqe"];
        $response = $this->put('/api/admin/partitions/'.$this->firstPartition->id, $this->partitionPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("(short_description) تنسيق هذا الحقل غير سليم"));
    }

    public function testPartitionUpdateValidateShortDescriptionAllowedLocalesEnglish()
    {
        $short_description = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $data =  ["short_description" => $short_description];

        $response = $this->put('/api/admin/partitions/'.$this->firstPartition->id, $this->partitionPayload($data));
        assertDataHasError($response, "allowed languages for this field (short_description) (en,ar)");
    }

    public function testPartitionUpdateValidateShortDescriptionAllowedLocalesArabic()
    {
        App::setLocale('ar');
        $short_description = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $data =  ["short_description" => $short_description];

        $response = $this->put('/api/admin/partitions/'.$this->firstPartition->id, $this->partitionPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("اللغات المسموح بها لهذا الحقل (short_description) (en,ar)"));
    }

    public function testPartitionUpdateValidatePhotoSizeEnglish()
    {
        $data['photo'] = UploadedFile::fake()->create('test.png', $kilobytes = 5001);

        $response = $this->put('/api/admin/partitions/'.$this->firstPartition->id, $this->partitionPayload($data));
        assertDataHasError($response, "(photo) (5000) is maximum size for this file");
    }

    public function testPartitionUpdateValidatePhotoSizeArabic()
    {
        App::setLocale("ar");
        $data['photo'] = UploadedFile::fake()->create('test.png', $kilobytes = 5001);

        $response = $this->put('/api/admin/partitions/'.$this->firstPartition->id, $this->partitionPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(photo)", "(5000)", "هذا هو الحجم الأقصى لهذا الملف")));
    }

    public function testPartitionUpdateValidatePhotoTypeEnglish()
    {
        $data['photo'] = UploadedFile::fake()->create('test.mp3', $kilobytes = 5001);

        $response = $this->put('/api/admin/partitions/'.$this->firstPartition->id, $this->partitionPayload($data));
        assertDataHasError($response, "(photo) (jpeg,jpg,png) are the valid types for this file");
    }

    public function testPartitionUpdateValidatePhotoTypeArabic()
    {
        App::setLocale("ar");
        $data['photo'] = UploadedFile::fake()->create('test.mp4', $kilobytes = 5001);

        $response = $this->put('/api/admin/partitions/'.$this->firstPartition->id, $this->partitionPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(photo)", "(jpeg,jpg,png)", "هذه هي الأنواع الصالحة لهذا الملف")));
    }

    public function testPartitionUpdateValidateActiveBooleanEnglish()
    {
        $data = ["active" => 4];
        $response = $this->put('/api/admin/partitions/'.$this->firstPartition->id, $this->partitionPayload($data));
        assertDataHasError($response, "(active) (0,1) are the valid values for this field");
    }

    public function testPartitionUpdateValidateActiveBooleanArabic()
    {
        App::setLocale("ar");
        $data = ["active" => 4];
        $response = $this->put('/api/admin/partitions/'.$this->firstPartition->id, $this->partitionPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(active)", "(0,1)", "هذه المعايير هي المسموح بها لحذ الحقل")));
    }
}
