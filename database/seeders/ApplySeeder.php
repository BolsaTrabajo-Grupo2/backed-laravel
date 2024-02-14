<?php

namespace Database\Seeders;

use App\Models\Apply;
use App\Models\Offer;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        $maxAttempts = 1000; // Límite de intentos para evitar bucles infinitos
        $attempts = 0;
        $count = 0;

        while ($count < 30 && $attempts < $maxAttempts) {
            $idUser = Student::inRandomOrder()->pluck('id')->first();
            $idOffer = Offer::inRandomOrder()->pluck('id')->first();

            // Verificar si la combinación ya existe en la tabla applies
            if (!Apply::where('id_offer', $idOffer)->where('id_student', $idUser)->exists()) {
                Apply::create([
                    'id_offer' => $idOffer,
                    'id_student' => $idUser,
                ]);
                $count++; // Incrementar el contador de registros creados
                $attempts = 0; // Reiniciar el contador de intentos si se crea un registro único
            } else {
                $attempts++; // Incrementar el contador de intentos si la combinación ya existe
            }
        }
    }

}
