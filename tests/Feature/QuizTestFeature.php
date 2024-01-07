<?php

namespace Tests\Feature;

use App\Http\Controllers\QuizController;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;


class QuizTestFeature extends TestCase
{
    use DatabaseTransactions;

    public function testAddQuizWhenDataIsValidAndUserIsAdmin()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Storage::fake('public');

        $files = [
            UploadedFile::fake()->image('image1.jpg'),
            UploadedFile::fake()->image('image2.jpg'),
            UploadedFile::fake()->image('image3.jpg'),
        ];

        $quizData = [
            'title' => 'Quiz Quiz Quiz Quiz',
            'description' => 'Test quiz',
            'start_date' => now()->addDays(199)->format('Y-m-d'),
            'end_date' => now()->addDays(210)->format('Y-m-d'),
            'user_id' => $admin->id,
            'images' => $files,
            'options' => ['Pytanie 1', 'Pytanie 2', 'Pytanie 3'],
        ];

        $this->mock(QuizController::class, function ($mock) {
            $mock->shouldReceive('resizeImage')->andReturn('resized_image.jpg');
            $mock->shouldIgnoreMissing();
        });
        $response = $this->actingAs($admin)->post(route('addQuiz'), $quizData);
        $response->assertStatus(200);
        dd($response);
//        $response->assertRedirect(route('showAdminPanel'));
//        $response->assertSessionHas('success','Quiz został dodany pomyślnie.');
    }

}
