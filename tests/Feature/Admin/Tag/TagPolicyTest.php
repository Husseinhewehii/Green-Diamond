<?php

namespace Tests\Feature\Admin\Tag;

use App\Models\Tag;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsTestingSeeder;
use Database\Seeders\StaticContentSeeder;
use Database\Seeders\SuperAdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\TestCase;

class TagPolicyTest extends TestCase
{
    use RefreshDatabase;

    protected $superAdmin;
    protected $firstTag;

    public function setUp() : void
    {
        parent::setUp();
        $this->seed(SuperAdminSeeder::class);
        $this->seed(StaticContentSeeder::class);
        $this->superAdmin = User::whereEmail('super@admin.com')->first();
        $this->firstTag = Tag::factory()->create();

        Artisan::call('passport:install');
        Passport::actingAs($this->superAdmin);
        $this->seed(RolesAndPermissionsTestingSeeder::class);
    }

    protected function tagPayload($passedData = []){
        $data = [
            'title' => [
                "en" => "english title",
                "ar" => "arabic title",
            ],
            'active' => 1
        ];
        return array_merge($data, $passedData);
    }

    public function testTagIndexCode403WithFormat()
    {
        $response = $this->get('/api/admin/tags');
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }

    public function testTagStoreCode403WithFormat()
    {
        $response = $this->post('/api/admin/tags', $this->tagPayload());
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }

    public function testTagUpdateCode403WithFormat()
    {
        $response = $this->put('/api/admin/tags/'.$this->firstTag->id, $this->tagPayload());
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }

    public function testTagShowCode403WithFormat()
    {
        $response = $this->get('/api/admin/tags/'.$this->firstTag->id);
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }

    public function testTagDeleteCode403WithFormat()
    {
        $response = $this->delete('/api/admin/tags/'.$this->firstTag->id);
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }
}
