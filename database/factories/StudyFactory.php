<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Study>
 */
class StudyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $idCycles = DB::table('cycles')->pluck('id')->toArray();
        return [
            'id_cycle'=> $this->faker->randomElement($idCycles),
            'date' => $this->faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d'),
            'verified' => true,
        ];
    }
}
