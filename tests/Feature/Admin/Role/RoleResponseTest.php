<?php

namespace Tests\Feature\Admin\Role;

use App\Models\SystemRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleResponseTest extends TestCase
{
    use RefreshDatabase, RoleTestingTrait;

    public function testRoleIndexCode200WithFormat()
    {
        $response = $this->get('/api/admin/roles');
        $response->assertOk();
        // dd($response);
        $response->assertJson(assertPaginationFormat($this->allRolesInFormat->toArray()));
        $response->assertJsonFragment([
            [
                'id' => $this->firstRole->id,
                'name' => $this->firstRole->name,
                'active' => $this->firstRole->active,
            ]
        ]);
    }

    public function testRoleStoreCode201WithFormat()
    {
        $response = $this->post('/api/admin/roles', $this->rolePayLoad());
        $response->assertCreated();
        $response->assertJson(assertCreatedPaginationFormat([...$this->allRolesInFormat, $this->rolePayLoad()]));

        $role = SystemRole::create(['name' => 'test']);
        $this->assertModelExists($role);
    }

    public function testRoleUpdateCode200WithFormat()
    {
        $response = $this->put('/api/admin/roles/'.$this->lastRole->id, $this->rolePayload());
        $response->assertOk();
        $response->assertJson(assertPaginationFormat([$this->roleFormat($this->firstRole), $this->rolePayLoad()]));
    }

    public function testRoleShowCode200WithFormat()
    {
        $response = $this->get('/api/admin/roles/'.$this->lastRole->id);
        $response->assertOk();
        $response->assertJson(assertDataContent($this->roleFormat($this->lastRole)));
    }

    public function testRoleDeleteCode200WithFormat()
    {
        $response = $this->delete('/api/admin/roles/'.$this->lastRole->id);
        $response->assertOk();
        $response->assertJson(assertPaginationFormat([$this->roleFormat($this->firstRole)]));
    }

    public function testRoleUpdateSameName()
    {
        $data = ['name' => $this->lastRole->name];
        $response = $this->put('/api/admin/roles/'.$this->lastRole->id, $this->rolePayLoad($data));
        $response->assertOk();
    }

    public function testRoleShowNotFoundCode404withFormat()
    {
        $response = $this->get('/api/admin/roles/'."123213213213");
        $response->assertNotFound();
        $response->assertJson(assertNotFoundFormat());
    }
}
