<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tittle' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(6),
            'user_id' => $this->faker->numberBetween(1,10),
            'game_id' => $this->faker->numberBetween(1,3),
        ];
    }
}
