<?php

namespace Database\Factories;

use App\Constants\ArticleCategoriesTypes;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = [];
        foreach (main_locales() as $locale) {
            $title[$locale] = $this->faker->name();
        }

        return [
            "title" => $title,
            'type' => array_rand(ArticleCategoriesTypes::getArticleCategoriesTypes()),
            "active" => rand(0,1),
        ];
    }
}
