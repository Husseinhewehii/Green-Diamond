<?php
namespace Tests\Feature\Admin\Partition;

use App\Constants\Media_Collections;
use App\Models\Partition;
use App\Models\User;
use Database\Seeders\StaticContentSeeder;
use Database\Seeders\SuperAdminSeeder;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Database\Seeders\RolesAndPermissionsTestingSeeder;
use App\Models\SystemRole as Role;
use Database\Seeders\PartitionSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;

trait PartitionTestingTrait{
    protected $superAdmin;
    protected $firstPartition;
    protected $allPartitions;

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
        Partition::whereNotNull('id')->delete();
        App::setlocale($locale);
        $this->seed(PartitionSeeder::class);

        $this->firstPartition = Partition::first();
        $this->firstPartition->addMedia(UploadedFile::fake()->create('test.png', $kilobytes = 5000))->toMediaCollection(Media_Collections::PARTITION);
        $this->allPartitions = Partition::all();
        $this->allPartitionsInFormat = $this->allPartitions->map(fn($partition) => $this->partitionResponseDataFormat($partition));
    }

    protected function partitionPayload($passedData = []){
        $data = [
            'title' => [
                "en" => "pepsi",
                "ar" => "بيبسي"
            ],
            'sub_title' => [
                "en" => "pepsi subt title",
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
        ];
        return array_merge($data, $passedData);
    }

    protected function partitionResponseData($locale, $passedData = []){
        $data = [
            'active' => $this->partitionPayload()['active'],
            'title' => $this->partitionPayload()['title'][$locale],
            'sub_title' => $this->partitionPayload()['sub_title'][$locale],
            'description' => $this->partitionPayload()['description'][$locale],
            'short_description' => $this->partitionPayload()['short_description'][$locale],
        ];
        return array_merge($data, $passedData);
    }

    public function partitionResponseDataFormat($partition, $withTranslatables = false)
    {
        return [
            'id' => $partition->id,
            'group' => $partition->group,
            'key' => $partition->key,
            'title' => $withTranslatables ? $partition->titleTranslatables : $partition->title,
            'sub_title' => $withTranslatables ? $partition->sub_titleTranslatables : $partition->sub_title,
            'description' => $withTranslatables ? $partition->descriptionTranslatables : $partition->description,
            'short_description' => $withTranslatables ? $partition->short_descriptionTranslatables : $partition->short_description,
            'photo' => $partition->getFirstMediaUrl(Media_Collections::PARTITION),
            'active' => $partition->active,
        ];
    }
}
