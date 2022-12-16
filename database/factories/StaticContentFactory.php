<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StaticContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $text = [];
        foreach (main_locales() as $locale) {
            $text[$locale] = $this->faker->text(30);
        }

        return [
            "group" => $this->faker->title(),
            "key" => $this->faker->unique()->title(),
            "text" => $text
        ];
    }
}
