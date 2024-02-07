<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Student;
use App\Models\Study;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $user = User::factory()->create([
                'rol' => 'STU'
            ]);
            $student = Student::factory()->create([
                'id_user' =>  $user->id
            ]);
            Study::factory()->create([
               'id_student' => $student->id
            ]);
        }
    }
}
