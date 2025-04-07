<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CountryController;
Route::get('/', function () {
    return Inertia::render('Welcome');
});

// web.php
Route::get('/countries/{id}', [CountryController::class, 'show'])->name('country.show');

Route::get('/data.json', function () {
    return response()->json(json_decode(file_get_contents(public_path('data.json'))));
});


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
