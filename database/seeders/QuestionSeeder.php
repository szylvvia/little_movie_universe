<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class QuestionSeeder extends Seeder
{
    public function convertImage($image)
    {
        $resizedImage = Image::make($image)->resize(200, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        $imageData = $resizedImage->encode(null)->getEncoded();

        return $imageData;
    }

    public function run(): void
    {
        $questions =
        [
            [
                'question' => 'Oppenheimer',
                'image' => $this->convertImage(file_get_contents(public_path("/img/questions/q1_p1.jpg"))),
                'quiz_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                'question' => 'Barbie',
                'image' => $this->convertImage(file_get_contents(public_path("/img/questions/q1_p2.jpg"))),
                'quiz_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Chlopi',
                'image' => $this->convertImage(file_get_contents(public_path("/img/questions/q1_p3.jpg"))),
                'quiz_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'IronMan',
                'image' => $this->convertImage(file_get_contents(public_path("/img/questions/q2_p1.jpg"))),
                'quiz_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'SpiderMan',
                'image' => $this->convertImage(file_get_contents(public_path("/img/questions/q2_p2.jpg"))),
                'quiz_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Doctor Strange',
                'image' => $this->convertImage(file_get_contents(public_path("/img/questions/q2_p3.jpg"))),
                'quiz_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('questions')->insert($questions);
    }
}
