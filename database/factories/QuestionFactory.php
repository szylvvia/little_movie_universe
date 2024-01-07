<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{

    public function definition(): array
    {
        return [
            'question' => $this->faker->sentence,
            'image' => $this->faker->imageUrl(),
        ];
    }
}
