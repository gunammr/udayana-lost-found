<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LostItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MyClaim;

// Atau jika nama file controllernya adalah MyClaimController:
// use App\Http\Controllers\MyClaimController;

Route::get('/', [LandingController::class, 'index'])->name('home');

Route::get('/barang-hilang', [LostItemController::class, 'create'])
    ->name('lost-items.create');

Route::post('/barang-hilang', [LostItemController::class, 'store'])
    ->name('lost-items.store');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::get('/klaim-saya', [MyClaim::class, 'index'])
     ->name('claims.index');
    
    Route::get('/klaim-saya/laporan', [MyClaim::class, 'laporan'])
        ->name('claims.laporan');
        
    Route::get('/klaim-saya/status', [MyClaim::class, 'status'])
        ->name('claims.status');
    
    Route::get('/profile', [ProfileController::class, 'editCustom'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'updateCustom'])
        ->name('profile.update');
        
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
    // Tulis ini di baris paling bawah file routes/web.php Anda
});

require __DIR__.'/auth.php';
