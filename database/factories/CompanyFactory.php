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
            'company_name' => $faker->company,
            'address'     => $faker->streetAddress(),
            'CP' => $this->generateCP(),
            'phone' => $faker->numerify('#########'),
            'web'  => $faker->regexify('^https?://(www\.)?[a-zA-Z0-9]{1,100}\.[a-z]{2,4}$'),
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
    function generateCP()
    {
        $FirstCP = 10000;
        $LastCP = 99999;

        $CP = rand($FirstCP, $LastCP);

        $CPFormated = str_pad($CP, 5, '0', STR_PAD_LEFT);

        return $CPFormated;
    }

}
