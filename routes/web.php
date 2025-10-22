<?php

use App\Livewire\RegisterPage;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home.index')->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/register', RegisterPage::class)->name('register');



require __DIR__.'/auth.php';
