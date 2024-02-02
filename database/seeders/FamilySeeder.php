<?php

namespace Database\Seeders;



use App\Models\Family;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class FamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = public_path('storage/families.json');
        $jsonContent = file_get_contents($jsonPath);
        $json = json_decode($jsonContent, true);

            foreach ($json as $familyData) {
                Family::create([
                    'id' => $familyData['id'],
                    'name' => $familyData['name'],
                ]);
            }


    }
}
