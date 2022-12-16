<?php

namespace Tests\Feature\Admin\Employee;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeSortTest extends TestCase
{
    use RefreshDatabase, EmployeeTestingTrait;

    public function testEmployeeIndexSortName()
    {
        $response = $this->get("/api/admin/employees?sort=name");
        $response_employees = json_decode($response->content())->data->data;
        $first_employee_sorted_by_name = Employee::orderBy('name')->first("name")->name;
        $this->assertEquals($response_employees[0]->name, $first_employee_sorted_by_name);
    }

    // public function testEmployeeIndexSortEmail()
    // {
    //     $response = $this->get("/api/admin/employees?sort=email");
    //     $response_employees = json_decode($response->content())->data->data;
    //     $first_employee_sorted_by_email = Employee::orderBy('email')->first("email")->email;
    //     $this->assertEquals($response_employees[0]->email, $first_employee_sorted_by_email);
    // }

    // public function testEmployeeIndexSortPhone()
    // {
    //     $response = $this->get("/api/admin/employees?sort=phone");
    //     $response_employees = json_decode($response->content())->data->data;
    //     $first_employee_sorted_by_phone = Employee::orderBy('phone')->first("phone")->phone;
    //     $this->assertEquals($response_employees[0]->phone, $first_employee_sorted_by_phone);
    // }

    public function testEmployeeIndexSortType()
    {
        $response = $this->get("/api/admin/employees?sort=type");
        $response_employees = json_decode($response->content())->data->data;
        $first_employee_sorted_by_type = Employee::orderBy('type')->first("type")->type;
        $this->assertEquals($response_employees[0]->type, $first_employee_sorted_by_type);
    }

    public function testEmployeeIndexSortActive()
    {
        $response = $this->get("/api/admin/employees?sort=active");
        $response_employees = json_decode($response->content())->data->data;
        $first_employee_sorted_by_active = Employee::orderBy('active')->first("active")->active;
        $this->assertEquals($response_employees[0]->active, $first_employee_sorted_by_active);
    }

    public function testEmployeeIndexSortDescription()
    {
        $response = $this->get("/api/admin/employees?sort=description");
        $response_employees = json_decode($response->content())->data->data;
        $first_employee_sorted_by_description = Employee::orderBy('description')->first("description")->description;
        $this->assertEquals($response_employees[0]->description, $first_employee_sorted_by_description);
    }
}
