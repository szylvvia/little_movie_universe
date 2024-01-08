<?php

namespace Tests\Unit;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RateTestUnit extends TestCase
{
    use DatabaseTransactions;

    public function testAddRateAndReviewToMovieWhenDataIsInValidAndUserIsLoginIn()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $movie = Movie::factory()->create(
            [
                'user_id' => $user->id,
            ]
        );
        $rateAndReview =
            [
                'rate' => 11,
                'review' => 'nice'
            ];

        $response = $this->post('movies/'.$movie->id, $rateAndReview);
        $response->assertStatus(302);
        $response->assertRedirect('movies/'.$movie->id);
        $response->assertSessionHas('success', 'Ocena została zaktualizowana pomyślnie.');

    }
}
