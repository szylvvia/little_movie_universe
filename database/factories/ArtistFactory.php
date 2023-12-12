<?php

namespace Database\Factories;

use App\Models\Artist;
use Illuminate\Database\Eloquent\Factories\Factory;


class ArtistFactory extends Factory
{
    protected $model = Artist::class;

    public function definition()
    {
        return [
            'name' => $this->faker->firstName,
            'surname' => $this->faker->lastName,
            'birth_date' => $this->faker->date,
            'death_date' => $this->faker->optional(0.2)->date,
            'description' => $this->faker->paragraph,
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'status' => $this->faker->randomElement(['verified']),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'profession' => $this->faker->word,
            'image' => $this->faker->imageUrl,
        ];
    }
}
