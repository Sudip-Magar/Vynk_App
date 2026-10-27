<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function callback(){
        $googleUser = Socialite::driver('google')->user();
        session()->put('google_auth', [
            'google_id' => $googleUser->getId(),
            'name' =>$googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'avatar' =>$googleUser->getAvatar(),
        ]);

        dd(session('google_auth'));
    }
}
