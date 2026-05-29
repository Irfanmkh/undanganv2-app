<?php

use App\Http\Controllers\InvitationController;
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

    Route::post('/invitations/create', [InvitationController::class, 'store'])->name('invitation.store');
    Route::get('/invitations', [InvitationController::class, 'index'])->name('invitation.index');
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

Route::post('/undangan/rsvp', function (Request $request) {

    // 1. Validasi dulu data yang masuk dari Vue
    $request->validate([
        'nama_tamu'         => 'required|string|max:255',
        'status_kehadiran'  => 'required|in:Hadir,Tidak Hadir',
        'jumlah_rombongan'  => 'required|integer|min:1',
        'catatan_ucapan'    => 'required|string',
    ]);

    // 2. Kodingan Simpan ke Database
    // Sementara kita return back dulu untuk ngetes apakah Inertia mendeteksi sukses
    // Nanti di sini kita hubungkan ke Model/Controller RSVP asli punyamu kemarin

    return redirect()->back()->with('success', 'RSVP Berhasil dikirim!');
});









require __DIR__ . '/auth.php';
