<?php

use App\Http\Controllers\Auth\SocialiteController;
//use App\Http\Controllers\DoctorController;
use App\Livewire\DoctorProfile;
use App\Livewire\RegisterPage;
use App\Livewire\UserView;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Livewire\Doctor\Dashboard as DoctorDashboard;
use App\Livewire\Doctor\PatientList as DoctorPatientList;
use App\Livewire\Patient\Dashboard as PatientDashboard;
use App\Livewire\Patient\BookAppointment as PatientBookAppointment;

Route::view('/', 'home.index')->name('home');

/*Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');*/

/*Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');*/

Route::get('/register', RegisterPage::class)->name('register');

Route::group(['prefix' => 'auth'], function () {
    Route::get('{provider}/redirect', [SocialiteController::class, 'redirectToProvider'])->name('social.redirect');
    Route::get('{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])->name('social.callback');
});

/*Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->group(function () {
    Route::get('/dashboard', DoctorDashboard::class)->name('doctor.dashboard');
    Route::get('/patients', DoctorPatientList::class)->name('doctor.patients');
});

Route::middleware(['auth', 'role:patient'])->prefix('patient')->group(function () {
    Route::get('/dashboard', PatientDashboard::class)->name('patient.dashboard');
    Route::get('/book-appointment', PatientBookAppointment::class)->name('patient.book-appointment');
});*/

Route::get('/doctor/dashboard', DoctorDashboard::class)->name('doctor.dashboard');
Route::get('/patient/dashboard', PatientDashboard::class)->name('patient.dashboard');

Route::get('/doctors/{id}', DoctorProfile::class)->name('doctor.profile');
Route::get('/users/{id}', UserView::class)->name('user.profile');


require __DIR__.'/auth.php';
