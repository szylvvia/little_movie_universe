<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovieHasArtistSeeder extends Seeder
{
    public function run(): void
    {
        $common = [
            'created_at' => now(),
            'updated_at' => now()
        ];

        $movieHasArtist = [
            // Movie 1
            array_merge($common, ['movie_id' => 1, 'artist_id' => 1]),
            array_merge($common, ['movie_id' => 1, 'artist_id' => 9]),
            // Movie 2
            array_merge($common, ['movie_id' => 2, 'artist_id' => 3]),
            array_merge($common, ['movie_id' => 2, 'artist_id' => 2]),
            // Movie 3
            array_merge($common, ['movie_id' => 3, 'artist_id' => 1]),
            array_merge($common, ['movie_id' => 3, 'artist_id' => 9]),
            // Movie 4
            array_merge($common, ['movie_id' => 4, 'artist_id' => 5]),
            array_merge($common, ['movie_id' => 4, 'artist_id' => 4]),
            // Movie 5
            array_merge($common, ['movie_id' => 5, 'artist_id' => 1]),
            array_merge($common, ['movie_id' => 5, 'artist_id' => 9]),
            // Movie 6
            array_merge($common, ['movie_id' => 6, 'artist_id' => 8]),
            array_merge($common, ['movie_id' => 6, 'artist_id' => 5]),
            // Movie 7
            array_merge($common, ['movie_id' => 7, 'artist_id' => 6]),
            array_merge($common, ['movie_id' => 7, 'artist_id' => 9]),
            array_merge($common, ['movie_id' => 7, 'artist_id' => 8]),
        ];

        DB::table('movie_has_artist')->insert($movieHasArtist);
    }
}
