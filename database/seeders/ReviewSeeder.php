<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Booking;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $booking = Booking::first();

        if ($booking && !$booking->review) {
            Review::firstOrCreate([
                'booking_id' => $booking->id,
            ], [
                'rating' => rand(3, 5),
                'review' => 'تجربة رائعة، أوصي بالحضور!',
            ]);
        }
    }
}
