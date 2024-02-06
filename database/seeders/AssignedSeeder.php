<?php

namespace Database\Seeders;

use App\Models\Assigned;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssignedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Assigned::factory()->count(30)->create();
    }
}
