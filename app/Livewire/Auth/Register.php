<?php

namespace App\Livewire\Auth;

use Laravel\Socialite\Facades\Socialite;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.auth')]
class Register extends Component
{
    public function redirectToGoogle(){
        return redirect()->away(
            Socialite::driver('google')->redirect()->getTargetUrl()
        );
    }
    public function render()
    {
        return view('livewire.auth.register');
    }
}
