<?php

namespace Database\Seeders;

use App\Models\Cycle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CycleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtenir el path del fitxer JSON
        $filePath = public_path('storage/ciclos.json');

        // Llegir i decodificar el fitxer JSON
        $jsonContent = json_decode(file_get_contents($filePath), true);

        // Accedir a les dades del JSON
        $coursesData = $jsonContent[2]['data'];

        // Inserir les dades a la taula
        foreach ($coursesData as $courseData) {
            Cycle::create([
                'id' => $courseData['id'],
                'id_family' => $courseData['id_family'],
                'cycle' => $courseData['ciclo'],
                'title' => $courseData['titol'],
                'id_responsible' => 1,
                'vliteral' => $courseData['vliteral'],
                'cliteral' => $courseData['cliteral']
            ]);
        }
    }
}
