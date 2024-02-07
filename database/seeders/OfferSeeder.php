<?php

namespace Database\Seeders;

use App\Http\Controllers\Api\OfferApiController;
use App\Models\Assigned;
use App\Models\Offer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
            $offer = Offer::factory()->create();
            Assigned::factory([
                'idOffer' => $offer->id
            ])->create();
        }


    }
}
