<?php

namespace Tests\Feature\Admin\Employee;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EmployeeResponseTest extends TestCase
{
    use RefreshDatabase, EmployeeTestingTrait;

    public function testEmployeeIndexCode200WithFormat()
    {
        $response = $this->get('/api/admin/employees');
        $response->assertOk();
        $response->assertJson(assertPaginationFormat($this->allEmployeesInFormat->toArray()));
        $this->assertTrue(assertCheckPaginatedResponseHasPhotoLink($response, 0));
    }

    // public function testEmployeeStoreCode201WithFormat()
    // {
    //     $data['photo'] = UploadedFile::fake()->create('test.png', $kilobytes = 5000);
    //     $response = $this->post('/api/admin/employees', $this->employeePayLoad($data));
    //     $response->assertCreated();
    //     $response->assertJson(assertCreatedPaginationFormat([...$this->allEmployeesInFormat, $this->employeePayLoad()]));
    //     $this->assertTrue(assertCheckPaginatedResponseHasPhotoLink($response, 0));
    // }

    // public function testEmployeeUpdateCode200WithFormat()
    // {
    //     $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayload());
    //     $response->assertOk();
    //     $response->assertJson(assertPaginationFormat([$this->employeePayLoad()]));
    //     $this->assertTrue(assertCheckPaginatedResponseHasPhotoLink($response, 0));
    // }

    public function testEmployeeShowCode200WithFormat()
    {
        $response = $this->get('/api/admin/employees/'.$this->firstEmployee->id);
        $response->assertOk();
        $response->assertJson(assertDataContent($this->employeeFormat($this->firstEmployee)));
        $this->assertTrue(assertCheckResponseHasPhotoLink($response));
    }

    public function testEmployeeDeleteCode200WithFormat()
    {
        $response = $this->delete('/api/admin/employees/'.$this->firstEmployee->id);
        $response->assertOk();
        $response->assertJson(assertPaginationFormat());
    }

    public function testEmployeeShowNotFoundCode404WithFormat()
    {
        $response = $this->get('/api/admin/employees/'."123213213213");
        $response->assertNotFound();
        $response->assertJson(assertNotFoundFormat());
    }

    // public function testEmployeeUpdateSameEmailAndSamePhone()
    // {
    //     $data = ['email' => $this->firstEmployee->email, 'phone' => $this->firstEmployee->phone];
    //     $response = $this->put('/api/admin/employees/'.$this->firstEmployee->id, $this->employeePayload($data));
    //     $response->assertOk();
    // }
}
