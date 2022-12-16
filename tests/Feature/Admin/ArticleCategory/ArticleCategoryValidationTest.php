<?php

namespace Tests\Feature\Admin\ArticleCategory;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class ArticleCategoryValidationTest extends TestCase
{
    use RefreshDatabase, ArticleCategoryTestingTrait;

    public function testArticleCategoryStoreValidateRequiredItemsEnglish()
    {
        $data = [
            "title" => "",
            "type" => "",
            // "photo" => "",
            "active" => "",
        ];
        $errors = [
            "(title) field is required",
            "(type) field is required",
            // "(photo) field is required",
            "(active) field is required",
        ];
        $response = $this->post('/api/admin/articleCategories', $this->articleCategoryPayload($data));
        assertDataHasError($response, $errors);
    }

    public function testArticleCategoryStoreValidateRequiredItemsArabic()
    {
        App::setLocale('ar');
        $data = [
            "title" => "",
            "type" => "",
            // "photo" => "",
            "active" => "",
        ];
        $errors = [
            convert_arabic_to_unicode("(title) هذا الحقل مطلوب"),
            convert_arabic_to_unicode("(type) هذا الحقل مطلوب"),
            // convert_arabic_to_unicode("(photo) هذا الحقل مطلوب"),
            convert_arabic_to_unicode("(active) هذا الحقل مطلوب"),
        ];
        $response = $this->post('/api/admin/articleCategories', $this->articleCategoryPayload($data));
        assertDataHasError($response, $errors);
    }

    // //ArticleCategory Store

    public function testArticleCategoryStoreValidateTypeBlogsOrNewsEnglish()
    {
        $data = ["type" => 4];
        $response = $this->post('/api/admin/articleCategories', $this->articleCategoryPayload($data));
        assertDataHasError($response, "(type) (1,2) are the valid values for this field");
    }

