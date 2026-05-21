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


    // preview undangan
    Route::resource('data-undangan/rsvp', \App\Http\Controllers\RsvpController::class)->only(['index', 'destroy', 'show', 'update']);
    Route::resource('data-undangan', \App\Http\Controllers\InvitationController::class);

    // RSVP

    // change password & logout
    Route::post('change-password', [\App\Http\Controllers\AuthController::class, 'updatePassword']);
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
});


// route superadmin
Route::middleware(['auth:sanctum', 'super_admin'])->group(function () {

    Route::resource('akun', \App\Http\Controllers\SuperAdminController::class);
});


// route akses undangan publilk
Route::get('{slug}/{invitation_id}', [\App\Http\Controllers\PublicInvitationController::class, 'show']);


// Route RSVP
Route::post('rsvp', [\App\Http\Controllers\RsvpController::class, 'store']);
Route::get('rsvp/comments/{invitation_id}', [\App\Http\Controllers\RsvpController::class, 'showPesan']);
