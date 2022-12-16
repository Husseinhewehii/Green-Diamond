<?php

namespace Tests\Feature\Admin\Article;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ArticleResponseTest extends TestCase
{
    use RefreshDatabase, ArticleTestingTrait;

    public function testArticleIndexCode200WithFormat()
    {
        $response = $this->get('/api/admin/articles');
        $response->assertOk();
        $response->assertJson(assertPaginationFormat($this->allArticlesInFormat->toArray()));
        $response->assertJsonStructure([
            'status_code' ,
            'message',
            'data'=>[
                'data' => [
                    [
                        'id',
                        'article_category_id',
                        'title',
                        'description',
                        'short_description',
                        'photo',
                        'active',
                        'tags',
                        'media_gallery',
                    ]
                ],
            ]
            
        ]);
        $this->assertTrue(assertCheckPaginatedResponseHasPhotoLink($response, 0));
    }

    public function testArticleStoreCode201WithFormatEnglishPlusTagsAndMediaGallery()
    {
        $data['media_gallery'] = [
            UploadedFile::fake()->create('test.png', $kilobytes = 3000),
        ];

        $response = $this->post('/api/admin/articles', $this->articlePayload($data));
        $response->assertCreated();

        $lastArticle = Article::orderBy('id', 'desc')->first();
        $response->assertJson(assertCreatedPaginationFormat(
        [
            $this->articleResponseDataFormat($this->firstArticle),
            $this->articleResponseDataFormat($lastArticle, false, true, true)
        ]));

        $this->assertTrue(assertCheckPaginatedResponseHasPhotoLink($response, 1));
    }

    public function testArticleStoreCode201WithFormatArabicPlusTags()
    {
        $this->preCreateRecords("ar");
        $response = $this->post('/api/admin/articles', $this->articlePayload());
        $response->assertCreated();

        $response->assertJson(assertCreatedPaginationFormat([...$this->allArticlesInFormat, $this->articleResponseData("ar")]));

        $lastArticle = Article::orderBy('id', 'desc')->first();
        $response->assertJson(assertCreatedPaginationFormat([$this->articleResponseDataFormat($this->firstArticle), $this->articleResponseDataFormat($lastArticle)]));

        $this->assertTrue(assertCheckPaginatedResponseHasPhotoLink($response, 1));
    }

    public function testArticleUpdateCode200WithFormatPlusTagsEnglishAndMediaGallery()
    {
        $payloadData['title'] = ["en" => "english title udpate"];
        $payloadData['description'] = ["en" => "english description udpate"];
        $payloadData['short_description'] = ["en" => "english short_description udpate"];
        $payloadData['media_gallery'] = [
            UploadedFile::fake()->create('test.png', $kilobytes = 3000),
        ];

        $newTag = Tag::factory()->create();
        $payloadData['tag_ids'] = [$newTag->id];

        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($payloadData));
        $response->assertOk();

        $responseData['title'] = $payloadData['title']["en"];
        $responseData['description'] = $payloadData['description']["en"];
        $responseData['short_description'] = $payloadData['short_description']["en"];
        $responseData['tags'] = [
            assertTagResponseDataFormat($newTag)
        ];

        $firstArticleRefetched = Article::find($this->firstArticle->id);
        $response->assertJson(assertPaginationFormat(
        [
            $this->articleResponseDataFormat($firstArticleRefetched, false, true, true)
        ]));
        $this->assertTrue(assertCheckPaginatedResponseHasPhotoLink($response, 0));
    }

    public function testArticleUpdateCode200WithFormatArabic()
    {
        $this->preCreateRecords("ar");

        $data['title'] = ["ar" => "arabic title udpate"];
        $data['description'] = ["ar" => "arabic description udpate"];
        $data['short_description'] = ["ar" => "arabic short_description udpate"];

        $response = $this->put('/api/admin/articles/'.$this->firstArticle->id, $this->articlePayload($data));
        $response->assertOk();

        $data['title'] = $data['title']["ar"];
        $data['description'] = $data['description']["ar"];
        $data['short_description'] = $data['short_description']["ar"];

        $response->assertJson(assertPaginationFormat([$this->articleResponseData("ar", $data)]));
        $this->assertTrue(assertCheckPaginatedResponseHasPhotoLink($response, 0));
    }

    public function testArticleShowCode200WithFormat()
    {
        $response = $this->get('/api/admin/articles/'.$this->firstArticle->id);
        $response->assertOk();
        $response->assertJson(assertDataContent($this->articleResponseDataFormat($this->firstArticle, $withTranslatables = true)));
        $this->assertTrue(assertCheckResponseHasPhotoLink($response));
    }

    public function testArticleDeleteCode200WithFormat()
    {
        $response = $this->delete('/api/admin/articles/'.$this->firstArticle->id);
        $response->assertOk();
        $response->assertJson(assertPaginationFormat());
    }

    public function testArticleShowNotFoundCode404WithFormat()
    {
        $response = $this->get('/api/admin/articles/'."123213213213");
        $response->assertNotFound();
        $response->assertJson(assertNotFoundFormat());
    }
}
