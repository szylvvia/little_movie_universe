<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class QuizTestUnit extends TestCase
{
    use DatabaseTransactions;

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
        $response->assertSessionHasErrors(['end_date' => 'Pole data zakończenia musi być datą po data rozpoczęcia.']);
    }
}
