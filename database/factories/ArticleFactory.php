<?php

namespace Database\Factories;

use App\Models\ArticleCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = [];
        $description = [];
        $short_description = [];
        foreach (main_locales() as $locale) {
            $title[$locale] = $this->faker->name();
            $description[$locale] = $this->faker->text(100);
            $short_description[$locale] = $this->faker->text(50);
        }

        $articleCategory = ArticleCategory::first();
        return [
            "article_category_id" => $articleCategory ? $articleCategory->id : 1,
            "title" => $title,
            "description" => $title,
            "short_description" => $title,
            "active" => rand(0,1),
        ];
    }
}
