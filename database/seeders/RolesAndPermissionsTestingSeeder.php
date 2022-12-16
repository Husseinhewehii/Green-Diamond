<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesAndPermissionsTestingSeeder extends Seeder
{
    use RolesAndPermissionsSeedingTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->runTesting();
    }
}
