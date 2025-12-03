<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Livewire\DoctorProfile;
use App\Livewire\Homepage;
use App\Livewire\Map;
use App\Livewire\News\Index;
use App\Livewire\News\Show;
use App\Livewire\Photobank;
use App\Livewire\RegisterPage;
use App\Livewire\TestPage;
use App\Livewire\UserView;
use App\Livewire\AboutPage;
use Illuminate\Support\Facades\Route;
use App\Livewire\Doctor\Dashboard as DoctorDashboard;
use App\Livewire\Patient\Dashboard as PatientDashboard;
use Livewire\Volt\Volt;
use App\Livewire\Pages\Auth\ForgotPassword;
use App\Livewire\Pages\Auth\ResetPassword;


Route::view('/', 'home.index')->name('home');
Route::get('/', Homepage::class)->name('home');

Route::get('/register', RegisterPage::class)->name('register');

Route::group(['prefix' => 'auth'], function () {
    Route::get('{provider}/redirect', [SocialiteController::class, 'redirectToProvider'])->name('social.redirect');
    Route::get('{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])->name('social.callback');
});

Route::get('/doctor/dashboard', DoctorDashboard::class)->name('doctor.dashboard');
Route::get('/patient/dashboard', PatientDashboard::class)->name('patient.dashboard');

Route::get('/doctors/{id}', DoctorProfile::class)->name('doctor.profile');
Route::get('/users/{id}', UserView::class)->name('user.profile');

Route::get('/news/{slug}', Show::class)->name('news.show');
Route::get('/news/', Index::class)->name('news');

Route::get('/about', AboutPage::class)->name('about');
Route::get('/photobank', Photobank::class)->name('photobank');
Route::get('/map', Map::class)->name('map');
Route::get('/test', TestPage::class)->name('test');

/*Volt::route('/forgot-password', 'pages.auth.forgot-password')
    ->middleware('guest')
    ->name('password.request');*/
Route::get('/forgot-password', ForgotPassword::class)
    ->middleware('guest')
    ->name('password.request');
Route::get('/reset-password/{token}', ResetPassword::class)
    ->middleware('guest')
    ->name('password.reset');

require __DIR__.'/auth.php';
