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


Route::middleware('auth', 'verified')->group(function () {
    Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');
    Route::get('/rooms/{room}/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/rooms/{room}/messages', [MessageController::class, 'store'])->name('messages.store');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
