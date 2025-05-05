<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Ticket;
use Illuminate\Support\Str;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $bookings = Booking::all();

        foreach ($bookings as $booking) {
            for ($i = 0; $i < $booking->number_of_tickets; $i++) {
                Ticket::firstOrCreate([
                    'booking_id' => $booking->id,
                    'ticket_number' => strtoupper(Str::random(10)),
                ], [
                    'status' => 'active',
                    'qr_code_image' => null,
                    'qr_code_pdf' => null,
                ]);
            }
        }
    }
}
