<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
 
Route::group(['middleware' => 'auth:api'], function(){
    Route::apiResource('organizers', OrganizerController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('events', EventController::class);
    Route::apiResource('bookings', BookingController::class);
    Route::apiResource('tickets', TicketController::class);
    Route::apiResource('reviews', ReviewController::class);

    Route::apiResource('users', UserController::class);
    
    Route::post('logout', [AuthController::class, 'logout']);   // User logout
    Route::get('user', [AuthController::class, 'userInfo']);  // Get user info
    Route::post('change-password', [AuthController::class, 'changePassword']);  // Change password
});

// Route::get('/user', function (Request $request) {return $request->user();})->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']); // User registration
Route::post('/login', [AuthController::class, 'login']);



// use App\Models\Category;

 //Route::get('/categories', function () {$categories = Category::all();return response()->json($categories); // إرجاع الفئات على شكل JSON
 //});
 

 Route::get('/tickets/download-pdf', [TicketController::class, 'downloadPdf'])->middleware('auth:api');






// Route::resource('organizers', OrganizerController::class);

// Route::get('organizers', function(){
//     return "aa";
// });



Route::fallback(function () {
    return response()->json([
        'errors' => 'Endpoint not found.',
        'toastmessage' => 'Endpoint not found.',
    ], 404);
});