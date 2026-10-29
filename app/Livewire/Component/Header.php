<?php

namespace App\Livewire\Component;

use Illuminate\Support\Str;
use Livewire\Component;

class Header extends Component
{
    public function render()
    {
        $user = auth()->user();

        return view('livewire.component.header', [
            'user' => $user,
            // initials shown when the user has no avatar, e.g. "Sudeep Ram" -> "SR"
            'initials' => Str::upper(
                collect(explode(' ', $user?->name ?? ''))
                    ->filter()
                    ->take(2)
                    ->map(fn ($word) => Str::substr($word, 0, 1))
                    ->implode('')
            ),
        ]);
    }
}
