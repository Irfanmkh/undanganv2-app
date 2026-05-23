<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




// Kita bikin rute khusus untuk tes oper data
Route::get('/tes-props', function () {
    return Inertia::render('TesUndangan', [
        'namaPria' => 'Irfan sdsd',
        'namaWanita' => 'Loventa'
    ]);
});

Route::get(
    '/undangan/{slug}',
    function ($slug) {
        // Anggap saja kita mengambil data undangan dari database berdasarkan slug
        // Untuk tes sekarang, kita hardcode dulu datanya
        return Inertia::render('HalamanUndangan', [
            'slug' => $slug,
            'namaPengantinPria' => 'Irfan',
            'namaPengantinWanita' => 'Loventa'
        ]);
    }
);









require __DIR__ . '/auth.php';
