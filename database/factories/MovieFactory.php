<?php

namespace Database\Factories;

use App\Models\Genre;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'release_date' => $this->faker->date(),
            'storyline' => $this->faker->text(),
            'genre_id' => Genre::factory(),
            'user_id' => User::factory(),
        ];
    }
}
