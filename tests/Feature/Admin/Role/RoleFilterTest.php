<?php

namespace Tests\Feature\Admin\Role;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\SystemRole as Role;

class RoleFilterTest extends TestCase
{
    use RefreshDatabase, RoleTestingTrait;

    public function testRoleIndexFilterName()
    {
        $response = $this->get("/api/admin/roles?filter[name]=".$this->lastRole->name);
        $response_roles = json_decode($response->content())->data->data;

        $relevant_roles = Role::where('name', $this->lastRole->name)->count();
        $this->assertEquals(count($response_roles), $relevant_roles);
    }

    public function testRoleIndexFilterActive()
    {
        $response = $this->get("/api/admin/roles?filter[active]=".$this->lastRole->active);
        $response_roles = json_decode($response->content())->data->data;

        $relevant_roles = Role::where('active', $this->lastRole->active)->count();
        $this->assertEquals(count($response_roles), $relevant_roles);
    }
}
