<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\PetugasController;
use Illuminate\Support\Facades\Route;

// =======================
// HALAMAN AWAL
// =======================
Route::get('/', function () {
    return view('auth.login');
});

// =======================
// REDIRECT SETELAH LOGIN (FIX SEMUA ROLE)
// =======================
Route::get('/dashboard', function () {

    if (auth()->user()->role == 'admin') {
        return redirect()->route('admin.dashboard');
    } 
    
    elseif (auth()->user()->role == 'petugas') {
        return redirect()->route('petugas.dashboard');
    }

    return redirect()->route('peminjam.dashboard');

})->middleware(['auth'])->name('dashboard');


// =======================
// PROFILE (SEMUA USER)
// =======================
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});


// =======================
// ROUTE ADMIN
// =======================
Route::middleware(['auth', 'role:admin'])
->prefix('admin')
->name('admin.')
->group(function () {

    // DASHBOARD
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // ===== KATEGORI =====
    Route::get('/kategori', [AdminController::class, 'kategori'])->name('kategori');
    Route::post('/kategori', [AdminController::class, 'storeKategori'])->name('kategori.store');
    Route::delete('/kategori/{id}', [AdminController::class, 'destroyKategori'])->name('kategori.destroy');
    Route::get('/kategori/{id}/edit', [AdminController::class, 'editKategori'])->name('kategori.edit');
    Route::put('/kategori/{id}', [AdminController::class, 'updateKategori'])->name('kategori.update');

    Route::get('/kategori/cetak', function () {
        $kategoris = \App\Models\Kategori::all();
        return view('admin.kategori_cetak', compact('kategoris'));
    })->name('kategori.cetak');


    // ===== ALAT =====
    Route::get('/alat', [AdminController::class, 'alat'])->name('alat');
    Route::post('/alat', [AdminController::class, 'storeAlat'])->name('alat.store');
    Route::delete('/alat/{id}', [AdminController::class, 'destroyAlat'])->name('alat.destroy');
    Route::get('/alat/{id}/edit', [AdminController::class, 'editAlat'])->name('alat.edit');
    Route::put('/alat/{id}', [AdminController::class, 'updateAlat'])->name('alat.update');

    Route::get('/alat/cetak', function () {
        $alats = \App\Models\Alat::with('kategori')->get();
        return view('admin.alat_cetak', compact('alats'));
    })->name('alat.cetak');


    // ===== USER =====
    Route::get('/user', [AdminController::class, 'user'])->name('user');
    Route::post('/user', [AdminController::class, 'storeUser'])->name('user.store');
    Route::delete('/user/{id}', [AdminController::class, 'destroyUser'])->name('user.destroy');
    Route::get('/user/{id}/edit', [AdminController::class, 'editUser'])->name('user.edit');
    Route::put('/user/{id}', [AdminController::class, 'updateUser'])->name('user.update');

    Route::get('/user/cetak', function () {
        $users = \App\Models\User::all();
        return view('admin.user_cetak', compact('users'));
    })->name('user.cetak');


    // ===== PEMINJAMAN =====
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');
    Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');

    Route::get('/peminjaman/cetak', function () {
        $peminjamans = \App\Models\Peminjaman::with(['user', 'alat'])->get();
        return view('admin.peminjaman_cetak', compact('peminjamans'));
    })->name('peminjaman.cetak');

});


// =======================
// ROUTE PETUGAS (BARU)
// =======================
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    
    // Tampilan Dashboard
    Route::get('/dashboard', [PetugasController::class, 'petugas'])->name('dashboard');
    
    // Proses Approve ditaruh di PetugasController sesuai kodingan terbaru kamu
    Route::post('/approve/{id}', [PetugasController::class, 'approve'])->name('approve');

    // Untuk Tolak dan Kembali, pastikan fungsinya sudah ada di PetugasController juga
    Route::post('/tolak/{id}', [PetugasController::class, 'tolak'])->name('tolak');
    Route::post('/kembali/{id}', [PetugasController::class, 'kembali'])->name('kembali');
});


// =======================
// ROUTE PEMINJAM
// =======================
Route::middleware(['auth', 'role:peminjam'])
->prefix('peminjam')
->name('peminjam.')
->group(function () {

    Route::get('/dashboard', [PeminjamController::class, 'index'])->name('dashboard');

    Route::post('/pinjam', [PeminjamController::class, 'store'])->name('pinjam.store');

});

require __DIR__.'/auth.php';