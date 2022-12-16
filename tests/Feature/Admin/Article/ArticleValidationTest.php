<?php

namespace Tests\Feature\Admin\Article;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class ArticleValidationTest extends TestCase
{
    use RefreshDatabase, ArticleTestingTrait;

    public function testArticleStoreValidateRequiredItemsEnglish()
    {
        $data = [
            "title" => "",
            "article_category_id" => "",
            "description" => "",
            "short_description" => "",
            "photo" => "",
            "active" => "",
        ];
        $errors = [
            "(title) field is required",
            "(Article Category ID) field is required",
            "(description) field is required",
            "(short_description) field is required",
            "(photo) field is required",
            "(active) field is required",
        ];
        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, $errors);
    }

    public function testArticleStoreValidateRequiredItemsArabic()
    {
        App::setLocale('ar');
        $data = [
            "title" => "",
            "article_category_id" => "",
            "description" => "",
            "short_description" => "",
            "photo" => "",
            "active" => "",
        ];
        $errors = [
            convert_arabic_to_unicode("(title) هذا الحقل مطلوب"),
            convert_arabic_to_unicode("(Article Category ID) هذا الحقل مطلوب"),
            convert_arabic_to_unicode("(description) هذا الحقل مطلوب"),
            convert_arabic_to_unicode("(short_description) هذا الحقل مطلوب"),
            convert_arabic_to_unicode("(photo) هذا الحقل مطلوب"),
            convert_arabic_to_unicode("(active) هذا الحقل مطلوب"),
        ];
        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, $errors);
    }

    //Article Store
    public function testArticleStoreValidateArticleCategoryIdExistsEnglish()
    {
        $data = ["article_category_id" => "1293819283091283091283921321312321"];
        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, "(Article Category ID) values of this field are incorrect");
    }

    public function testArticleStoreValidateArticleCategoryIdExistsArabic()
    {
        App::setLocale('ar');
        $data = ["article_category_id" => "1293819283091283091283921321312321"];
        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, sprintf("%s %s", "(Article Category ID)", convert_arabic_to_unicode("قيم هذا الحقل غير صحيحة")));
    }

    public function testArticleStoreValidateTitleArrayEnglish()
    {
        $data = ["title" => "qwewqe"];
        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, "(title) field format is incorrect");
    }

    public function testArticleStoreValidateTitleArrayArabic()
    {
        App::setLocale('ar');
        $data = ["title" => "qwewqe"];
        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("(title) تنسيق هذا الحقل غير سليم"));
    }

    public function testArticleStoreValidateTitleAllowedLocalesEnglish()
    {
        $title = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $data =  ["title" => $title];

        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, "allowed languages for this field (title) (en,ar)");
    }

    public function testArticleStoreValidateTitleAllowedLocalesArabic()
    {
        App::setLocale('ar');
        $title = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $data =  ["title" => $title];

        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("اللغات المسموح بها لهذا الحقل (title) (en,ar)"));
    }
    public function testArticleStoreValidateDescriptionArrayEnglish()
    {
        $data = ["description" => "qwewqe"];
        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, "(description) field format is incorrect");
    }

    public function testArticleStoreValidateDescriptionArrayArabic()
    {
        App::setLocale('ar');
        $data = ["description" => "qwewqe"];
        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("(description) تنسيق هذا الحقل غير سليم"));
    }

    public function testArticleStoreValidateDescriptionAllowedLocalesEnglish()
    {
        $description = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $data =  ["description" => $description];

        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, "allowed languages for this field (description) (en,ar)");
    }

    public function testArticleStoreValidateDescriptionAllowedLocalesArabic()
    {
        App::setLocale('ar');
        $description = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $data =  ["description" => $description];

        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("اللغات المسموح بها لهذا الحقل (description) (en,ar)"));
    }
    public function testArticleStoreValidateShortDescriptionArrayEnglish()
    {
        $data = ["short_description" => "qwewqe"];
        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, "(short_description) field format is incorrect");
    }

    public function testArticleStoreValidateShortDescriptionArrayArabic()
    {
        App::setLocale('ar');
        $data = ["short_description" => "qwewqe"];
        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("(short_description) تنسيق هذا الحقل غير سليم"));
    }

    public function testArticleStoreValidateShortDescriptionAllowedLocalesEnglish()
    {
        $short_description = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $data =  ["short_description" => $short_description];

        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, "allowed languages for this field (short_description) (en,ar)");
    }

    public function testArticleStoreValidateShortDescriptionAllowedLocalesArabic()
    {
        App::setLocale('ar');
        $short_description = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $data =  ["short_description" => $short_description];

        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("اللغات المسموح بها لهذا الحقل (short_description) (en,ar)"));
    }

    public function testArticleStoreValidatePhotoSizeEnglish()
    {
        $data['photo'] = UploadedFile::fake()->create('test.png', $kilobytes = 5001);

        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, "(photo) (5000) is maximum size for this file");
    }

    public function testArticleStoreValidatePhotoSizeArabic()
    {
        App::setLocale("ar");
        $data['photo'] = UploadedFile::fake()->create('test.png', $kilobytes = 5001);

        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(photo)", "(5000)", "هذا هو الحجم الأقصى لهذا الملف")));
    }

    public function testArticleStoreValidatePhotoTypeEnglish()
    {
        $data['photo'] = UploadedFile::fake()->create('test.mp3', $kilobytes = 5001);

        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, "(photo) (jpeg,jpg,png) are the valid types for this file");
    }

    public function testArticleStoreValidatePhotoTypeArabic()
    {
        App::setLocale("ar");
        $data['photo'] = UploadedFile::fake()->create('test.mp4', $kilobytes = 5001);

        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(photo)", "(jpeg,jpg,png)", "هذه هي الأنواع الصالحة لهذا الملف")));
    }

    public function testArticleStoreValidateActiveBooleanEnglish()
    {
        $response = $this->post('/api/admin/articles', $this->articlePayload(["active" => 4]));
        assertDataHasError($response, "(active) (0,1) are the valid values for this field");
    }

    public function testArticleStoreValidateActiveBooleanArabic()
    {
        App::setLocale("ar");
        $response = $this->post('/api/admin/articles', $this->articlePayload(["active" => "123"]));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(active)", "(0,1)", "هذه المعايير هي المسموح بها لحذ الحقل")));
    }

    public function testArticleStoreValidateTagIdsArrayEnglish()
    {
        $data = ["tag_ids" => "123123"];
        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, "(Tag IDs) field format is incorrect");
    }

    public function testArticleStoreValidateTagIdsArrayArabic()
    {
        App::setLocale("ar");
        $data = ["tag_ids" => "123123"];
        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, sprintf("%s %s", "(Tag IDs)", convert_arabic_to_unicode("تنسيق هذا الحقل غير سليم")));
    }

    public function testArticleStoreValidateTagIdsIncorrectEnglish()
    {
        $data = ["tag_ids" => [59595955,292929,29292299090]];
        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, "(Tag IDs) values of this field are incorrect");
    }

    public function testArticleStoreValidateTagIdsIncorrectArabic()
    {
        App::setLocale("ar");
        $data = ["tag_ids" => [59595955,292929,29292299090]];
        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, sprintf("%s %s", "(Tag IDs)", convert_arabic_to_unicode("قيم هذا الحقل غير صحيحة")));
    }

    public function testArticleStoreValidateMediaGalleryArrayEnglish()
    {
        $data = ["media_gallery" => "123123"];
        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, "(Media Gallery Item) field format is incorrect");
    }

    public function testArticleStoreValidateMediaGalleryArrayArabic()
    {
        App::setLocale("ar");
        $data = ["media_gallery" => "123123"];
        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, sprintf("%s %s", "(Media Gallery Item)", convert_arabic_to_unicode("تنسيق هذا الحقل غير سليم")));
    }

    public function testArticleStoreValidateMediaGalleryItemSizeEnglish()
    {
        $data['media_gallery'] = [
            UploadedFile::fake()->create('test.png', $kilobytes = 5001)
        ];

        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, "(Media Gallery Item) (5000) is maximum size for this file");
    }

    public function testArticleStoreValidateMediaGalleryItemSizeArabic()
    {
        App::setLocale("ar");
        $data['media_gallery'] = [
            UploadedFile::fake()->create('test.png', $kilobytes = 5001)
        ];

        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(Media Gallery Item)", "(5000)", "هذا هو الحجم الأقصى لهذا الملف")));
    }

    public function testArticleStoreValidateMediaGalleryItemTypeEnglish()
    {
        $data['media_gallery'] = [
            UploadedFile::fake()->create('test.mp3', $kilobytes = 5001)
        ];

        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, "(Media Gallery Item) (jpeg,jpg,png) are the valid types for this file");
    }

    public function testArticleStoreValidateMediaGalleryItemTypeArabic()
    {
        App::setLocale("ar");
        $data['media_gallery'] = [
            UploadedFile::fake()->create('test.mp3', $kilobytes = 5001)
        ];

        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(Media Gallery Item)", "(jpeg,jpg,png)", "هذه هي الأنواع الصالحة لهذا الملف")));
    }

    //Article Update
    public function testArticleUpdateValidateArticleCategoryIdExistsEnglish()
    {
        $data = ["article_category_id" => "1293819283091283091283921321312321"];
        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, "(Article Category ID) values of this field are incorrect");
    }

    public function testArticleUpdateValidateArticleCategoryIdExistsArabic()
    {
        App::setLocale('ar');
        $data = ["article_category_id" => "1293819283091283091283921321312321"];
        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, sprintf("%s %s", "(Article Category ID)", convert_arabic_to_unicode("قيم هذا الحقل غير صحيحة")));
    }

    public function testArticleUpdateValidateTitleArrayEnglish()
    {
        $data = ["title" => "qwewqe"];
        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, "(title) field format is incorrect");
    }

    public function testArticleUpdateValidateTitleArrayArabic()
    {
        App::setLocale('ar');
        $data = ["title" => "qwewqe"];
        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("(title) تنسيق هذا الحقل غير سليم"));
    }

    public function testArticleUpdateValidateTitleAllowedLocalesEnglish()
    {
        $title = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $data =  ["title" => $title];

        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, "allowed languages for this field (title) (en,ar)");
    }

    public function testArticleUpdateValidateTitleAllowedLocalesArabic()
    {
        App::setLocale('ar');
        $title = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $data =  ["title" => $title];

        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("اللغات المسموح بها لهذا الحقل (title) (en,ar)"));
    }

    public function testArticleUpdateValidateDescriptionArrayEnglish()
    {
        $data = ["description" => "qwewqe"];
        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, "(description) field format is incorrect");
    }

    public function testArticleUpdateValidateDescriptionArrayArabic()
    {
        App::setLocale('ar');
        $data = ["description" => "qwewqe"];
        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("(description) تنسيق هذا الحقل غير سليم"));
    }

    public function testArticleUpdateValidateDescriptionAllowedLocalesEnglish()
    {
        $description = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $data =  ["description" => $description];

        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, "allowed languages for this field (description) (en,ar)");
    }

    public function testArticleUpdateValidateDescriptionAllowedLocalesArabic()
    {
        App::setLocale('ar');
        $description = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $data =  ["description" => $description];

        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("اللغات المسموح بها لهذا الحقل (description) (en,ar)"));
    }

    public function testArticleUpdateValidateShortDescriptionArrayEnglish()
    {
        $data = ["short_description" => "qwewqe"];
        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, "(short_description) field format is incorrect");
    }

    public function testArticleUpdateValidateShortDescriptionArrayArabic()
    {
        App::setLocale('ar');
        $data = ["short_description" => "qwewqe"];
        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("(short_description) تنسيق هذا الحقل غير سليم"));
    }

    public function testArticleUpdateValidateShortDescriptionAllowedLocalesEnglish()
    {
        $short_description = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $data =  ["short_description" => $short_description];

        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, "allowed languages for this field (short_description) (en,ar)");
    }

    public function testArticleUpdateValidateShortDescriptionAllowedLocalesArabic()
    {
        App::setLocale('ar');
        $short_description = [
            "en" => "english test",
            "es" => "espanol test",
            "ta" => "tamil test"
        ];

        $data =  ["short_description" => $short_description];

        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, convert_arabic_to_unicode("اللغات المسموح بها لهذا الحقل (short_description) (en,ar)"));
    }

    public function testArticleUpdateValidatePhotoSizeEnglish()
    {
        $data['photo'] = UploadedFile::fake()->create('test.png', $kilobytes = 5001);

        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, "(photo) (5000) is maximum size for this file");
    }

    public function testArticleUpdateValidatePhotoSizeArabic()
    {
        App::setLocale("ar");
        $data['photo'] = UploadedFile::fake()->create('test.png', $kilobytes = 5001);

        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(photo)", "(5000)", "هذا هو الحجم الأقصى لهذا الملف")));
    }

    public function testArticleUpdateValidatePhotoTypeEnglish()
    {
        $data['photo'] = UploadedFile::fake()->create('test.mp3', $kilobytes = 5001);

        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, "(photo) (jpeg,jpg,png) are the valid types for this file");
    }

    public function testArticleUpdateValidatePhotoTypeArabic()
    {
        App::setLocale("ar");
        $data['photo'] = UploadedFile::fake()->create('test.mp4', $kilobytes = 5001);

        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(photo)", "(jpeg,jpg,png)", "هذه هي الأنواع الصالحة لهذا الملف")));
    }

    public function testArticleUpdateValidateActiveBooleanEnglish()
    {
        $data = ["active" => 4];
        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, "(active) (0,1) are the valid values for this field");
    }

    public function testArticleUpdateValidateActiveBooleanArabic()
    {
        App::setLocale("ar");
        $data = ["active" => 4];
        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(active)", "(0,1)", "هذه المعايير هي المسموح بها لحذ الحقل")));
    }

    public function testArticleUpdateValidateTagIdsArrayEnglish()
    {
        $data = ["tag_ids" => "123123"];
        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, "(Tag IDs) field format is incorrect");
    }

    public function testArticleUpdateValidateTagIdsArrayArabic()
    {
        App::setLocale("ar");
        $data = ["tag_ids" => "123123"];
        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, sprintf("%s %s", "(Tag IDs)", convert_arabic_to_unicode("تنسيق هذا الحقل غير سليم")));
    }

    public function testArticleUpdateValidateTagIdsIncorrectEnglish()
    {
        $data = ["tag_ids" => [59595955,292929,29292299090]];
        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, "(Tag IDs) values of this field are incorrect");
    }

    public function testArticleUpdateValidateTagIdsIncorrectArabic()
    {
        App::setLocale("ar");
        $data = ["tag_ids" => [59595955,292929,29292299090]];
        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, sprintf("%s %s", "(Tag IDs)", convert_arabic_to_unicode("قيم هذا الحقل غير صحيحة")));
    }

    public function testArticleUpdateValidateMediaGalleryArrayEnglish()
    {
        $data = ["media_gallery" => "123123"];
        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, "(Media Gallery Item) field format is incorrect");
    }

    public function testArticleUpdateValidateMediaGalleryArrayArabic()
    {
        App::setLocale("ar");
        $data = ["media_gallery" => "123123"];
        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, sprintf("%s %s", "(Media Gallery Item)", convert_arabic_to_unicode("تنسيق هذا الحقل غير سليم")));
    }

    public function testArticleUpdateValidateMediaGalleryItemSizeEnglish()
    {
        $data['media_gallery'] = [
            UploadedFile::fake()->create('test.png', $kilobytes = 5001)
        ];

        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, "(Media Gallery Item) (5000) is maximum size for this file");
    }

    public function testArticleUpdateValidateMediaGalleryItemSizeArabic()
    {
        App::setLocale("ar");
        $data['media_gallery'] = [
            UploadedFile::fake()->create('test.png', $kilobytes = 5001)
        ];

        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(Media Gallery Item)", "(5000)", "هذا هو الحجم الأقصى لهذا الملف")));
    }

    public function testArticleUpdateValidateMediaGalleryItemTypeEnglish()
    {
        $data['media_gallery'] = [
            UploadedFile::fake()->create('test.mp3', $kilobytes = 5001)
        ];

        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, "(Media Gallery Item) (jpeg,jpg,png) are the valid types for this file");
    }

    public function testArticleUpdateValidateMediaGalleryItemTypeArabic()
    {
        App::setLocale("ar");
        $data['media_gallery'] = [
            UploadedFile::fake()->create('test.mp3', $kilobytes = 5001)
        ];

        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        assertDataHasError($response, convert_arabic_to_unicode(sprintf("%s %s %s", "(Media Gallery Item)", "(jpeg,jpg,png)", "هذه هي الأنواع الصالحة لهذا الملف")));
    }
}
