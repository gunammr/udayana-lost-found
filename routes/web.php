<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FoundItemController;
use App\Http\Controllers\LostItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MyClaim;

// Atau jika nama file controllernya adalah MyClaimController:
// use App\Http\Controllers\MyClaimController;

Route::get('/', [LandingController::class, 'index'])->name('home');

Route::get('/barang-hilang', [LostItemController::class, 'index'])
    ->name('lost-items.index');

Route::get('/barang-hilang/lapor', [LostItemController::class, 'create'])
    ->name('lost-items.create');

Route::post('/barang-hilang', [LostItemController::class, 'store'])
    ->name('lost-items.store');

Route::get('/barang-hilang/{lostItem}', [LostItemController::class, 'show'])
    ->name('lost-items.show');

Route::get('/barang-ditemukan', [FoundItemController::class, 'index'])
    ->name('found-items.index');

Route::get('/barang-ditemukan/lapor', [FoundItemController::class, 'create'])
    ->name('found-items.create');

Route::post('/barang-ditemukan', [FoundItemController::class, 'store'])
    ->name('found-items.store');

Route::get('/barang-ditemukan/{foundItem}', [FoundItemController::class, 'show'])
    ->name('found-items.show');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'editCustom'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'updateCustom'])
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
