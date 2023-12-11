<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuizSeeder extends Seeder
{

    public function run(): void
    {
        $quiz =
            [
                [
                    'title' => 'Little Movie Universe Plebiscite',
                    'description' => 'Vote for you favourite movie!',
                    'start_date' => '2023-12-11',
                    'end_date' => '2023-12-17',
                    'user_id' => 4,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'The best Marvel Superhero',
                    'description' => 'Vote for you favourite Marvel superhero!',
                    'start_date' => '2023-12-18',
                    'end_date' => '2023-12-24',
                    'user_id' => 4,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

        DB::table('quizzes')->insert($quiz);
    }
}
