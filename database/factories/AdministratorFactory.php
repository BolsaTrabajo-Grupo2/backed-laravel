<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AdministratorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'surname'     => $this->faker->company,
            'email'     => $this->faker->email,
            'status'    => $this->faker->randomElement(['new', 'good', 'used', 'bad']),
            'photo'     => $this->faker->imageUrl(200, 200),
            'password'  => static::$password ??= Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
