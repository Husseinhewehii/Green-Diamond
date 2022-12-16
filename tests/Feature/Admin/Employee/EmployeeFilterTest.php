<?php

namespace Tests\Feature\Admin\Employee;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeFilterTest extends TestCase
{
    use RefreshDatabase, EmployeeTestingTrait;

    public function testEmployeeIndexFilterName()
    {
        $response = $this->get("/api/admin/employees?filter[name]=".$this->firstEmployee->name);
        $response_employees = json_decode($response->content())->data->data;
        $relevant_employees = Employee::where('name', $this->firstEmployee->name)->count();
        $this->assertEquals(count($response_employees), $relevant_employees);
    }

    // public function testEmployeeIndexFilterEmail()
    // {
    //     $response = $this->get("/api/admin/employees?filter[email]=".$this->firstEmployee->email);
    //     $response_employees = json_decode($response->content())->data->data;

    //     $relevant_employees = Employee::where('email', $this->firstEmployee->email)->count();
    //     $this->assertEquals(count($response_employees), $relevant_employees);
    // }

    // public function testEmployeeIndexFilterPhone()
    // {
    //     $response = $this->get("/api/admin/employees?filter[phone]=".$this->firstEmployee->phone);
    //     $response_employees = json_decode($response->content())->data->data;

    //     $relevant_employees = Employee::where('phone', $this->firstEmployee->phone)->count();
    //     $this->assertEquals(count($response_employees), $relevant_employees);
    // }

    public function testEmployeeIndexFilterType()
    {
        $response = $this->get("/api/admin/employees?filter[type]=".$this->firstEmployee->type);
        $response_employees = json_decode($response->content())->data->data;

        $relevant_employees = Employee::where('type', $this->firstEmployee->type)->count();
        $this->assertEquals(count($response_employees), $relevant_employees);
    }

    public function testEmployeeIndexFilterDescriptionTranslatables()
    {
        $response = $this->get("/api/admin/employees?filter[description]=".$this->firstEmployee->description);
        $response_employees = json_decode($response->content(), true)['data']['data'];
        $this->assertTrue(check_item_in_array_collection_contain_string($response_employees, 'description', $this->firstEmployee->description));
    }

    public function testEmployeeIndexFilterActive()
    {
        $response = $this->get("/api/admin/employees?filter[active]=".$this->firstEmployee->active);
        $response_employees = json_decode($response->content())->data->data;

        $relevant_employees = Employee::where('active', $this->firstEmployee->active)->count();
        $this->assertEquals(count($response_employees), $relevant_employees);
    }
}
