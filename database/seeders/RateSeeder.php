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
                    'review' => 'Wspaniały film!'
                ],
                [
                    'movie_id' => 1,
                    'user_id' => 3,
                    'rate' => 6,
                    'review' => 'W mojej opini bardzo przeciętna pozycja filmowa.'
                ],
                [
                    'movie_id' => 1,
                    'user_id' => 4,
                    'rate' => 10,
                    'review' => 'Rewelacyjny!'
                ],
                [
                    'movie_id' => 2,
                    'user_id' => 1,
                    'rate' => 5,
                    'review' => 'Dużo szumu medialnego, a film przeciętny.'
                ],
                [
                    'movie_id' => 2,
                    'user_id' => 2,
                    'rate' => 10,
                    'review' => 'Rewelacyjny. Świetna obsada!'
                ],
                [
                    'movie_id' => 2,
                    'user_id' => 4,
                    'rate' => 10,
                    'review' => 'Od tej pory to mój ulubiony film!'
                ],
                //3
                [
                    'movie_id' => 3,
                    'user_id' => 1,
                    'rate' => 8,
                    'review' => 'Jeden z moich ulubionych. Polecam każdegmu!'
                ],
                [
                    'movie_id' => 3,
                    'user_id' => 4,
                    'rate' => 5,
                    'review' => 'Nudny i bardzo przewidywalny.'
                ],
                [
                    'movie_id' => 3,
                    'user_id' => 2,
                    'rate' => 9,
                    'review' => 'Prawdziwe filmowe arcydzieło!'
                ],
                //4
                [
                    'movie_id' => 4,
                    'user_id' => 1,
                    'rate' => 10,
                    'review' => 'Przepiękna historia i zniewaljące widoki!'
                ],
                [
                    'movie_id' => 4,
                    'user_id' => 4,
                    'rate' => 9,
                    'review' => 'Zdecydowanie zasługuje na Oscara!'
                ],
                [
                    'movie_id' => 4,
                    'user_id' => 2,
                    'rate' => 4,
                    'review' => 'Żadnej fabuły i akcji. Nuda.'
                ],
                //5
                [
                    'movie_id' => 5,
                    'user_id' => 2,
                    'rate' => 4,
                    'review' => 'Bardzo słaby film. Nie polcecam.'
                ],
                [
                    'movie_id' => 5,
                    'user_id' => 3,
                    'rate' => 7,
                    'review' => 'Ekscytująca akcja!'
                ],
                [
                    'movie_id' => 5,
                    'user_id' => 4,
                    'rate' => 9,
                    'review' => 'Jeden z moich ulubionych'
                ],
                //6
                [
                    'movie_id' => 6,
                    'user_id' => 1,
                    'rate' => 7,
                    'review' => 'Szybka akcja, nie można się przy nim nudzić.'
                ],
                [
                    'movie_id' => 6,
                    'user_id' => 2,
                    'rate' => 10,
                    'review' => 'Uwielbiam ten film.'
                ],
                [
                    'movie_id' => 6,
                    'user_id' => 3,
                    'rate' => 7,
                    'review' => 'Rewelacyjny'
                ],
                //7
                [
                    'movie_id' => 7,
                    'user_id' => 4,
                    'rate' => 10,
                    'review' => 'Mogę ogłądać go milion razy i za każdym razem jest wspaniały!'
                ],
                [
                    'movie_id' => 7,
                    'user_id' => 2,
                    'rate' => 5,
                    'review' => 'Nie rozumiem fenomenu tego filmu.'
                ],
                [
                    'movie_id' => 7,
                    'user_id' => 1,
                    'rate' => 6,
                    'review' => 'Idealny na jesienne wieczory!'
                ],


            ];
        DB::table('rates')->insert($rate);
    }
}
