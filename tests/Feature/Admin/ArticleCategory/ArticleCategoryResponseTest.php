<?php

namespace Tests\Feature\Admin\ArticleCategory;

use App\Models\ArticleCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class ArticleCategoryResponseTest extends TestCase
{
    use RefreshDatabase, ArticleCategoryTestingTrait;

    public function testArticleCategoryIndexCode200WithFormat()
    {
        $response = $this->get('/api/admin/articleCategories');
        $response->assertOk();
        $response->assertJson(assertPaginationFormat($this->allArticleCategoriesInFormat->toArray()));
        // $this->assertTrue(assertCheckPaginatedResponseHasPhotoLink($response, 0));
    }

    public function testArticleCategoryStoreCode201WithFormatPlusEmptyParentIdEnglish()
    {
        $data = [
            "parent_id" => " "
        ];
        $response = $this->post('/api/admin/articleCategories', $this->articleCategoryPayload($data));
        $response->assertCreated();
        $response->assertJson(assertCreatedPaginationFormat([...$this->allArticleCategoriesInFormat, $this->articleCategoryResponseData("en")]));
        // $this->assertTrue(assertCheckPaginatedResponseHasPhotoLink($response, 1));
    }

    public function testArticleCategoryStoreCode201WithFormatEnglish()
    {
        $response = $this->post('/api/admin/articleCategories', $this->articleCategoryPayload());
        $response->assertCreated();
        $response->assertJson(assertCreatedPaginationFormat([...$this->allArticleCategoriesInFormat, $this->articleCategoryResponseData("en")]));
        // $this->assertTrue(assertCheckPaginatedResponseHasPhotoLink($response, 1));
    }

    public function testArticleCategoryStoreCode201WithFormatArabic()
    {
        $this->preCreateRecords("ar");
        $response = $this->post('/api/admin/articleCategories', $this->articleCategoryPayload());
        $response->assertCreated();
        $response->assertJson(assertCreatedPaginationFormat([...$this->allArticleCategoriesInFormat, $this->articleCategoryResponseData("ar")]));
        // $this->assertTrue(assertCheckPaginatedResponseHasPhotoLink($response, 1));
    }

    public function testArticleCategoryStoreCode201WithFormatPlusChildrenEnglish()
    {
        $data = ['parent_id' => $this->firstArticleCategory->id];
        $response = $this->post('/api/admin/articleCategories', $this->articleCategoryPayload($data));
        $response->assertCreated();

        $firstArticleCategory = ArticleCategory::where('id',$this->firstArticleCategory->id)->with('articleCategorychildren')->first();
        $response->assertJson(assertCreatedPaginationFormat([$this->articleCategoryResponseDataFormat($firstArticleCategory), $this->articleCategoryResponseData("en", $data)]));

        // $this->assertTrue(assertCheckPaginatedResponseHasPhotoLink($response, 1));
    }

    public function testArticleCategoryUpdateCode200PlusEmptyParentIdEnglish()
    {
        $data = [
            "parent_id" => null
        ];

        $response = $this->put('/api/admin/articleCategories/'.$this->firstArticleCategory->id, $this->articleCategoryPayload($data));
        $response->assertOk();
    }

    public function testArticleCategoryUpdateCode200WithFormatEnglish()
    {
        $data['title'] = ["en" => "english title udpate"];
        $data['type'] = $this->firstArticleCategory->type;

        $response = $this->put('/api/admin/articleCategories/'.$this->firstArticleCategory->id, $this->articleCategoryPayload($data));
        $response->assertOk();

        $data['title'] = $data['title']["en"];
        $response->assertJson(assertPaginationFormat([$this->articleCategoryResponseData("en", $data)]));
        // $this->assertTrue(assertCheckPaginatedResponseHasPhotoLink($response, 0));
    }

    public function testArticleCategoryUpdateCode200WithFormatArabic()
    {
        $this->preCreateRecords("ar");

        $data['title'] = ["ar" => "arabic title udpate"];
        $data['type'] = $this->firstArticleCategory->type;

        $response = $this->put('/api/admin/articleCategories/'.$this->firstArticleCategory->id, $this->articleCategoryPayload($data));
        $response->assertOk();

        $data['title'] = $data['title']["ar"];
        $response->assertJson(assertPaginationFormat([$this->articleCategoryResponseData("ar", $data)]));
        // $this->assertTrue(assertCheckPaginatedResponseHasPhotoLink($response, 0));
    }

    public function testArticleCategoryShowCode200WithFormat()
    {
        $response = $this->get('/api/admin/articleCategories/'.$this->firstArticleCategory->id);
        $response->assertOk();
        $response->assertJson(assertDataContent($this->articleCategoryResponseDataFormat($this->firstArticleCategory, true)));
        // $this->assertTrue(assertCheckResponseHasPhotoLink($response));
    }

    public function testArticleCategoryDeleteCode200WithFormat()
    {
        $response = $this->delete('/api/admin/articleCategories/'.$this->firstArticleCategory->id);
        $response->assertOk();
        $response->assertJson(assertPaginationFormat());
    }

    public function testArticleCategoryShowNotFoundCode404WithFormat()
    {
        $response = $this->get('/api/admin/articleCategories/'."123213213213");
        $response->assertNotFound();
        $response->assertJson(assertNotFoundFormat());
    }
}
