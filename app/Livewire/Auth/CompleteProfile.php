<?php

namespace App\Livewire\Auth;

use App\Actions\Auth\LoginVerifiedUser;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.auth')]
class CompleteProfile extends Component
{
    public string $username = '';

    public string $password = '';

    public function mount()
    {
        if (! $this->isVerified()) {
            return $this->redirectRoute('login');
        }
    }

    // only reachable right after the OTP of this same email was verified
    private function isVerified(): bool
    {
        $email = session('google_auth.email');

        return $email && session('verified_email') === $email;
    }

    public function createAccount()
    {
        if (! $this->isVerified()) {
            session()->flash('error', 'Your session expired. Please try again.');

            return $this->redirectRoute('login', navigate: true);
        }

        $this->username = trim($this->username);

        $this->validate([
            'username' => 'required|min:3|max:20|alpha_dash:ascii|unique:users,username',
            'password' => 'required|min:8',
        ], [
            'username.unique' => 'This username is taken.',
            'password.required' => 'Password is required.',
            'password.min' => 'Use at least 8 characters.',
        ]);

        try {
            app(LoginVerifiedUser::class)->handle([
                ...session('google_auth'),
                'username' => $this->username,
                'password' => Hash::make($this->password),
            ]);
        } catch (UniqueConstraintViolationException) {
            $this->addError('username', 'This username is taken.');

            return;
        }

        return $this->redirectIntended(route('home'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.complete-profile', [
            'name' => session('google_auth.name'),
            'avatar' => session('google_auth.avatar'),
        ]);
    }
}
