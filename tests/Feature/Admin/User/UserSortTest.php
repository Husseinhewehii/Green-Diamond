<?php

namespace Tests\Feature\Admin\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserSortTest extends TestCase
{
    use RefreshDatabase, UserTestingTrait;

    public function testUserIndexSortFirstName()
    {
        $response = $this->get("/api/admin/users?sort=first_name");
        $response_users = json_decode($response->content())->data->data;
        $first_user_sorted_by_first_name = User::orderBy('first_name')->first("first_name")->first_name;
        $this->assertEquals($response_users[0]->first_name, $first_user_sorted_by_first_name);
    }

    public function testUserIndexSortLastName()
    {
        $response = $this->get("/api/admin/users?sort=last_name");
        $response_users = json_decode($response->content())->data->data;
        $first_user_sorted_by_last_name = User::orderBy('last_name')->first("last_name")->last_name;
        $this->assertEquals($response_users[0]->last_name, $first_user_sorted_by_last_name);
    }

    public function testUserIndexSortEmail()
    {
        $response = $this->get("/api/admin/users?sort=email");
        $response_users = json_decode($response->content())->data->data;
        $first_user_sorted_by_email = User::orderBy('email')->first("email")->email;
        $this->assertEquals($response_users[0]->email, $first_user_sorted_by_email);
    }

    public function testUserIndexSortType()
    {
        $response = $this->get("/api/admin/users?sort=type");
        $response_users = json_decode($response->content())->data->data;
        $first_user_sorted_by_type = User::orderBy('type')->first("type")->type;
        $this->assertEquals($response_users[0]->type, $first_user_sorted_by_type);
    }

    public function testUserIndexSortPhone()
    {
        $response = $this->get("/api/admin/users?sort=phone");
        $response_users = json_decode($response->content())->data->data;
        $first_user_sorted_by_phone = User::orderBy('phone')->first("phone")->phone;
        $this->assertEquals($response_users[0]->phone, $first_user_sorted_by_phone);
    }

    public function testUserIndexSortActive()
    {
        $response = $this->get("/api/admin/users?sort=active");
        $response_users = json_decode($response->content())->data->data;
        $first_user_sorted_by_active = User::orderBy('active')->first("active")->active;
        $this->assertEquals($response_users[0]->active, $first_user_sorted_by_active);
    }
}
