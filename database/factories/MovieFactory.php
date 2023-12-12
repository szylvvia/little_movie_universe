<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    protected $model = Movie::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'release_date' => $this->faker->date,
            'description' => $this->faker->paragraph,
            'trailer_link' => $this->faker->url,
            'soundtrack_link' => $this->faker->url,
            'poster' => $this->faker->imageUrl(),
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'status' => $this->faker->randomElement(['pending', 'verified']),
        ];
    }
}
