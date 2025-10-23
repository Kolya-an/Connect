<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Livewire\RegisterPage;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home.index')->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/register', RegisterPage::class)->name('register');

Route::group(['prefix' => 'auth'], function () {
    Route::get('{provider}/redirect', [SocialiteController::class, 'redirectToProvider'])->name('social.redirect');
    Route::get('{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])->name('social.callback');
});



require __DIR__.'/auth.php';
