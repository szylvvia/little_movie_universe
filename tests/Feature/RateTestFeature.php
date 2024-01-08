<?php

namespace Tests\Feature;

use App\Models\Artist;
use App\Models\Movie;
use App\Models\Question;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RateTestFeature extends TestCase
{
    use DatabaseTransactions;

    public function testAddRateAndReviewToMovieWhenDataIsValidAndUserIsLoginIn()
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
                'user_id' => $user->id,
                'movie_id' => $movie->id,
                'rate' => 5,
                'review' => 'nice'
            ];

        $response = $this->post('movies/'.$movie->id, $rateAndReview);
        $response->assertStatus(302);
        $response->assertRedirect('/movies/'.$movie->id);
        $response->assertSessionHas('success', 'Ocena została zaktualizowana pomyślnie.');

        $this->assertDatabaseHas('rates', [
                'movie_id' => $movie->id,
                'user_id' => $user->id,
                'rate' => 5,
                'review' => 'nice'
            ]);
    }
}
