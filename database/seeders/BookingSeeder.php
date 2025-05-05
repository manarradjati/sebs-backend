<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\User;
use App\Models\Event;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first(); // جلب أول مستخدم
        $event = Event::first(); // جلب أول حدث

        Booking::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'count' => 2,  // استخدم "count" هنا وليس "number_of_tickets"
            'total_price' => 100.00,
            'status' => 'confirmed',
            'payment_method' => 'credit_card',
            'payment_status' => 'paid',
        ]);
    }
}
