<?php

namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettingFactory extends Factory
{
    protected $model = Setting::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "group" => $this->faker->title(),
            "key" => $this->faker->unique()->title(),
            "value" => $this->faker->title(),
        ];
    }
}
