<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ReviewController;

Route::middleware('api')->group(function () {
    Route::apiResource('organizers', OrganizerController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('events', EventController::class);
    Route::apiResource('bookings', BookingController::class);
    Route::apiResource('tickets', TicketController::class);
    Route::apiResource('reviews', ReviewController::class);
});


// use App\Models\Category;

// Route::get('/categories', function () {
//     $categories = Category::all();
//     return response()->json($categories); // إرجاع الفئات على شكل JSON
// });
 







// Route::resource('organizers', OrganizerController::class);

// Route::get('organizers', function(){
//     return "aa";
// });
