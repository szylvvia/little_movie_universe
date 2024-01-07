<?php

namespace Tests\Feature;

use App\Http\Controllers\QuizController;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;


class QuizTestFeature extends TestCase
{
    use DatabaseTransactions;

    public function testAddQuizWhenDataIsValidAndUserIsAdmin()
    {
        $admin = User::factory()->create(
            [
                'role' => 'admin'
            ]
        );
        Storage::fake('public');
        $file1 = UploadedFile::fake()->image('poster.jpg');

        $this->actingAs($admin);
        $data = [
            'title' => 'Test Test Test Test',
            'description' => "kdjsfhdsjkghdfjg",
            'start_date' => now()->addDays(1000)->format('Y-m-d'),
            'end_date' => now()->addDays(10001)->format('Y-m-d'),
            'options' => [
                1 => "o111",
                2 => "o222",
                3 => "o333",
            ],
            'images' => [
                1 => $file1,
                2 => $file1,
                3 => $file1,
            ],
        ];
        $response = $this->post('/addQuiz',$data);
        $response->assertStatus(302);
        $response->assertRedirect('/adminPanel');
        $response->assertSessionHas('success', 'Quiz został dodany pomyślnie.');

        $this->assertDatabaseHas('quizzes', [
            'title' => $data['title'],
            'description' => $data['description'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'user_id' => $admin->id
        ]);
        $quiz = Quiz::where(['start_date' => $data['start_date'],
            'end_date' => $data['end_date']])->first();

        $this->assertNotNull($quiz);

        foreach ($data['options'] as $key => $value) {
            $this->assertDatabaseHas('questions', [
                'quiz_id' => $quiz->id,
                'question' => $value,
            ]);

            $question = Question::where('quiz_id', $quiz->id)
                ->where('question', $value)
                ->first();

            $this->assertNotNull($question);
            $this->assertNotNull($question->image);
        }
    }

    public function testAddQuizWhenDatesIsInvalidAndUserIsAdmin()
    {
        $admin = User::factory()->create(
            [
                'role' => 'admin'
            ]
        );
        Storage::fake('public');
        $file1 = UploadedFile::fake()->image('poster.jpg');

        $this->actingAs($admin);
        $data = [
            'title' => 'Test Test Test Test',
            'description' => "kdjsfhdsjkghdfjg",
            'start_date' => now()->addDays(1000)->format('Y-m-d'),
            'end_date' => now()->addDays(999)->format('Y-m-d'),
            'options' => [
                1 => "o111",
                2 => "o222",
                3 => "o333",
            ],
            'images' => [
                1 => $file1,
                2 => $file1,
                3 => $file1,
            ],
        ];
        $response = $this->post('/addQuiz',$data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['end_date'=>'Pole data zakończenia musi być datą po data rozpoczęcia.']);

    }

}