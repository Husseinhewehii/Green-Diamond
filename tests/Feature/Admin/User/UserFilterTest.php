<?php

namespace Tests\Feature\Admin\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserFilterTest extends TestCase
{
    use RefreshDatabase, UserTestingTrait;

    public function testUserIndexFilterFirstName()
    {
        $response = $this->get("/api/admin/users?filter[first_name]=".$this->admin->first_name);
        $response_users = json_decode($response->content())->data->data;

        $relevant_users = User::where('first_name', $this->admin->first_name)->count();
        $this->assertEquals(count($response_users), $relevant_users);
    }

    public function testUserIndexFilterLastName()
    {
        $response = $this->get("/api/admin/users?filter[last_name]=".$this->admin->last_name);
        $response_users = json_decode($response->content())->data->data;

        $relevant_users = User::where('last_name', $this->admin->last_name)->count();
        $this->assertEquals(count($response_users), $relevant_users);
    }

    public function testUserIndexFilterEmail()
    {
        $response = $this->get("/api/admin/users?filter[email]=".$this->admin->email);
        $response_users = json_decode($response->content())->data->data;

        $relevant_users = User::where('email', $this->admin->email)->count();
        $this->assertEquals(count($response_users), $relevant_users);
    }

    public function testUserIndexFilterType()
    {
        $response = $this->get("/api/admin/users?filter[type]=".$this->admin->type);
        $response_users = json_decode($response->content())->data->data;

        $relevant_users = User::where('type', $this->admin->type)->count();
        $this->assertEquals(count($response_users), $relevant_users);
    }

    public function testUserIndexFilterActive()
    {
        $response = $this->get("/api/admin/users?filter[active]=".$this->admin->active);
        $response_users = json_decode($response->content())->data->data;

        $relevant_users = User::where('active', $this->admin->active)->count();
        $this->assertEquals(count($response_users), $relevant_users);
    }

    public function testUserIndexFilterPhone()
    {
        $response = $this->get("/api/admin/users?filter[phone]=".$this->admin->phone);
        $response_users = json_decode($response->content())->data->data;

        $relevant_users = User::where('phone', $this->admin->phone)->count();
        $this->assertEquals(count($response_users), $relevant_users);
    }
}
