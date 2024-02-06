<?php

namespace Database\Seeders;

use App\Models\Apply;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(UsersSeeder::class);
        $this->call(FamilySeeder::class);
        $this->call(CycleSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(OfferSeeder::class);
        $this->call(ApplySeeder::class);
    }
}
