<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Category;
use App\Models\Organizer;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $organizer = Organizer::first(); // نجيبو أول منظم
        $category = Category::first();   // نجيبو أول تصنيف

        Event::create([
            'organizer_id' => 1,
            'category_id' => 1,
            'title' => 'تظاهرة رياضية كبرى',
            'description' => 'وصف بسيط للتظاهرة الرياضية.',
            'tags' => ['رياضة', 'ترفيه'],
            'image_url' => 'https://via.placeholder.com/150',
            'start_date' => now()->addDays(3),
            'end_date' => now()->addDays(5),
            'price' => 50.00,
            'status' => 'upcoming',
            'is_approved' => true,
        ]);
    }
}
