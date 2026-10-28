<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginVerifiedUser
{
    /**
     * Find or create the user for an email that was just verified with an OTP,
     * log them in and clear the pending sign-in data from the session.
     *
     * `password` must already be hashed. It is only used when a new user is created.
     *
     * @param  array{email: string, name?: ?string, google_id?: ?string, avatar?: ?string, username?: ?string, password?: ?string}  $data
     */
    public function handle(array $data): User
    {
        $email = Str::lower($data['email']);
        $googleId = $data['google_id'] ?? null;

        $user = $googleId ? User::where('google_id', $googleId)->first() : null;
        $user ??= User::where('email', $email)->first();

        if ($user) {
            // existing account: link Google if it is not linked yet
            $user->google_id ??= $googleId;
            $user->avatar ??= $data['avatar'] ?? null;
            $user->email_verified_at ??= now();
            $user->save();
        } else {
            $user = new User([
                'name' => $data['name'] ?: Str::before($email, '@'),
                'email' => $email,
                'username' => $data['username'] ?? null,
                'avatar' => $data['avatar'] ?? null,
                'google_id' => $googleId,
                'password' => $data['password'],
            ]);
            $user->email_verified_at = now();
            $user->save();
        }

        Auth::login($user);

        session()->regenerate();
        session()->forget(['google_auth', 'google_pending', 'verified_email', 'auth_origin']);

        return $user;
    }
}
