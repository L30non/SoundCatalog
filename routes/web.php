<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SoundController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('sounds.index');
    }
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {


    Route::get('/sounds/{id}/edit', function () {
        $sounds = \App\Models\Sound::where('status', 'approved')->get();
        $categories = \App\Models\Category::all();
        return view('sounds.edit', compact('sounds', 'categories'));
    })->name('pending');

    Route::get('/sounds/pending', function () {
        $sounds = \App\Models\Sound::where('status', 'pending')->get();
        return view('sounds.pending', compact('sounds'));
    })->name('pending');

    

    Route::get('/sounds/approve/{id}', [AdminController::class, 'approve'])->name('admin.sounds.approve');
    Route::get('/sounds/deny/{id}', [AdminController::class, 'deny'])->name('admin.sounds.deny');

    Route::resource('sounds', SoundController::class);
    Route::get('/dashboard', function () {
        return redirect()->route('sounds.index');
    })->name('home');

    // Sound routes
    Route::get('/sounds/download/{id}', [SoundController::class, 'download'])->name('sounds.download');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
