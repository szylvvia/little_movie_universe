<?php

namespace Tests\Feature;


use App\Models\Artist;
use App\Models\Movie;
use App\Models\User;
use Database\Factories\ArtistFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MovieTest extends TestCase
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
        $response->assertSessionHas('success', 'Film was added successfully');
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
            'trailerLink' => 'The trailer link field must start with one of the following: https://www.youtube.com/watch?v=.',
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
        $response->assertSessionHas('error', 'Film already exist in database');
    }

    public function testDeleteMovieWhileMovieIsExist(): void
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();
        $this->actingAs($user);
        $response = $this->delete("movies/$movie->id");
        $response->assertStatus(302);
        $response->assertRedirect('/movies');
        $response->assertSessionHas('success', 'Your movie was delete');
    }

    public function testDeleteMovieWhileMovieIsNotExist(): void
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();
        $this->actingAs($user);
        $response = $this->delete("movies/$movie->id");
        $response->assertStatus(302);
        $response->assertRedirect('/movies');
        $response->assertSessionHas('success', 'Your movie was delete');
        $response = $this->delete("movies/$movie->id");
        $response->assertStatus(302);
        $response->assertRedirect('/movies');
        $response->assertSessionHas('error', "Movie with this ID doesn't exist!");


    }



}
