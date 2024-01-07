<?php

namespace Tests\Unit;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTestUnit extends TestCase
{
    use DatabaseTransactions;

    public function testShowAdminPanelWhenUserIsNotAdmin()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get("/adminPanel");
        $response->assertStatus(302);
        $response->assertRedirect('/');
        $response->assertSessionHas('error', 'Dostęp tylko dla administatora');
    }
    public function testShowAdminPanelWhenUserIsAdmin()
    {
        $admin = User::factory()->create(
            [
                'role' => 'admin'
            ]
        );
        $this->actingAs($admin);
        $response = $this->get("/adminPanel");
        $response->assertStatus(200);
    }

    public function testVerifyMovieByDecisionVerifiedWhenUserIsAdmin()
    {
        $admin = User::factory()->create(
            [
                'role' => 'admin'
            ]
        );
        $movie = Movie::factory()->create();
        $decision =
            [
                'decision'=>'verified',
                'id' => $movie->id,
            ];
        $this->actingAs($admin);
        $response = $this->post("/verifyMovie",$decision);
        $response->assertStatus(302);
        $response->assertRedirect('/adminPanel');
        $response->assertSessionHas('success', 'Film został pomyślnie zaakceptowany.');
    }
    public function testVerifyMovieByDecisionVerifiedWhenUserIsNotAdmin()
    {
        $admin = User::factory()->create();
        $movie = Movie::factory()->create();
        $decision =
            [
                'decision'=>'verified',
                'id' => $movie->id,
            ];
        $this->actingAs($admin);
        $response = $this->post("/verifyMovie",$decision);
        $response->assertStatus(302);
        $response->assertRedirect('/');
        $response->assertSessionHas('error', 'Dostęp tylko dla administratora');
    }
}
