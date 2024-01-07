<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->firstName,
            'email' => $this->faker->unique()->safeEmail,
            'surname' => $this->faker->lastName,
            'birth_date' => $this->faker->date,
            'password' => bcrypt('password'),
            'description' => $this->faker->paragraph,
            'image' => null,
            'background' => $this->faker->imageUrl(),
        ];
    }
}
