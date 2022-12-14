<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "text" => $this->faker->text(),
            "movie_rating" => $this->faker->numberBetween(0, 5),
            "user_id" => User::factory(),
            "movie_id" => Movie::factory(),
        ];
    }
}
