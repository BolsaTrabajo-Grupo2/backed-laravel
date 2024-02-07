<?php

namespace Database\Seeders;

use App\Models\Apply;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Apply::factory()->count(30)->create();
    }
}
