<?php

namespace Database\Factories;

use Faker\Provider\Address;
use Faker\Provider\Internet;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create();

        return [
            'CIF' => $this->GenerateCif(),
            'address'     => $faker->streetAddress(),
            'phone' => $faker->numerify('#########'),
            'web'  => $faker->url(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
    private function generateCif(): string
    {
        $letters = 'ABCDEFGHJKLMNPQRSUVW';
        $letter = $letters[rand(0, strlen($letters) - 1)];
        $number = mt_rand(10000000, 99999999);
        return $letter . str_pad($number, 8, '0', STR_PAD_LEFT);
    }

}
