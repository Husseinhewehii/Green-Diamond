<?php

namespace Tests\Feature\Admin\Employee;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeUnAuthenticatedTest extends TestCase
{
    use RefreshDatabase;

    protected $firstEmployee;
    public function setUp() : void
    {
        parent::setUp();
        $this->firstEmployee = Employee::factory()->create();
    }

    public function testEmployeeIndexUnauthenticatedCode401WithFormat()
    {
        $response = $this->get('/api/admin/employees');
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

    public function testEmployeeStoreUnauthenticatedCode401WithFormat()
    {
        $response = $this->post('/api/admin/employees');
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

    public function testEmployeeUpdateUnauthenticatedCode401WithFormat()
    {
        $response = $this->put('api/admin/employees/'.$this->firstEmployee->id);
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

    public function testEmployeeShowUnauthenticatedCode401WithFormat()
    {
        $response = $this->get('api/admin/employees/'.$this->firstEmployee->id);
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

    public function testEmployeeDeleteUnauthenticatedCode401WithFormat()
    {
        $response = $this->delete('api/admin/employees/'.$this->firstEmployee->id);
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }
}
