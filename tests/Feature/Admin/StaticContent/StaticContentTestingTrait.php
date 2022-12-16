<?php
namespace Tests\Feature\Admin\StaticContent;

use App\Models\StaticContent;
use App\Models\User;

use Database\Seeders\StaticContentSeeder;
use Database\Seeders\SuperAdminSeeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use App\Models\SystemRole as Role;
use Database\Seeders\RolesAndPermissionsTestingSeeder;

trait StaticContentTestingTrait{

    protected $staticContents;
    protected $firstStaticContent;
    protected $payLoadStaticContent;
    protected $updateUrl;
    protected $superAdmin;

    public function setUp() : void
    {
        parent::setUp();

        $this->seed(StaticContentSeeder::class);
        $this->staticContents = StaticContent::all();
        $this->firstStaticContent = $this->staticContents[0];

        $this->seed(SuperAdminSeeder::class);
        $this->superAdmin = User::whereEmail('super@admin.com')->first();

        Artisan::call('passport:install');
        Passport::actingAs($this->superAdmin);

        $this->seed(RolesAndPermissionsTestingSeeder::class);
        $role = Role::where('name', 'super-admin')->first();
        $this->superAdmin->assignRole($role);

        $this->payLoadStaticContent = [
            'text' => [
                "en" => "first firstStaticContent english",
                "ar" => "first firstStaticContent arabic"
            ]
        ];

        $this->updateUrl = 'api/admin/static-content/'.$this->firstStaticContent->id;
    }

    protected function staticContentPayLoad($passedData = []){
        $data = $this->payLoadStaticContent;
        return array_merge($data, $passedData);
    }


    public function staticContentFormat()
    {
        $englishText = $this->firstStaticContent->text;
        App::setLocale('ar');
        $arabicText = $this->firstStaticContent->text;

        return [
            'id' => $this->firstStaticContent->id,
            'key' => $this->firstStaticContent->key,
            'text' => [
                'en' => $englishText,
                'ar' => $arabicText,
            ]
        ];
    }
}
