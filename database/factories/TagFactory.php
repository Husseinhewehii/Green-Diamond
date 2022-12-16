<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $names = [];
        foreach (main_locales() as $locale) {
            $names[$locale] = $this->faker->name();
        }


        return [
            "name" => $names,
            "active" => rand(0,1),
        ];
    }
}
