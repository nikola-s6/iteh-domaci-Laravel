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

        $user1 = User::create(['username' => 'nikolaS', 'password' => Hash::make('nikolaS123'), 'email' => 'nikola@gmail.com']);
        $user2 = User::create(['username' => 'milos.00', 'password' => Hash::make('milos.00123'), 'email' => 'milos@gmail.com']);

        $genre1 = Genre::create(['genre_name' => 'comedy']);
        $genre2 = Genre::create(['genre_name' => 'action']);
        $genre3 = Genre::create(['genre_name' => 'horror']);

        $movie1 = Movie::factory(2)->create(['user_id' => $user1->id, "genre_id" => $genre1->id]);
        $movie2 = Movie::factory(2)->create(['user_id' => $user1->id, "genre_id" => $genre2->id]);
        $movie3 = Movie::factory(2)->create(['user_id' => $user2->id, "genre_id" => $genre3->id]);

        Comment::factory(7)->create(['movie_id' => $movie1[0]->id]);
        Comment::factory(7)->create(['movie_id' => $movie1[1]->id]);
        Comment::factory(7)->create(['movie_id' => $movie2[0]->id]);
        Comment::factory(7)->create(['movie_id' => $movie2[1]->id]);
        Comment::factory(7)->create(['movie_id' => $movie3[0]->id]);
        Comment::factory(7)->create(['movie_id' => $movie3[1]->id]);
    }
}
