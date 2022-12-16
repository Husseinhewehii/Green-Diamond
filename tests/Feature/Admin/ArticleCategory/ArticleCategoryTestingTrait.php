<?php
namespace Tests\Feature\Admin\ArticleCategory;

use App\Constants\Media_Collections;
use App\Http\Resources\ArticleCategory\ArticleCategoryResource;
use App\Models\ArticleCategory;
use App\Models\User;
use Database\Seeders\StaticContentSeeder;
use Database\Seeders\SuperAdminSeeder;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Database\Seeders\RolesAndPermissionsTestingSeeder;
use App\Models\SystemRole as Role;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;

trait ArticleCategoryTestingTrait{
    protected $superAdmin;
    protected $allArticleCategorys;
    protected $firstArticleCategory;

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
        ArticleCategory::whereNotNull('id')->delete();
        App::setlocale($locale);
        $this->firstArticleCategory = ArticleCategory::factory()->create();
        // $this->firstArticleCategory->addMedia(UploadedFile::fake()->create('test.png', $kilobytes = 5000))->toMediaCollection(Media_Collections::ARTICLE_CATEGORY);
        $this->allArticleCategories = ArticleCategory::all();
        $this->allArticleCategoriesInFormat = $this->allArticleCategories->map(fn($articleCategory) => $this->articleCategoryResponseDataFormat($articleCategory));
    }

    protected function articleCategoryPayload($passedData = []){
        $data = [
            'title' => [
                "en" => "beverages",
                "ar" => "مشاريب"
            ],
            'type' => 1,
            'active' => 1,
            // 'photo' => UploadedFile::fake()->create('test.png', $kilobytes = 5000),
        ];
        return array_merge($data, $passedData);
    }

    protected function articleCategoryResponseData($locale, $passedData = []){
        $data = [
            'title' => $this->articleCategoryPayload()['title'][$locale],
            'type' => $this->articleCategoryPayload()['type'],
            'active' => $this->articleCategoryPayload()['active'],
        ];
        return array_merge($data, $passedData);
    }

    public function articleCategoryResponseDataFormat($articleCategory, $withTranslatables = false)
    {
        $articleCategorychildren = [];

        if(count($articleCategory->articleCategorychildren)){
            $firstArticleCategoryChild = $articleCategory->articleCategorychildren->toArray()[0];
            $firstArticleCategoryChildEloquent = ArticleCategory::find($firstArticleCategoryChild['id']);
            $articleCategorychildren = [
                [
                    'id' => $firstArticleCategoryChildEloquent->id,
                    'parent_id' => $firstArticleCategoryChildEloquent->parent_id,
                    'type' => $firstArticleCategoryChildEloquent->type,
                    'title' => $withTranslatables ? $firstArticleCategoryChildEloquent->titleTranslatables : $firstArticleCategoryChildEloquent->title,
                    // 'photo' => $firstArticleCategoryChildEloquent->getFirstMediaUrl(Media_Collections::ARTICLE_CATEGORY),
                    'active' => $firstArticleCategoryChildEloquent->active,
                    "articleCategorychildren" => []
                ]
            ];
        }

        return [
            'id' => $articleCategory->id,
            'parent_id' => $articleCategory->parent_id,
            'type' => $articleCategory->type,
            'title' => $withTranslatables ? $articleCategory->titleTranslatables : $articleCategory->title,
            // 'photo' => $articleCategory->getFirstMediaUrl(Media_Collections::ARTICLE_CATEGORY),
            'active' => $articleCategory->active,
            "articleCategorychildren" => $articleCategorychildren
        ];
    }
}
