<?php

namespace Tests\Feature\Admin\StaticContent;

use App\Models\StaticContent;
use App\Models\User;
use Database\Seeders\StaticContentSeeder;
use Database\Seeders\SuperAdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\TestCase;

class StaticContentPolicyTest extends TestCase
{
    use RefreshDatabase;

    protected $firstStaticContent;
    protected $payLoadStaticContent;
    protected $updateUrl;
    protected $superAdmin;

    public function setUp() : void
    {
        parent::setUp();
        $this->seed(SuperAdminSeeder::class);
        $this->seed(StaticContentSeeder::class);
        $this->firstStaticContent = StaticContent::first();
        $this->superAdmin = User::whereEmail('super@admin.com')->first();

        Artisan::call('passport:install');
        Passport::actingAs($this->superAdmin);

        $this->payLoadStaticContent = [
            'text' => [
                "en" => "first firstStaticContent english",
                "ar" => "first firstStaticContent arabic"
            ]
        ];

        $this->updateUrl = 'api/admin/static-content/'.$this->firstStaticContent->id;
    }

    public function testStaticContentIndexCode403()
    {
        $response = $this->get('/api/admin/static-content');
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat ());
    }

    public function testStaticContentPutCode403()
    {
        $response = $this->put($this->updateUrl, $this->payLoadStaticContent);
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat ());
    }
}
