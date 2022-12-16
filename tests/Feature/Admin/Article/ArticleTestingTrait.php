<?php
namespace Tests\Feature\Admin\Article;

use App\Constants\Media_Collections;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\User;
use Database\Seeders\StaticContentSeeder;
use Database\Seeders\SuperAdminSeeder;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Database\Seeders\RolesAndPermissionsTestingSeeder;
use App\Models\SystemRole as Role;
use App\Models\Tag;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;

trait ArticleTestingTrait{
    protected $superAdmin;
    protected $firstArticleCategory;
    protected $allArticles;
    protected $firstArticle;
    protected $firstTag;

    public function setUp() : void
    {
        parent::setUp();
        $this->seed(StaticContentSeeder::class);

        $this->seed(SuperAdminSeeder::class);
        $this->superAdmin = User::whereEmail('super@admin.com')->first();

        Artisan::call('passport:install');
        Passport::actingAs($this->superAdmin);

        $this->seed(RolesAndPermissionsTestingSeeder::class);
        $superAdminRole = Role::where('name', 'super-admin')->first();
        $this->superAdmin->assignRole($superAdminRole);
        $this->preCreateRecords();

    }
    protected function preCreateRecords($locale = "en"){
        Article::whereNotNull('id')->delete();
        App::setlocale($locale);
        $this->firstArticleCategory = ArticleCategory::factory()->create();
        $this->firstArticle = Article::factory()->create();
        $this->firstTag = Tag::factory()->create();
        $this->firstArticle->addMedia(UploadedFile::fake()->create('test.png', $kilobytes = 5000))->toMediaCollection(Media_Collections::ARTICLE);
        $this->allArticles = Article::all();
        $this->allArticlesInFormat = $this->allArticles->map(fn($article) => $this->articleResponseDataFormat($article));
    }

    protected function articlePayload($passedData = []){
        $data = [
            "article_category_id" => $this->firstArticleCategory->id,
            'title' => [
                "en" => "pepsi",
                "ar" => "بيبسي"
            ],
            'description' => [
                "en" => "black soda drink",
                "ar" => "مشروب الصودا السوداء"
            ],
            'short_description' => [
                "en" => "soda",
                "ar" => "صودا"
            ],
            'active' => 1,
            'photo' => UploadedFile::fake()->create('test.png', $kilobytes = 5000),
            'tag_ids' => [$this->firstTag->id],
        ];
        return array_merge($data, $passedData);
    }

    protected function articleResponseData($locale, $passedData = []){
        $data = [
            'article_category_id' => $this->articlePayload()['article_category_id'],
            'active' => $this->articlePayload()['active'],
            'title' => $this->articlePayload()['title'][$locale],
            'description' => $this->articlePayload()['description'][$locale],
            'short_description' => $this->articlePayload()['short_description'][$locale],
        ];
        return array_merge($data, $passedData);
    }

    public function articleResponseDataFormat($article, $withTranslatables = false, $withTags = false, $withMedia = false)
    {
        $articleTags = [];
        if($withTags){
            $firstTag = $article->tags->toArray()[0];
            $firstTagEloquent = Tag::find($firstTag['id']);
            $articleTags = [
                assertTagResponseDataFormat($firstTagEloquent, $withTranslatables)
            ];
        }

        $mediaGallery = [];
        if($withMedia){
            $firstMedia = $article->getMedia(Media_Collections::ARTICLE_GALLERY)->toArray()[0];
            $mediaGallery = [
                assertMediaGalleryItemFormat($firstMedia)
            ];
        }

        return [
            'id' => $article->id,
            'article_category_id' => $article->article_category_id,
            'title' => $withTranslatables ? $article->titleTranslatables : $article->title,
            'description' => $withTranslatables ? $article->descriptionTranslatables : $article->description,
            'short_description' => $withTranslatables ? $article->short_descriptionTranslatables : $article->short_description,
            'photo' => $article->getFirstMediaUrl(Media_Collections::ARTICLE),
            'active' => $article->active,
            'tags' => $articleTags,
            "media_gallery" => $mediaGallery
        ];
    }
}
