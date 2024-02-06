<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cif = Company::inRandomOrder()->pluck('CIF')->first();
        $company = Company::where('CIF', $cif)->first();
        $responsible_name = $company->user->name;
        return [
            'description' => $this->faker->sentence(10),
            'duration' => $this->faker->randomElement(['Jornada completa', 'Jordana partida', 'Jornada flexible']),
            'responsible_name' => $responsible_name,
            'inscription_method' => $this->faker->boolean(),
            'status' => true,
            'cif' => $cif,
        ];
    }
}
