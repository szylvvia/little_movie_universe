<?php

namespace Tests\Unit;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RateUnitTest extends TestCase
{
    use DatabaseTransactions;

    public function testAddRateAndReviewToMovieWhenDataIsInValidAndUserIsLoginIn()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $movie = Movie::factory()->create();
        $rateAndReview = ['rate' => 11, 'review' => 'nice'];

        $response = $this->post('movies/'.$movie->id, $rateAndReview);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('rate', 'Pole ocena nie może być większe niż 10.');
    }

    public function testAddRateAndReviewToMovieWhenDataIsValidAndUserIsNotLoginIn()
    {
        $movie = Movie::factory()->create();
        $rateAndReview = ['rate' => 10, 'review' => 'good'];

        $response = $this->post('movies/'.$movie->id, $rateAndReview);
        $response->assertStatus(302);
        $response->assertRedirect('/');
        $response->assertSessionHas('error', 'Dostępne tylko dla zalogowanych');
    }

    public function testAddRateAndReviewToMovieWhenDataIsValidAndUserIsLoginIn()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $movie = Movie::factory()->create([ 'user_id' => $user->id]);
        $rateAndReview = ['rate' => 5, 'review' => 'nice'];

        $response = $this->post('movies/'.$movie->id, $rateAndReview);
        $response->assertStatus(302);
        $response->assertRedirect('/movies/'.$movie->id);
        $response->assertSessionHas('success', 'Ocena i recenzja została dodana pomyślnie.');

        $this->assertDatabaseHas('rates', [
            'movie_id' => $movie->id,
            'user_id' => $user->id,
            'rate' => 5,
            'review' => 'nice'
        ]);
    }
}
