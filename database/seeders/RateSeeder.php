<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rate =
            [
                [
                    'movie_id' => 1,
                    'user_id' => 1,
                    'rate' => 10,
                    'review' => 'Amazing film!'
                ],
                [
                    'movie_id' => 1,
                    'user_id' => 3,
                    'rate' => 8,
                    'review' => 'Not my type of film'
                ],
                [
                    'movie_id' => 1,
                    'user_id' => 4,
                    'rate' => 10,
                    'review' => 'Brilliant'
                ],
                [
                    'movie_id' => 2,
                    'user_id' => 1,
                    'rate' => 5,
                    'review' => 'Nice'
                ],
                [
                    'movie_id' => 2,
                    'user_id' => 2,
                    'rate' => 10,
                    'review' => 'Wonderfull'
                ],
                [
                    'movie_id' => 2,
                    'user_id' => 4,
                    'rate' => 10,
                    'review' => 'Nice'
                ],
                //3
                [
                    'movie_id' => 3,
                    'user_id' => 1,
                    'rate' => 8,
                    'review' => 'One of my favourite'
                ],
                [
                    'movie_id' => 3,
                    'user_id' => 4,
                    'rate' => 5,
                    'review' => 'Boring'
                ],
                [
                    'movie_id' => 3,
                    'user_id' => 2,
                    'rate' => 9,
                    'review' => 'Masterpiece'
                ],
                //4
                [
                    'movie_id' => 4,
                    'user_id' => 1,
                    'rate' => 10,
                    'review' => 'Wonderfully story and views'
                ],
                [
                    'movie_id' => 4,
                    'user_id' => 4,
                    'rate' => 9,
                    'review' => 'Should won an Oscars'
                ],
                [
                    'movie_id' => 4,
                    'user_id' => 2,
                    'rate' => 4,
                    'review' => 'Any plot and action. Boring'
                ],
                //5
                [
                    'movie_id' => 5,
                    'user_id' => 2,
                    'rate' => 4,
                    'review' => 'Any plot and action. Boring'
                ],
                [
                    'movie_id' => 5,
                    'user_id' => 3,
                    'rate' => 7,
                    'review' => 'Exciting movie'
                ],
                [
                    'movie_id' => 5,
                    'user_id' => 4,
                    'rate' => 9,
                    'review' => 'One of my favourite'
                ],
                //6
                [
                    'movie_id' => 6,
                    'user_id' => 1,
                    'rate' => 7,
                    'review' => 'Quick action'
                ],
                [
                    'movie_id' => 6,
                    'user_id' => 2,
                    'rate' => 10,
                    'review' => 'Love that film'
                ],
                [
                    'movie_id' => 6,
                    'user_id' => 3,
                    'rate' => 7,
                    'review' => 'Exciting movie'
                ],
                //7
                [
                    'movie_id' => 7,
                    'user_id' => 4,
                    'rate' => 10,
                    'review' => 'I can watching million times'
                ],
                [
                    'movie_id' => 7,
                    'user_id' => 2,
                    'rate' => 5,
                    'review' => 'I can not understand the phenomenon'
                ],
                [
                    'movie_id' => 7,
                    'user_id' => 1,
                    'rate' => 6,
                    'review' => 'Good for autumns evenings'
                ],


            ];
        DB::table('rates')->insert($rate);
    }
}
