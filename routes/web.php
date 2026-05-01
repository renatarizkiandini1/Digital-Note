<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

Route::resource('notes', NoteController::class);
Route::get('/', function () {
    return view('welcome');
});
