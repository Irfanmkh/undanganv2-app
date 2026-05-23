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

    // reply komen
    Route::post('rsvp/comments/reply/{rsvp_id}', [\App\Http\Controllers\RsvpRepliesController::class, 'storeReply']);
    Route::put('rsvp/comments/reply/{reply_id}', [\App\Http\Controllers\RsvpRepliesController::class, 'updateReply']);
    Route::delete('rsvp/comments/reply/{reply_id}', [\App\Http\Controllers\RsvpRepliesController::class, 'destroyReply']);
    Route::get('rsvp/comments/reply/{rsvp_id}', [\App\Http\Controllers\RsvpRepliesController::class, 'showReply']);

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


// Route RSVP publik
Route::post('rsvp', [\App\Http\Controllers\RsvpController::class, 'store']);
Route::post('rsvp/like/{id}', [\App\Http\Controllers\PublicRsvpController::class, 'like']);
Route::post('rsvp/like/reply/{id}', [\App\Http\Controllers\PublicRsvpController::class, 'likeReply']);
Route::put('rsvp/{id}', [\App\Http\Controllers\PublicRsvpController::class, 'update']);
Route::get('rsvp/comments/{invitation_id}', [\App\Http\Controllers\RsvpController::class, 'showPesan']);
