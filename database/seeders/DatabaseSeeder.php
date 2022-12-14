<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        Genre::truncate();
        Movie::truncate();

        // User::factory(1)->create();
        // Genre::factory(1)->create();
        // Movie::factory(5)->create();
        // Comment::factory(3)->create();

        $user = User::create(['username' => 'nikolaS', 'password' => Hash::make('nikolaS123'), 'email' => 'nikola@gmail.com']);
        $genre = Genre::create(['genre_name' => 'comedy']);

        $movies = Movie::factory(2)->create(['user_id' => $user->id, "genre_id" => $genre->id]);

        Comment::factory(7)->create(['movie_id' => $movies[0]->id]);
        Comment::factory(10)->create(['movie_id' => $movies[1]->id]);
    }
}
