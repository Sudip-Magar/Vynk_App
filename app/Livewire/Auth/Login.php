<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.auth')]
class Login extends Component
{
    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Enter a valid email.',
            'password.required' => 'Password is required.',
        ]);

        $email = Str::lower(trim($this->email));
        $key = $email.'|'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->addError('email', 'Too many attempts. Try again in '.RateLimiter::availableIn($key).' seconds.');

            return;
        }

        if (! Auth::attempt(['email' => $email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($key);
            $this->reset('password');
            $this->addError('email', 'Email or password is incorrect.');

            return;
        }

        RateLimiter::clear($key);
        session()->regenerate();

        return $this->redirectIntended(route('home'), navigate: true);
    }

    public function redirectToGoogle()
    {
        session()->put('auth_origin', 'login');

        return redirect()->away(
            Socialite::driver('google')->redirect()->getTargetUrl()
        );
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
