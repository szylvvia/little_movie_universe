<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Answer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(ArtistSeeder::class);
        $this->call(MovieSeeder::class);
        $this->call(ImagesSeeder::class);
        $this->call(MovieHasArtistSeeder::class);
        $this->call(RateSeeder::class);
        $this->call(QuizSeeder::class);
        $this->call(QuestionSeeder::class);
        $this->call(AnswerSeeder::class);
    }
}
