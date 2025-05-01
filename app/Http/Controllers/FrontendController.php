<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class FrontendController extends Controller
{
    public function eventsList()
    {
        $events = Event::with(['organizer', 'category'])->get(); // نجيبو كل الأحداث مع العلاقات
        return view('events', compact('events')); // نرجعوهم للواجهة
    }
    public function eventDetail($id)
{
    $event = Event::with(['organizer', 'category'])->findOrFail($id);
    return view('event_detail', compact('event'));
}

}
