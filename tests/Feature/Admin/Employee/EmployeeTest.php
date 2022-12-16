<?php

namespace Tests\Feature\Admin\Employee;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase, EmployeeTestingTrait;

    public function testEmployeeSoftDelete(){
        $this->delete('/api/admin/employees/'.$this->firstEmployee->id);
        $this->assertSoftDeleted($this->firstEmployee);
        $this->assertDatabaseCount("employees", count($this->allEmployees));
    }

    public function testEmployeeStoreActivityLog()
    {
        $this->post('/api/admin/employees', $this->employeePayLoad());
        $lastUser = Employee::orderBy('id', 'desc')->first();
        $data = [
            "causer_id" => $this->superAdmin->id,
            "subject_id" => $lastUser->id,
            "subject_type" => get_class($lastUser),
            "description" => "created",
        ];
        $this->assertDatabaseHas('activity_log', $data);
    }

    public function testEmployeeUpdateActivityLog()
    {
        $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayLoad());
        $data = [
            "causer_id" => $this->superAdmin->id,
            "subject_id" => $this->firstEmployee->id,
            "subject_type" => get_class($this->firstEmployee),
            "description" => "updated",
        ];
        $this->assertDatabaseHas('activity_log', $data);
    }

    public function testEmployeeDeleteActivityLog()
    {
        $this->delete('/api/admin/employees/'.$this->firstEmployee->id);
        $data = [
            "causer_id" => $this->superAdmin->id,
            "subject_id" => $this->firstEmployee->id,
            "subject_type" => get_class($this->firstEmployee),
            "description" => "deleted",
        ];
        $this->assertDatabaseHas('activity_log', $data);
    }
}
