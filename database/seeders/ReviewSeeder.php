<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Maak 10 reviews aan via de factory
        Review::factory()->count(10)->create();
    }
}
