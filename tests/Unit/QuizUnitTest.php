<?php

namespace Tests\Unit;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class QuizUnitTest extends TestCase
{
    use DatabaseTransactions;


    public function testAddQuizWhenDataIsValidAndUserIsAdmin()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Storage::fake('public');
        $file1 = UploadedFile::fake()->image('poster.jpg');

        $this->actingAs($admin);
        $data = [
            'title' => 'Test Test Test Test',
            'description' => "opis opis opis",
            'start_date' => now()->addDays(100)->format('Y-m-d'),
            'end_date' => now()->addDays(101)->format('Y-m-d'),
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
        $response = $this->post('/addQuiz', $data);
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

//^^^ działa
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
            'description' => "Opis opis opis",
            'start_date' => now()->addDays(100)->format('Y-m-d'),
            'end_date' => now()->addDays(99)->format('Y-m-d'),
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
        $response = $this->post('/addQuiz', $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['end_date' => 'Pole data zakończenia musi być datą po '.$data['start_date'].'.']);
    }

    //^^^działa
    public function testEditQuizWhenDatesIsValidAndUserIsAdmin()
    {
        $admin = User::factory()->create(
            [
                'role' => 'admin'
            ]
        );
        Storage::fake('public');
        $file1 = UploadedFile::fake()->image('old.jpg');
        $this->actingAs($admin);
        $data = [
            'title' => 'Test Test Test Test',
            'description' => "opis opis opis opis",
            'start_date' => now()->addDays(200)->format('Y-m-d'),
            'end_date' => now()->addDays(2007)->format('Y-m-d'),
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
        $response = $this->post('/addQuiz', $data);
        $response->assertStatus(302);
        $response->assertRedirect('/adminPanel');
        $response->assertSessionHas('success', 'Quiz został dodany pomyślnie.');

        $latest = Quiz::latest()->first();
        $quiz_id = $latest->id;
        $questions = Question::where(['quiz_id' => $quiz_id])->get();
        $tabQuestions = [];

        foreach ($questions as $q) {
            $tabQuestions[$q->id] = $q->question;
        }
        $dataNew = [
            "title" => "Plebiscyt Little Movies Universe",
            'start_date' => now()->addDays(200)->format('Y-m-d'),
            'end_date' => now()->addDays(2007)->format('Y-m-d'),
            "description" => "Weź udział w  plebiscycie i zagłosuj na swój ulubiony film!",
            "questions" => $tabQuestions,
        ];

        $response = $this->post("/editQuiz/{$quiz_id}", $dataNew);
        $response->assertStatus(302);
        $response->assertRedirect('/adminPanel');
        $response->assertSessionHas('success', 'Quiz został zaktualizowany pomyślnie!');

        $latest = Quiz::latest()->first();
        $quiz_id = $latest->id;

        foreach ($data['options'] as $key => $value) {
            $this->assertDatabaseHas('questions', [
                'quiz_id' => $latest->id,
                'question' => $value,
            ]);

            $question = Question::where('quiz_id', $latest->id)
                ->where('question', $value)
                ->first();

            $this->assertNotNull($question);
            $this->assertNotNull($question->image);
        }
    }
}
