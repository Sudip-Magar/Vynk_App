<?php

use App\Http\Controllers\GoogleAuthController;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;

Route::get('/', Login::class)->name('home');
Route::get('/', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');
