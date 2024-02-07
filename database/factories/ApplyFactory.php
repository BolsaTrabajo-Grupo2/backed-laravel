<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Offer;
use App\Models\Student;
use Database\Seeders\OfferSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Apply>
 */
class ApplyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $idUser = Student::inRandomOrder()->pluck('id')->first();
        $idOffer = Offer::inRandomOrder()->pluck('id')->first();
        return [
            'id_offer' => $idOffer,
            'id_student' => $idUser,
        ];
    }
}
