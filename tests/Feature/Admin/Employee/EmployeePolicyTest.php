<?php

namespace Tests\Feature\Admin\Employee;

use App\Models\Employee;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsTestingSeeder;
use Database\Seeders\StaticContentSeeder;
use Database\Seeders\SuperAdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\TestCase;

class EmployeePolicyTest extends TestCase
{
    use RefreshDatabase;

    protected $superAdmin;
    protected $firstEmployee;

    public function setUp() : void
    {
        parent::setUp();
        $this->seed(SuperAdminSeeder::class);
        $this->seed(StaticContentSeeder::class);
        $this->superAdmin = User::whereEmail('super@admin.com')->first();

        $this->firstEmployee = Employee::factory()->create();

        Artisan::call('passport:install');
        Passport::actingAs($this->superAdmin);
        $this->seed(RolesAndPermissionsTestingSeeder::class);
    }

    protected function employeePayload($passedData = []){
        $data = [
            'name' => "hussien",
            'type' => "1",
            'description' => "leads backend",
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

    public function testEmployeeIndexCode403WithFormat()
    {
        $response = $this->get('/api/admin/employees');
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }

    public function testEmployeeStoreCode403WithFormat()
    {
        $response = $this->post('/api/admin/employees', $this->employeePayload());
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }

    public function testEmployeeUpdateCode403WithFormat()
    {
        $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayload());
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }

    public function testEmployeeShowCode403WithFormat()
    {
        $response = $this->get('/api/admin/employees/'.$this->firstEmployee->id);
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }

    public function testEmployeeDeleteCode403WithFormat()
    {
        $response = $this->delete('/api/admin/employees/'.$this->firstEmployee->id);
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }
}
