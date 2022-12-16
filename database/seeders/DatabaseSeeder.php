<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(StaticContentSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(SuperAdminSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(PartitionSeeder::class);
        $this->call(PageHeaderSeeder::class);
    }
}
