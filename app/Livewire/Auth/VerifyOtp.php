<?php

namespace App\Livewire\Auth;

use App\Actions\Auth\LoginVerifiedUser;
use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.auth')]
class VerifyOtp extends Component
{
    private const MAX_ATTEMPTS = 5;

    public string $otpPincode = '';

    public string $maskedEmail = '';

    // seconds left before the user may request another code
    public int $resendIn = 0;

    // Everything that decides who gets logged in is read from the session,
    // never from public properties: the browser can change those.
    public function mount()
    {
        $email = session('google_auth.email');

        if (! $email || ! session()->has('google_pending')) {
            return $this->redirectRoute('login');
        }

        [$name, $domain] = explode('@', $email, 2);
        $this->maskedEmail = substr($name, 0, 1).'***@'.$domain;
        $this->resendIn = max(0, session('google_pending.resend_at', 0) - now()->getTimestamp());
    }

    // the page the user started from; only known pages are allowed
    private function originRoute(): string
    {
        $route = session('google_pending.return_route');

        return in_array($route, ['login', 'register'], true) ? $route : 'login';
    }

    // clear the pending data and send the user back where they came from, with a message
    private function abandon(string $message)
    {
        $route = $this->originRoute();

        session()->forget(['google_pending', 'google_auth', 'verified_email']);
        session()->flash('error', $message);

        return $this->redirectRoute($route, navigate: true);
    }

    public function verifyOtp()
    {
        // Livewire keeps errors between requests; clear them so only the newest message shows
        $this->resetErrorBag();

        $pending = session('google_pending');
        $data = session('google_auth');

        if (! $pending || ! $data) {
            session()->flash('error', 'Your verification session expired. Please try again.');

            return $this->redirectRoute($this->originRoute(), navigate: true);
        }

        if (now()->getTimestamp() > $pending['otp_expires_at']) {
            $this->addError('otpPincode', 'Code expired. Please resend a new one.');

            return;
        }

        if ($pending['attempts'] >= self::MAX_ATTEMPTS) {
            return $this->abandon('Too many wrong codes. Please try again.');
        }

        if (! Hash::check($this->otpPincode, $pending['otp'])) {
            session()->increment('google_pending.attempts');
            $left = self::MAX_ATTEMPTS - session('google_pending.attempts');

            if ($left <= 0) {
                return $this->abandon('Too many wrong codes. Please try again.');
            }

            $this->reset('otpPincode');
            $this->addError(
                'otpPincode',
                $left === 1 ? 'Wrong code. This is your last attempt.' : "Wrong code. {$left} attempts left."
            );

            return;
        }

        // The email is now verified.
        $known = User::where('email', $data['email'])
            ->when($data['google_id'] ?? null, fn ($query, $id) => $query->orWhere('google_id', $id))
            ->exists();

        // existing account, or an email registration that already has its password: log in now
        if ($known || ! empty($data['password'])) {
            try {
                app(LoginVerifiedUser::class)->handle($data);
            } catch (UniqueConstraintViolationException) {
                return $this->abandon('That email or username was just taken. Please try again.');
            }

            return $this->redirectIntended(route('home'), navigate: true);
        }

        // a new Google user still has to choose a username and a password
        session()->put('verified_email', $data['email']);
        session()->forget('google_pending');

        return $this->redirectRoute('complete-profile', navigate: true);
    }

    public function resendOtp()
    {
        $this->resetErrorBag();

        $email = session('google_auth.email');

        if (! $email) {
            return $this->redirectRoute('login', navigate: true);
        }

        // re-read the cooldown from the session: a public property can be changed by the client
        $resendAt = session('google_pending.resend_at', 0);

        if (now()->getTimestamp() < $resendAt) {
            $this->resendIn = $resendAt - now()->getTimestamp();

            return;
        }

        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        try {
            Mail::to($email)->send(new OtpMail($otp));
        } catch (\Throwable $e) {
            report($e);
            $this->addError('otpPincode', 'We could not send the code. Please try again.');

            return;
        }

        session()->put('google_pending', [
            'otp' => Hash::make($otp),
            'otp_expires_at' => now()->addMinutes(5)->getTimestamp(),
            'resend_at' => now()->addSeconds(60)->getTimestamp(),
            'attempts' => 0,
            'return_route' => $this->originRoute(),
        ]);

        $this->resendIn = 60;
        $this->dispatch('otp-resent', seconds: 60);
    }

    public function render()
    {
        // always hand the view the real time left, so a re-render never shows a stale value
        $this->resendIn = max(0, session('google_pending.resend_at', 0) - now()->getTimestamp());

        return view('livewire.auth.verify-otp');
    }
}
