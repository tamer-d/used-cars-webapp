<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

// Route pour la liste des voitures
Route::get('/cars', [CarController::class, 'index'])->name('cars.index');

// Route pour la page About Us
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

// Route pour la page Contact
Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');