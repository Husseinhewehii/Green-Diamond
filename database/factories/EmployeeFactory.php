<?php

namespace Database\Factories;

use App\Constants\EmployeeTypes;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $position = [];
        $description = [];
        foreach (main_locales() as $locale) {
            $position[$locale] = $this->faker->name();
            $description[$locale] = $this->faker->text(100);
        }

        return [
            'name' => $this->faker->name(),
            'position' => $position,
            'description' => $description,
            'type' => array_rand(EmployeeTypes::getEmployeeTypes()),
            // 'email' => $this->faker->unique()->email(),
            // 'phone' => "0123123".rand(0,9000),
            // 'social_media' => [
            //     $this->faker->unique()->url(),
            //     $this->faker->unique()->url(),
            // ],
            'active' => rand(0,1)
        ];
    }
}
