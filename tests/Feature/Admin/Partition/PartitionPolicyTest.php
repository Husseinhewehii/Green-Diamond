<?php

namespace Tests\Feature\Admin\Partition;

use App\Models\Partition;
use App\Models\User;
use Database\Seeders\PartitionSeeder;
use Database\Seeders\RolesAndPermissionsTestingSeeder;
use Database\Seeders\StaticContentSeeder;
use Database\Seeders\SuperAdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PartitionPolicyTest extends TestCase
{
    use RefreshDatabase;

    protected $superAdmin;
    protected $firstPartition;

    public function setUp() : void
    {
        parent::setUp();
        $this->seed(SuperAdminSeeder::class);
        $this->seed(StaticContentSeeder::class);
        $this->superAdmin = User::whereEmail('super@admin.com')->first();

        $this->seed(PartitionSeeder::class);
        $this->firstPartition = Partition::first();

        Artisan::call('passport:install');
        Passport::actingAs($this->superAdmin);
        $this->seed(RolesAndPermissionsTestingSeeder::class);
    }

    protected function partitionPayload($passedData = []){
        $data = [
            'title' => [
                "en" => "english title",
                "ar" => "arabic title",
            ],
            'sub_title' => [
                "en" => "english sub_title",
                "ar" => "arabic sub_title",
            ],
            'description' => [
                "en" => "english description",
                "ar" => "arabic description",
            ],
            'short_description' => [
                "en" => "english short_description",
                "ar" => "arabic short_description",
            ],
            'active' => 1
        ];
        return array_merge($data, $passedData);
    }

    public function testPartitionIndexCode403WithFormat()
    {
        $response = $this->get('/api/admin/partitions');
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }

    public function testPartitionUpdateCode403WithFormat()
    {
        $response = $this->put('/api/admin/partitions/'.$this->firstPartition->id, $this->partitionPayload());
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }

    public function testPartitionShowCode403WithFormat()
    {
        $response = $this->get('/api/admin/partitions/'.$this->firstPartition->id);
        $response->assertForbidden();
        $response->assertJson(assertForbiddenFormat());
    }
}
