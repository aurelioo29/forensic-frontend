<?php

use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) return redirect()->route('dashboard');

    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [PhotoController::class, 'index'])->name('dashboard');

    Route::get('/upload', [PhotoController::class, 'create'])->name('photos.create');
    Route::post('/upload', [PhotoController::class, 'store'])->name('photos.store');

    Route::get('/photos/{photo}', [PhotoController::class, 'show'])->name('photos.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
