<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(9)->create([
            'rol' => 'ADM'
        ]);
        User::factory()->count(15)->create([
            'rol' => 'RESP'
        ]);
    }
}
