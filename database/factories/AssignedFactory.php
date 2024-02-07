<?php

namespace Database\Factories;

use App\Models\Cycle;
use App\Models\Offer;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assigned>
 */
class AssignedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $idCycle = Cycle::inRandomOrder()->pluck('id')->first();
        $idOffer = Offer::inRandomOrder()->pluck('id')->first();
        return [
            'id_offer' => $idOffer,
            'id_cycle' => $idCycle,
        ];
    }
}
