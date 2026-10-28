<form wire:submit="verifyOtp">
    <section class="mb-6 border-b border-white/40 pb-3 text-center">
        <x-icon name="o-envelope" class="w-10 h-10 mx-auto" />
        <div class="text-2xl font-bold mt-1">Verify your email</div>
        <p class="text-sm text-white/70 mt-1">We sent a 6-digit code to {{ $maskedEmail }}</p>
    </section>

    <div class="flex justify-center" @completed="$wire.verifyOtp()">
        <x-pin wire:model="otpPincode" size="6" numeric omit-error
            class="bg-white/10 border-white/30 text-white" />
    </div>

    @error('otpPincode')
        <div class="mt-4 rounded-lg border border-red-400/40 bg-red-500/20 px-3 py-2 text-center text-sm font-medium text-red-100">
            {{ $message }}
        </div>
    @enderror

    <x-button type="submit" spinner="verifyOtp"
        class="block bg-white/80 text-black w-full text-center mt-6 cursor-pointer rounded-lg hover:bg-white hover:shadow-md transition-all duration-150 py-2 font-semibold">
        Verify
    </x-button>

    <div class="mt-6 pt-4 border-t border-white/20 text-center text-sm text-white/60 space-y-1">
        <div x-data="{
            left: {{ $resendIn }},
            endsAt: Date.now() + {{ $resendIn }} * 1000,
            timer: null,
            init() {
                this.timer = setInterval(() => this.tick(), 1000)
            },
            destroy() {
                clearInterval(this.timer)
            },
            tick() {
                this.left = Math.max(0, Math.ceil((this.endsAt - Date.now()) / 1000))
            },
            restart(seconds) {
                this.endsAt = Date.now() + seconds * 1000
                this.tick()
            },
            get label() {
                return Math.floor(this.left / 60) + ':' + String(this.left % 60).padStart(2, '0')
            }
        }" @otp-resent.window="restart($event.detail.seconds)">
            <template x-if="left > 0">
                <span>Resend in <span x-text="label"></span></span>
            </template>
            <template x-if="left === 0">
                <span>
                    Didn't get it?
                    <button type="button" wire:click="resendOtp" wire:loading.attr='disabled' wire:target='resendOtp'
                        class="font-semibold text-white hover:underline cursor-pointer disabled:opacity-60">
                        <span wire:loading.remove wire:target='resendOtp'>Resend</span>
                        <span wire:loading wire:target='resendOtp'>Sending...</span>
                    </button>
                </span>
            </template>
        </div>
        <a href="{{ route('login') }}" wire:navigate class="block hover:underline">Use a different account</a>
    </div>
</form>
