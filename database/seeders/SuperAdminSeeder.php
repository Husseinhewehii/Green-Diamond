<?php

namespace Database\Seeders;

use App\Constants\UserTypes;
use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(['email' => 'super@admin.com',],
        [
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'super@admin.com',
            'password' => env('SUPER_ADMIN_PASSWORD'),
            'phone' => env('SUPER_ADMIN_PHONE'),
            'type' => UserTypes::SUPER_ADMIN,
            'active' => true
        ]);
    }
}
