<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', function() {
    return view('main');
})->where('any', '^(?!api\/).*');

// Route::get('/', function () {
//     return view('welcome');
// });


// use App\Http\Controllers\FrontendController;
 


// Route::get('/events', [FrontendController::class, 'eventsList'])->name('events.list');

// Route::get('/event/{id}', [FrontendController::class, 'eventDetail'])->name('event.detail');
// use App\Models\Category;

// Route::get('/categories', function () {
//     $categories = Category::all();
//     return response()->json($categories); // إرجاع الفئات على شكل JSON
// });
 
