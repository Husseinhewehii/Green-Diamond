<?php

namespace Database\Seeders;

use App\Models\Partition;
use Illuminate\Database\Seeder;

class PartitionSeeder extends Seeder
{


    public function run()
    {
        $title = [];
        $sub_title = [];
        $description = [];
        $short_description = [];
        foreach (main_locales() as $locale) {
            $title[$locale] = "title $locale";
            $sub_title[$locale] = "sub_title $locale";
            $description[$locale] = "description $locale";
            $short_description[$locale] = "short_description $locale";
        }

        $partitionPayLoad = [
            "title" => $title,
            "sub_title" => $sub_title,
            "description" => $description,
            "short_description" => $short_description,
            "active" => 1
        ];

        $homePagePartitions = [
            "about_us",
            "sprilulina",
        ];

        $aboutUsPartitions = [
            "chairman",
            "who_we_are",
            "our_mission",
            "our_vission",
        ];

        foreach ($homePagePartitions as $partitionKey) {
            $partitionPayLoad['group'] = "home_page";
            $partitionPayLoad['key'] = $partitionKey;
            Partition::firstOrCreate(["key"=> $partitionKey], $partitionPayLoad);
        }

        foreach ($aboutUsPartitions as $partitionKey) {
            $partitionPayLoad['group'] = "about_us";
            $partitionPayLoad['key'] = $partitionKey;
            Partition::firstOrCreate(["key"=> $partitionKey], $partitionPayLoad);
        }
    }
}
