<?php

namespace Tests\Feature\Admin\Role;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\SystemRole as Role;

class RoleSortTest extends TestCase
{
    use RefreshDatabase, RoleTestingTrait;

    public function testRoleIndexSortName()
    {
        $response = $this->get("/api/admin/roles?sort=name");
        $response_roles = json_decode($response->content())->data->data;
        $first_role_sorted_by_name = Role::orderBy('name')->first("name")->name;
        $this->assertEquals($response_roles[0]->name, $first_role_sorted_by_name);
    }

    public function testRoleIndexSortActive()
    {
        $response = $this->get("/api/admin/roles?sort=active");
        $response_roles = json_decode($response->content())->data->data;
        $first_role_sorted_by_active = Role::orderBy('active')->first("active")->active;
        $this->assertEquals($response_roles[0]->active, $first_role_sorted_by_active);
    }
}
