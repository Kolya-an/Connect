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
use App\Livewire\Pages\Auth\ForgotPassword;
use App\Livewire\Pages\Auth\ResetPassword;
use App\Models\Page;
use App\Livewire\Patient\PhotoConsentSign;


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
Route::get('/admin/pacients/{id}/edit', UserView::class)->name('admin.user.profile');
Route::get('/admin/doctors/{id}/edit', UserView::class)->name('admin.doctor.profile');

Route::get('/news/{slug}', Show::class)->name('news.show');
Route::get('/news/', Index::class)->name('news');

Route::get('/about', AboutPage::class)->name('about');
Route::get('/photobank', Photobank::class)->name('photobank');
Route::get('/map', Map::class)->name('map');
Route::get('/test', TestPage::class)->name('test');


Route::get('/forgot-password', ForgotPassword::class)
    ->middleware('guest')
    ->name('password.request');
Route::get('/reset-password/{token}', ResetPassword::class)
    ->middleware('guest')
    ->name('password.reset');

Route::get('/{slug}', function ($slug) {
    $page = Page::where('slug', $slug)
        ->where('is_published', true)
        ->firstOrFail();

    return view('page.show', compact('page'));
});

Route::get('/training-form', function () {
    return view('training-form');
});

Route::get('/consent/{token}', PhotoConsentSign::class)->name('photo-consent.show');

require __DIR__.'/auth.php';
