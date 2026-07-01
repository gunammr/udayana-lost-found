<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LostItemController;
use App\Http\Controllers\ProfileController;

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

});

require __DIR__.'/auth.php';
