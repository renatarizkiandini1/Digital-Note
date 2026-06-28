<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\AuthController;

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// App
Route::middleware('auth')->group(function () {
    Route::get('/', fn() => redirect()->route('dashboard'));
    Route::get('/dashboard', [NoteController::class, 'dashboard'])->name('dashboard');
    Route::resource('notes', NoteController::class);
    Route::get('/trash', [NoteController::class, 'trash'])->name('notes.trash');
    Route::post('/trash/{id}/restore', [NoteController::class, 'restore'])->name('notes.restore');
    Route::delete('/trash/{id}/force', [NoteController::class, 'forceDelete'])->name('notes.force-delete');
});
