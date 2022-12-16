<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mainSettings = [
            "company_email" =>  "green@diamond.com"
        ];

        $socialSettings = [
            "facebook" =>  "facebook.greendiamond"
        ];

        foreach ($socialSettings as $key => $value) {
            Setting::firstOrCreate(["key"=> $key], ["key"=> $key, "group" => "social", "value" => $value]);
        }

        foreach ($mainSettings as $key => $value) {
            Setting::firstOrCreate(["key"=> $key], ["key"=> $key, "group" => "main", "value" => $value]);
        }


    }
}
