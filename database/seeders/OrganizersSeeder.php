<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organizer;
use App\Models\User;

class OrganizersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch users to link organizers with existing user IDs
        $khaled = User::where('email', 'khaled.admin@example.com')->first();
        $mohammed = User::where('email', 'mohammed.branch@example.com')->first();
        $ali = User::where('email', 'ali.imam@example.com')->first();
        $asem = User::where('email', 'asem.quran@example.com')->first();

        $organizers = [
            [
                'user_id' => $khaled ? $khaled->id : null,
                'company_name' => 'Khaled Events',
                'bio' => 'Experienced event planner specializing in large-scale community events in Casablanca.',
                'website' => 'https://khaledevents.ma',
            ],
            [
                'user_id' => $mohammed ? $mohammed->id : null,
                'company_name' => 'Rabat Conventions',
                'bio' => 'Organizing professional conferences and workshops in Rabat.',
                'website' => 'https://rabatconventions.ma',
            ],
            [
                'user_id' => $ali ? $ali->id : null,
                'company_name' => 'Fes Cultural Hub',
                'bio' => 'Dedicated to cultural and religious events in the historic city of Fes.',
                'website' => 'https://fesculturalhub.ma',
            ],
            [
                'user_id' => $asem ? $asem->id : null,
                'company_name' => 'Marrakech Quran Academy',
                'bio' => 'Hosting Quranic recitation events and tajweed workshops in Marrakech.',
                'website' => 'https://marrakechquran.ma',
            ],
        ];

        foreach ($organizers as $organizer) {
            // Only create if user_id exists
            if ($organizer['user_id']) {
                Organizer::firstOrCreate(
                    [
                        'user_id' => $organizer['user_id'],
                    ],
                    $organizer
                );
            }
        }
    }
}