<?php
namespace Tests\Feature\Admin\User;

use Database\Seeders\StaticContentSeeder;
use Database\Seeders\SuperAdminSeeder;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use App\Models\SystemRole as Role;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsTestingSeeder;

trait UserTestingTrait{
    protected $superAdmin;
    protected $admin;
    protected $allUsers;
    protected $allUsersInFormat;

    public function setUp() : void
    {
        parent::setUp();
        $this->seed(StaticContentSeeder::class);

        $this->seed(SuperAdminSeeder::class);
        $this->superAdmin = User::whereEmail('super@admin.com')->first();
        $this->admin = User::factory()->create();
        $this->allUsers = User::all();
        $this->allUsersInFormat = $this->allUsers->map(fn($user) => $this->userFormat($user));

        Artisan::call('passport:install');
        Passport::actingAs($this->superAdmin);

        $this->seed(RolesAndPermissionsTestingSeeder::class);
        $role = Role::where('name', 'super-admin')->first();
        $this->superAdmin->assignRole($role);
    }

    protected function userPayload($passedData = []){
        $data = $this->userData();
        $data['password'] = 'Tes%pas123';
        return array_merge($data, $passedData);
    }

    protected function userData(){
        return [
            "first_name" => "admin first name",
            "last_name" => "admin last name",
            "email" => "admin@email.com",
            "phone" => "0112332122",
            "type" => 2,
            "active" => 1,
        ];
    }

    public function userFormat($user)
    {
        return [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'phone' => $user->phone,
            'type' => $user->type,
            'active' => $user->active
        ];
    }
}
