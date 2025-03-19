<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SoundController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('sounds.index');
    }
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('sounds.index');
    })->name('dashboard');
    Route::resource('sounds', SoundController::class);
    // Sound routes
    Route::get('/sounds/download/{id}', [SoundController::class, 'download'])->name('sounds.download');
    

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
