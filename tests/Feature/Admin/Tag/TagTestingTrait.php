<?php
namespace Tests\Feature\Admin\Tag;

use App\Constants\Media_Collections;
use App\Models\Tag;
use App\Models\User;
use Database\Seeders\StaticContentSeeder;
use Database\Seeders\SuperAdminSeeder;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Database\Seeders\RolesAndPermissionsTestingSeeder;
use App\Models\SystemRole as Role;
use Illuminate\Support\Facades\App;

trait TagTestingTrait{
    protected $superAdmin;
    protected $allTags;
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
        Tag::whereNotNull('id')->delete();
        App::setlocale($locale);
        $this->firstTag = Tag::factory()->create();
        $this->allTags = Tag::all();
        $this->allTagsInFormat = $this->allTags->map(fn($tag) => assertTagResponseDataFormat($tag));
    }

    protected function tagPayload($passedData = []){
        $data = [
            'name' => [
                "en" => "english tag name",
                "ar" => "arabic tag name"
            ],
            'active' => 1,
        ];
        return array_merge($data, $passedData);
    }

    protected function tagResponseData($locale, $passedData = []){
        $data = [
            'name' => $this->tagPayload()['name'][$locale],
            'active' => $this->tagPayload()['active'],
        ];
        return array_merge($data, $passedData);
    }
}
