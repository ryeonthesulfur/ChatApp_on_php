<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('rooms.index')
        : redirect()->route('login');
});

Route::get('/rooms', [RoomController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('rooms.index');

Route::get('/rooms/{room}/messages', [MessageController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('messages.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
