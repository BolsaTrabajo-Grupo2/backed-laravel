<?php

namespace Database\Seeders;

use App\Models\Apply;
use App\Models\Assigned;
use App\Models\Offer;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        $maxAttempts = 1000;
        $attempts = 0;
        $count = 0;

        while ($count < 30 && $attempts < $maxAttempts) {
            $idUser = Student::inRandomOrder()->pluck('id')->first();
            $student = Student::find($idUser);
            $cycleIds = $student->studies()->pluck('id_cycle')->toArray();

            $idOffer = Assigned::whereIn('id_cycle', $cycleIds)
                ->inRandomOrder()
                ->pluck('id_offer')
                ->first();

            if ($idOffer !== null) {
                $offer = Offer::find($idOffer);
                if ($offer->inscription_method) {
                    if (!Apply::where('id_offer', $idOffer)->where('id_student', $idUser)->exists()) {
                        Apply::create([
                            'id_offer' => $idOffer,
                            'id_student' => $idUser,
                        ]);
                        $count++;
                        $attempts = 0;
                    } else {
                        $attempts++;
                    }
                } else {
                    $attempts++;
                }
            } else {
                $attempts++;
            }
        }

    }

}
