<?php
namespace Tests\Feature\Admin\Role;


use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\StaticContentSeeder;
use Database\Seeders\SuperAdminSeeder;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use App\Models\SystemRole as Role;
use Database\Seeders\RolesAndPermissionsTestingSeeder;

trait RoleTestingTrait{
    protected $superAdmin;
    protected $firstRole;
    protected $lastRole;
    protected $allRoles;

    public function setUp() : void
    {
        parent::setUp();
        $this->seed(StaticContentSeeder::class);

        $this->seed(SuperAdminSeeder::class);
        $this->superAdmin = User::whereEmail('super@admin.com')->first();

        Artisan::call('passport:install');
        Passport::actingAs($this->superAdmin);

        $this->seed(RolesAndPermissionsTestingSeeder::class);
        $this->firstRole = Role::where('name', 'super-admin')->first();
        $this->superAdmin->assignRole($this->firstRole);

        $this->lastRole = Role::factory()->create();
        $this->allRoles = Role::all();

        $this->allRolesInFormat = $this->allRoles->map(fn($role) => $this->roleFormat($role));
    }

    protected function rolePayLoad($passedData = []){
        $data = [
            'name' => "role name",
            'active' => 1,
        ];
        return array_merge($data, $passedData);
    }

    public function roleFormat($role)
    {
        return [
            'id' => $role->id,
            'name' => $role->name,
            'active' => $role->active
        ];
    }
}
