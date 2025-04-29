<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganizerController;

Route::middleware('api')->group(function () {
    Route::apiResource('organizers', OrganizerController::class);
});







// Route::resource('organizers', OrganizerController::class);

// Route::get('organizers', function(){
//     return "aa";
// });
