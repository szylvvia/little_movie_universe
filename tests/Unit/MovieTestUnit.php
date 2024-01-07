<?php

namespace Tests\Unit;


use App\Models\Artist;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MovieTestUnit extends TestCase
{
    use DatabaseTransactions;

    public function testAddMovieWhileDataIsValid(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/addMovie');
        $response->assertStatus(200);
        $artist = Artist::factory()->create();

        Storage::fake('public');
        $file = UploadedFile::fake()->image('poster.jpg');

        $movie =
            [
                'title' => "Test Movie",
                'releaseDate' => "1999-01-01",
                'description' => "Test description",
                'trailerLink' => 'https://www.youtube.com/watch?v=n9xhJrPXop4',
                'soundtrackLink' => 'https://open.spotify.com/album/1S9Q03SzyIGJDXliugViXX?si=9768bd7f23ce4232',
                'status' => "pending",
                'poster' => $file,
                'background' => $file,
                'images' => [$file],
                'artists' => [$artist->id],
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now()
            ];
        $response = $this->post('/addMovie',$movie);
        $response->assertStatus(302);
        $response->assertRedirect('/movies');
        $response->assertSessionHas('success', 'Film został dodany pomyślnie.');
    }

    public function testAddMovieWhileTrailerLinkIsInvalid(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/addMovie');
        $response->assertStatus(200);
        $artist = Artist::factory()->create();

        Storage::fake('public');
        $file = UploadedFile::fake()->image('poster.jpg');

        $movie =
            [
                'title' => "Test Movie",
                'releaseDate' => "1999-01-01",
                'description' => "Test description",
                'trailerLink' => 'invalid trailer link',
                'soundtrackLink' => 'https://open.spotify.com/album/1S9Q03SzyIGJDXliugViXX?si=9768bd7f23ce4232',
                'status' => "pending",
                'poster' => $file,
                'background' => $file,
                'images' => [$file],
                'artists' => [$artist->id],
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now()
            ];

        $response = $this->post('/addMovie',$movie);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('trailerLink');

        $response->assertSessionHasErrors([
            'trailerLink' => "Pole link do trailera'a musi zaczynać się jednym z następujących: https://www.youtube.com/watch?v=.",
        ]);

    }

    public function testAddMovieWhileMovieIsDuplicated(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/addMovie');
        $response->assertStatus(200);
        $artist = Artist::factory()->create();

        Storage::fake('public');
        $file = UploadedFile::fake()->image('poster.jpg');

        $movie =
            [
                'title' => "Test Movie",
                'releaseDate' => "1999-01-01",
                'description' => "Test description",
                'trailerLink' => 'https://www.youtube.com/watch?v=n9xhJrPXop4',
                'soundtrackLink' => 'https://open.spotify.com/album/1S9Q03SzyIGJDXliugViXX?si=9768bd7f23ce4232',
                'status' => "pending",
                'poster' => $file,
                'background' => $file,
                'images' => [$file],
                'artists' => [$artist->id],
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now()
            ];

        $response = $this->post('/addMovie',$movie);
        $response->assertStatus(302);
        $response = $this->post('/addMovie',$movie);
        $response->assertStatus(302);
        $response->assertSessionHas('error', 'Film już istnieje w bazie danych!');
    }

    public function testDeleteMovieWhileMovieIsExist(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $movie = Movie::factory()->create(
            [
                'user_id' => $user->id,
            ]
        );
        $response = $this->delete("movies/$movie->id");
        $response->assertStatus(302);
        $response->assertRedirect('/movies');
        $response->assertSessionHas('success', 'Film został usunięty pomyślnie.');
    }

    public function testDeleteMovieWhileMovieIsNotExist(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $movie = Movie::factory()->create(
            [
                'user_id' => $user->id,
            ]
        );
        $movie_id = $movie->id;

        $response = $this->delete("movies/$movie->id");
        $response->assertStatus(302);
        $response->assertRedirect('/movies');
        $response->assertSessionHas('success', 'Film został usunięty pomyślnie.');
        $response = $this->delete("movies/$movie_id");
        $response->assertStatus(302);
        $response->assertRedirect('/movies');
        $response->assertSessionHas('error', "Wybrany film nie istnieje!");
    }

}
