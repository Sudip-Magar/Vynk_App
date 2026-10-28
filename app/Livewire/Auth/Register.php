<?php

namespace App\Livewire\Auth;

use App\Mail\OtpMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Socialite\Facades\Socialite;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.auth')]
class Register extends Component
{
    public $email;

    public $username;

    public $password;

    public $name;

    public function mount() {}

    public function redirectToGoogle()
    {
        session()->put('auth_origin', 'register');

        return redirect()->away(
            Socialite::driver('google')->redirect()->getTargetUrl()
        );
    }

    public function registerUser()
    {
        $this->email = strtolower(trim((string) $this->email));
        $this->username = trim((string) $this->username);

        $this->validate([
            'email' => 'required|email|max:255|unique:users,email',
            'name' => 'required|string|min:2|max:30|regex:/^[\pL\s\'.-]+$/u',
            'username' => 'required|min:3|max:20|alpha_dash:ascii|unique:users,username',
            'password' => 'required|min:8',
        ], [

            'email.unique' => 'This email is already registered.',
            'username.unique' => 'This username is taken.',
            'password.required' => 'Password is required.',
            'password.min' => 'Use at least 8 characters.',
            'name.required' => 'Name is required.',
            'name.min' => 'Name must be at least 2 characters.',
            'name.max' => 'Name can be 30 characters at most.',
            'name.regex' => 'Use letters only.',
        ]);

        // each code is an email, so limit how often one visitor can ask for it
        $key = 'register-otp:'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->addError('email', 'Too many attempts. Try again in '.RateLimiter::availableIn($key).' seconds.');

            return;
        }

        RateLimiter::hit($key, 300);

        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        try {
            Mail::to($this->email)->send(new OtpMail($otp));
        } catch (\Throwable $e) {
            report($e);
            $this->addError('email', 'We could not send the code. Please try again.');

            return;
        }

        // nothing is saved to the users table until the code is verified
        session()->put('google_auth', [
            'google_id' => null,
            'username' => $this->username,
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => null,
            'password' => Hash::make($this->password),
        ]);

        session()->put('google_pending', [
            'otp' => Hash::make($otp),
            'otp_expires_at' => now()->addMinutes(5)->getTimestamp(),
            'resend_at' => now()->addSeconds(60)->getTimestamp(),
            'attempts' => 0,
            'return_route' => 'register',
        ]);

        return $this->redirectRoute('verify-otp', navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
