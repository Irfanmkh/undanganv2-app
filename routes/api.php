<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// route auth
Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);

});


// route superadmin
Route::middleware(['auth:sanctum', 'super_admin'])->group(function () {
    
    Route::resource('akun', \App\Http\Controllers\SuperAdminController::class);
    
});


// route pengantin
Route::resource('invitations', \App\Http\Controllers\InvitationController::class);

// Route RSVP
Route::get('rsvp/{slug}', \App\Http\Controllers\RsvpController::class . '@show');
Route::get('rsvp/tamu/{id}', \App\Http\Controllers\RsvpController::class . '@showdetail');
Route::post('rsvp', \App\Http\Controllers\RsvpController::class . '@store');
Route::put('rsvp/{id}', \App\Http\Controllers\RsvpController::class . '@update');
Route::delete('rsvp/{id}', \App\Http\Controllers\RsvpController::class . '@destroy');
