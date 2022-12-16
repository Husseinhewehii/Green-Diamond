<?php
namespace Tests\Feature\Admin\Employee;

use App\Constants\EmployeeTypes;
use App\Constants\Media_Collections;
use App\Models\Employee;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\StaticContentSeeder;
use Database\Seeders\SuperAdminSeeder;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Database\Seeders\RolesAndPermissionsTestingSeeder;
use App\Models\SystemRole as Role;
use Illuminate\Http\UploadedFile;

trait EmployeeTestingTrait{
    protected $superAdmin;
    protected $allEmployees;
    protected $firstEmployee;

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

        $this->firstEmployee = Employee::factory()->create();
        $this->firstEmployee->addMedia(UploadedFile::fake()->create('test.png', $kilobytes = 5000))->toMediaCollection(Media_Collections::EMPLOYEE);
        $this->allEmployees = Employee::all();
        $this->allEmployeesInFormat = $this->allEmployees->map(fn($employee) => $this->EmployeeFormat($employee));
    }

    protected function employeePayload($passedData = []){
        $data = [
            'name' => "hussien",
            'type' => "1",
            "description" => [
                "en" => "english description",
                "ar" => "arabic description"
            ],
            'position' => [
                "en" => "english positon",
                "ar" => "arabic psition"
            ],
            // 'email' => "hussein@techlead.com",
            // 'phone' => "0321456654",
            // 'social_media' => [
            //     "https://www.linkedin.com/notifications/",
            //     "https://www.facebook.com/",
            // ],
            'active' => 1
        ];
        return array_merge($data, $passedData);
    }

    public function employeeFormat($employee)
    {
        return [
            'id' => $employee->id,
            'name' => $employee->name,
            // 'email' => $employee->email,
            // 'phone' => $employee->phone,
            // 'social_media' => $employee->social_media,
            'type' => $employee->type,
            'description' => $employee->description,
            'position' => $employee->position,
            'photo' => $employee->getFirstMediaUrl(Media_Collections::EMPLOYEE),
            'active' => $employee->active
        ];
    }
}
