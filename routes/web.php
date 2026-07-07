<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FoundItemController;
use App\Http\Controllers\LostItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MyClaim;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClaimController;

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

    // Ajukan klaim barang ditemukan
    Route::post('/barang-ditemukan/{foundItem}/klaim', [ClaimController::class, 'store'])
        ->name('claims.store');
    
    Route::get('/profile', [ProfileController::class, 'editCustom'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'updateCustom'])
        ->name('profile.update');
        
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->name('dashboard.admin');

    Route::get('/admin/barang-hilang', [LostItemController::class, 'adminIndex'])
        ->name('admin.lost-items.index');

    Route::get('/admin/barang-hilang/{lostItem}/edit', [LostItemController::class, 'edit'])
        ->name('admin.lost-items.edit');

    Route::put('/admin/barang-hilang/{lostItem}', [LostItemController::class, 'update'])
        ->name('admin.lost-items.update');

    Route::delete('/admin/barang-hilang/{lostItem}', [LostItemController::class, 'destroy'])
        ->name('admin.lost-items.destroy');

    Route::get('/admin/barang-ditemukan', [FoundItemController::class, 'adminIndex'])
        ->name('admin.found-items.index');

    Route::get('/admin/barang-ditemukan/{foundItem}/edit', [FoundItemController::class, 'edit'])
        ->name('admin.found-items.edit');

    Route::put('/admin/barang-ditemukan/{foundItem}', [FoundItemController::class, 'update'])
        ->name('admin.found-items.update');

    Route::delete('/admin/barang-ditemukan/{foundItem}', [FoundItemController::class, 'destroy'])
        ->name('admin.found-items.destroy');

    Route::get('/admin/kategori', [CategoryController::class, 'index'])
        ->name('admin.categories.index');
    
    Route::get('/admin/users', [UserController::class, 'index'])
        ->name('admin.users.index');

    Route::post('/admin/users', [UserController::class, 'store'])
        ->name('admin.users.store');

    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])
        ->name('admin.users.edit');

    Route::put('/admin/users/{user}', [UserController::class, 'update'])
        ->name('admin.users.update');

    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])
        ->name('admin.users.destroy');

    Route::get('/admin/claims', [ClaimController::class, 'index'])
        ->name('admin.claims.index');

    Route::patch('/admin/claims/{claim}/verify', [ClaimController::class, 'verify'])
        ->name('admin.claims.verify');

    Route::patch('/admin/claims/{claim}/reject', [ClaimController::class, 'reject'])
        ->name('admin.claims.reject');
    // Tulis ini di baris paling bawah file routes/web.php Anda
});

require __DIR__.'/auth.php';
