<?php

namespace Tests\Feature\Admin\Partition;

use App\Models\Partition;
use Database\Seeders\PartitionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PartitionUnAuthenticatedTest extends TestCase
{
    use RefreshDatabase;

    protected $firstPartition;

    public function setUp() : void
    {
        parent::setUp();
        $this->seed(PartitionSeeder::class);
        $this->firstPartition = Partition::first();
    }

    public function testPartitionIndexUnauthenticatedCode401WithFormat()
    {
        $response = $this->get('/api/admin/partitions');
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

    public function testPartitionUpdateUnauthenticatedCode401WithFormat()
    {
        $response = $this->put('api/admin/partitions/'.$this->firstPartition->id);
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

    public function testPartitionShowUnauthenticatedCode401WithFormat()
    {
        $response = $this->get('api/admin/partitions/'.$this->firstPartition->id);
        $response->assertUnauthorized();
        $response->assertJson(assertUnauthorizedFormat());
    }

}
