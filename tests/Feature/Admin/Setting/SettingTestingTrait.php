<?php
namespace Tests\Feature\Admin\Setting;

use App\Models\Setting;
use App\Models\User;
use Database\Seeders\SettingSeeder;
use Database\Seeders\StaticContentSeeder;
use Database\Seeders\SuperAdminSeeder;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use App\Models\SystemRole as Role;
use Database\Seeders\RolesAndPermissionsTestingSeeder;

trait SettingTestingTrait{
    protected $superAdmin;
    protected $firstSetting;
    protected $settings;
    protected $updateUrl;

    public function setUp() : void
    {
        parent::setUp();
        $this->seed(StaticContentSeeder::class);

        $this->seed(SettingSeeder::class);
        $this->settings = Setting::all();
        $this->firstSetting = Setting::first();

        $this->seed(SuperAdminSeeder::class);
        $this->superAdmin = User::whereEmail('super@admin.com')->first();

        Artisan::call('passport:install');
        Passport::actingAs($this->superAdmin);

        $this->seed(RolesAndPermissionsTestingSeeder::class);
        $role = Role::where('name', 'super-admin')->first();
        $this->superAdmin->assignRole($role);

        $this->updateUrl = '/api/admin/settings/'.$this->firstSetting->id;
    }

    protected function settingPayLoad($passedData = []){
        $data = [
            'value' => "abc",
        ];
        return array_merge($data, $passedData);
    }

    public function settingFormat()
    {
        return [
            'id' => $this->firstSetting->id,
            'key' => $this->firstSetting->key,
            'value' => $this->firstSetting->value
        ];
    }
}
