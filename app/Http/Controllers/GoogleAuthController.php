<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function callback()
    {
        $origin = session()->pull('auth_origin', 'login');
        $origin = in_array($origin, ['login', 'register'], true) ? $origin : 'login';

        // the user pressed "Cancel" on Google's screen
        if (request()->has('error')) {
            return redirect()->route($origin)->with('error', 'Google sign-in was cancelled.');
        }

        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Throwable $e) {
            // e.g. a refreshed callback URL (used code or state)
            report($e);

            return redirect()->route($origin)->with('error', 'Google sign-in failed. Please try again.');
        }

        $email = Str::lower((string) $googleUser->getEmail());

        if ($email === '') {
            return redirect()->route($origin)->with('error', 'Google did not share an email address.');
        }

        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        try {
            Mail::to($email)->send(new OtpMail($otp));
        } catch (\Throwable $e) {
            report($e);

            return redirect()->route($origin)->with('error', 'We could not send the verification code. Please try again.');
        }

        session()->put('google_auth', [
            'google_id' => $googleUser->getId(),
            'name' => $googleUser->getName() ?: Str::before($email, '@'),
            'email' => $email,
            'avatar' => $googleUser->getAvatar(),
        ]);

        session()->put('google_pending', [
            'otp' => Hash::make($otp),
            'otp_expires_at' => now()->addMinutes(5)->getTimestamp(),
            'resend_at' => now()->addSeconds(60)->getTimestamp(),
            'attempts' => 0,
            'return_route' => $origin,
        ]);

        return redirect()->route('verify-otp');
    }
}
