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
                    'title' => 'Plebiscyt Little Movies Universe',
                    'description' => 'Weź udział w  plebiscycie i zagłosuj na swój ulubiony film!',
                    'start_date' => '2024-01-06',
                    'end_date' => '2024-01-12',
                    'user_id' => 4,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Najlepszy superbohater z filmów Marvela',
                    'description' => 'Zagłosuj na swojego ulubionego superbohatera z uniwersum Marvela',
                    'start_date' => '2024-01-13',
                    'end_date' => '2024-01-31',
                    'user_id' => 4,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

        DB::table('quizzes')->insert($quiz);
    }
}