    public function testArticleCategoryStoreValidateTypeBlogsOrNewsArabic()
    {
        App::setLocale("ar");
        $data = ["type" => 0];
        $response = $this->post('/api/admin/articleCategories', $this->articleCategoryPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(type)", "(1,2)", "هذه المعايير هي المسموح بها لحذ الحقل")));
    }

    public function testArticleCategoryStoreValidateParentIdExistsInArticleCategoriesEnglish()
    {
        $data = ["parent_id" => 4];
        $response = $this->post('/api/admin/articleCategories', $this->articleCategoryPayload($data));
        assertDataHasError($response, "(Parent ID) values of this field are incorrect");
    }

    public function testArticleCategoryStoreValidateParentIdExistsInArticleCategoriesArabic()
    {
        App::setLocale("ar");
        $data = ["parent_id" => 0];
        $response = $this->post('/api/admin/articleCategories', $this->articleCategoryPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s", "(Parent ID)", "قيم هذا الحقل غير صحيحة")));
    }

    public function testArticleCategoryStoreValidateTitleArrayEnglish()
    {
        $data = ["title" => "qwewqe"];
        $response = $this->post('/api/admin/articleCategories', $this->articleCategoryPayload($data));
        assertDataHasError($response, "(title) field format is incorrect");
    }

    public function testArticleCategoryStoreValidateTitleArrayArabic()
    {
        App::setLocale('ar');
        $data = ["title" => "qwewqe"];
        $response = $this->post('/api/admin/articleCategories', $this->articleCategoryPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("(title) تنسيق هذا الحقل غير سليم"));
    }

    public function testArticleCategoryStoreValidateTitleAllowedLocalesEnglish()
    {
        $title = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $data =  ["title" => $title];

        $response = $this->post('/api/admin/articleCategories', $this->articleCategoryPayload($data));
        assertDataHasError($response, "allowed languages for this field (title) (en,ar)");
    }

    public function testArticleCategoryStoreValidateTitleAllowedLocalesArabic()
    {
        App::setLocale('ar');
        $title = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $data =  ["title" => $title];

        $response = $this->post('/api/admin/articleCategories', $this->articleCategoryPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("اللغات المسموح بها لهذا الحقل (title) (en,ar)"));
    }

    // public function testArticleCategoryStoreValidatePhotoSizeEnglish()
    // {
    //     $data['photo'] = UploadedFile::fake()->create('test.png', $kilobytes = 5001);

    //     $response = $this->post('/api/admin/articleCategories', $this->articleCategoryPayload($data));
    //     assertDataHasError($response, "(photo) (5000) is maximum size for this file");
    // }

    // public function testArticleCategoryStoreValidatePhotoSizeArabic()
    // {
    //     App::setLocale("ar");
    //     $data['photo'] = UploadedFile::fake()->create('test.png', $kilobytes = 5001);

    //     $response = $this->post('/api/admin/articleCategories', $this->articleCategoryPayload($data));
    //     assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(photo)", "(5000)", "هذا هو الحجم الأقصى لهذا الملف")));
    // }

    // public function testArticleCategoryStoreValidatePhotoTypeEnglish()
    // {
    //     $data['photo'] = UploadedFile::fake()->create('test.mp3', $kilobytes = 5001);

    //     $response = $this->post('/api/admin/articleCategories', $this->articleCategoryPayload($data));
    //     assertDataHasError($response, "(photo) (jpeg,jpg,png) are the valid types for this file");
    // }

    // public function testArticleCategoryStoreValidatePhotoTypeArabic()
    // {
    //     App::setLocale("ar");
    //     $data['photo'] = UploadedFile::fake()->create('test.mp4', $kilobytes = 5001);

    //     $response = $this->post('/api/admin/articleCategories', $this->articleCategoryPayload($data));
    //     assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(photo)", "(jpeg,jpg,png)", "هذه هي الأنواع الصالحة لهذا الملف")));
    // }

    public function testArticleCategoryStoreValidateActiveBooleanEnglish()
    {
        $response = $this->post('/api/admin/articleCategories', $this->articleCategoryPayload(["active" => 4]));
        assertDataHasError($response, "(active) (0,1) are the valid values for this field");
    }

    public function testArticleCategoryStoreValidateActiveBooleanArabic()
    {
        App::setLocale("ar");
        $response = $this->post('/api/admin/articleCategories', $this->articleCategoryPayload(["active" => "123"]));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(active)", "(0,1)", "هذه المعايير هي المسموح بها لحذ الحقل")));
    }

    //ArticleCategory Update
    public function testArticleCategoryUpdateValidateTypeBlogsOrNewsEnglish()
    {
        $data = ["type" => 4];
        $response = $this->put('/api/admin/articleCategories/'.$this->firstArticleCategory->id, $this->articleCategoryPayload($data));
        assertDataHasError($response, "(type) (1,2) are the valid values for this field");
    }

    public function testArticleCategoryUpdateValidateTypeBlogsOrNewsArabic()
    {
        App::setLocale("ar");
        $data = ["type" => 0];
        $response = $this->put('/api/admin/articleCategories/'.$this->firstArticleCategory->id, $this->articleCategoryPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(type)", "(1,2)", "هذه المعايير هي المسموح بها لحذ الحقل")));
    }

    public function testArticleCategoryUpdateValidateParentIdExistsInArticleCategoriesEnglish()
    {
        $data = ["parent_id" => 4];
        $response = $this->put('/api/admin/articleCategories/'.$this->firstArticleCategory->id, $this->articleCategoryPayload($data));
        assertDataHasError($response, "(Parent ID) values of this field are incorrect");
    }

    public function testArticleCategoryUpdateValidateParentIdExistsInArticleCategoriesArabic()
    {
        App::setLocale("ar");
        $data = ["parent_id" => 0];
        $response = $this->put('/api/admin/articleCategories/'.$this->firstArticleCategory->id, $this->articleCategoryPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s", "(Parent ID)", "قيم هذا الحقل غير صحيحة")));
    }

    public function testArticleCategoryUpdateValidateParentIdNotEqualSameArticleCategoryIDEnglish()
    {
        $data = ["parent_id" => $this->firstArticleCategory->id];
        $response = $this->put('/api/admin/articleCategories/'.$this->firstArticleCategory->id, $this->articleCategoryPayload($data));
        assertDataHasError($response, "(Parent ID) should be different from targeted item");
    }

    public function testArticleCategoryUpdateValidateParentIdNotEqualSameArticleCategoryIDArabic()
    {
        App::setLocale("ar");
        $data = ["parent_id" => $this->firstArticleCategory->id];
        $response = $this->put('/api/admin/articleCategories/'.$this->firstArticleCategory->id, $this->articleCategoryPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s", "(Parent ID)", "يجب أن تكون قيمة هذا الحقل مختلفة عن العنصر المستهدف")));
    }

    public function testArticleCategoryUpdateValidateTitleArrayEnglish()
    {
        $data = ["title" => "qwewqe"];
        $response = $this->put('/api/admin/articleCategories/'.$this->firstArticleCategory->id, $this->articleCategoryPayload($data));
        assertDataHasError($response, "(title) field format is incorrect");
    }

    public function testArticleCategoryUpdateValidateTitleArrayArabic()
    {
        App::setLocale('ar');
        $data = ["title" => "qwewqe"];
        $response = $this->put('/api/admin/articleCategories/'.$this->firstArticleCategory->id, $this->articleCategoryPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("(title) تنسيق هذا الحقل غير سليم"));
    }

    public function testArticleCategoryUpdateValidateTitleAllowedLocalesEnglish()
    {
        $title = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $data =  ["title" => $title];

        $response = $this->put('/api/admin/articleCategories/'.$this->firstArticleCategory->id, $this->articleCategoryPayload($data));
        assertDataHasError($response, "allowed languages for this field (title) (en,ar)");
    }

    public function testArticleCategoryUpdateValidateTitleAllowedLocalesArabic()
    {
        App::setLocale('ar');
        $title = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $data =  ["title" => $title];

        $response = $this->put('/api/admin/articleCategories/'.$this->firstArticleCategory->id, $this->articleCategoryPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("اللغات المسموح بها لهذا الحقل (title) (en,ar)"));
    }

    // public function testArticleCategoryUpdateValidatePhotoSizeEnglish()
    // {
    //     $data['photo'] = UploadedFile::fake()->create('test.png', $kilobytes = 5001);

    //     $response = $this->put('/api/admin/articleCategories/'.$this->firstArticleCategory->id, $this->articleCategoryPayload($data));
    //     assertDataHasError($response, "(photo) (5000) is maximum size for this file");
    // }

    // public function testArticleCategoryUpdateValidatePhotoSizeArabic()
    // {
    //     App::setLocale("ar");
    //     $data['photo'] = UploadedFile::fake()->create('test.png', $kilobytes = 5001);

    //     $response = $this->put('/api/admin/articleCategories/'.$this->firstArticleCategory->id, $this->articleCategoryPayload($data));
    //     assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(photo)", "(5000)", "هذا هو الحجم الأقصى لهذا الملف")));
    // }

    // public function testArticleCategoryUpdateValidatePhotoTypeEnglish()
    // {
    //     $data['photo'] = UploadedFile::fake()->create('test.mp3', $kilobytes = 5001);

    //     $response = $this->put('/api/admin/articleCategories/'.$this->firstArticleCategory->id, $this->articleCategoryPayload($data));
    //     assertDataHasError($response, "(photo) (jpeg,jpg,png) are the valid types for this file");
    // }

    // public function testArticleCategoryUpdateValidatePhotoTypeArabic()
    // {
    //     App::setLocale("ar");
    //     $data['photo'] = UploadedFile::fake()->create('test.mp4', $kilobytes = 5001);

    //     $response = $this->put('/api/admin/articleCategories/'.$this->firstArticleCategory->id, $this->articleCategoryPayload($data));
    //     assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(photo)", "(jpeg,jpg,png)", "هذه هي الأنواع الصالحة لهذا الملف")));
    // }

    public function testArticleCategoryUpdateValidateActiveBooleanEnglish()
    {
        $data = ["active" => 4];
        $response = $this->put('/api/admin/articleCategories/'.$this->firstArticleCategory->id, $this->articleCategoryPayload($data));
        assertDataHasError($response, "(active) (0,1) are the valid values for this field");
    }

    public function testArticleCategoryUpdateValidateActiveBooleanArabic()
    {
        App::setLocale("ar");
        $data = ["active" => 4];
        $response = $this->put('/api/admin/articleCategories/'.$this->firstArticleCategory->id, $this->articleCategoryPayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(active)", "(0,1)", "هذه المعايير هي المسموح بها لحذ الحقل")));
    }
}
