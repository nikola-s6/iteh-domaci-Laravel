<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Seeder;

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

        User::factory(1)->create();
        Genre::factory(1)->create();
        Movie::factory(5)->create();
    }
}
