<?php

use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\LogoutController;
use App\Livewire\Auth\CompleteProfile;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\VerifyOtp;
use App\Livewire\Pages\Home;

Route::middleware('guest')->group(function () {
    Route::get('/', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');
    Route::get('/verify-otp', VerifyOtp::class)->name('verify-otp');
    Route::get('/complete-profile', CompleteProfile::class)->name('complete-profile');
});

Route::middleware('auth')->group(function () {
    Route::get('/home', Home::class)->name('home');
    Route::post('/logout', LogoutController::class)->name('logout');
});
