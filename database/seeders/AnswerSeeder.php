<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $answers =
            [
                [
                    'user_id' => 2,
                    'question_id' => 1,
                    'quiz_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'user_id' => 4,
                    'question_id' => 2,
                    'quiz_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'user_id' => 3,
                    'question_id' => 3,
                    'quiz_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],

                [
                    'user_id' => 2,
                    'question_id' => 6,
                    'quiz_id' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'user_id' => 3,
                    'question_id' => 4,
                    'quiz_id' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'user_id' => 3,
                    'question_id' => 5,
                    'quiz_id' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            ];

        DB::table('answers')->insert($answers);
    }
}
