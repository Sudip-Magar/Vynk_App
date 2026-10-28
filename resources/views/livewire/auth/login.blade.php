<div x-data="{ isHidden: true }">
    <section class=" mb-3  border-b border-white/40 pb-1">
        <div class="text-center text-2xl font-bold">Login</div>
        <p class="text-sm text-white/70 mt-1 text-center">Your people are waiting.</p>
    </section>
    @if (session('error'))
        <div class="mb-3 rounded-lg border border-red-400/40 bg-red-500/20 px-3 py-2 text-center text-sm font-medium text-red-100">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit="login">
        <div class="mb-2">
            <label class="mb-1 inline-block mx-1" for="email">Email:</label>
            <div class="flex  items-center gap-2 border border-white/30 rounded-sm  focus-within:border-white/70 px-2">
                <x-icon name="o-envelope" />
                <input type="email" placeholder="abc@gmail.com" id="email" wire:model="email" autocomplete="email"
                    class="inline-block outline-0 w-full py-1  " />
            </div>
            @error('email') <p class="text-xs text-red-300 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1 inline-block mx-1" for="password">Password:</label>
            <div class="flex  items-center border border-white/30 rounded-sm  focus-within:border-white/70 px-2">
                <input :type="isHidden ? 'password' : 'text'" placeholder="•••••••••••••" id="password"
                    wire:model="password" autocomplete="current-password"
                    class="inline-block outline-0 w-full py-1" />
                <button type="button" @click.prevent="isHidden = !isHidden" aria-label="Toggle password visibility">
                    <x-icon name="o-eye" class="w-5 h-5" x-show="!isHidden" x-cloak />
                    <x-icon name="o-eye-slash" class="w-5 h-5" x-show="isHidden" />
                </button>
            </div>
            @error('password') <p class="text-xs text-red-300 mt-1">{{ $message }}</p> @enderror
        </div>

        <label class="mt-3 flex items-center gap-2 text-sm text-white/80 cursor-pointer">
            <input type="checkbox" wire:model="remember" class="checkbox checkbox-xs">
            Remember me
        </label>

        <x-button spinner="login" type="submit"
            class="block bg-white/80 text-black w-full text-center mt-4 cursor-pointer rounded-sm hover:bg-white  hover:shadow-md transition-all duration-150">Login</x-button>
    </form>

    <div class="my-3 divider before:bg-white/40 after:bg-white/40">Or</div>

    <button type="button"
        class="cursor-pointer inline-block text-center w-full border border-white/20 hover:bg-white/30 hover:border-white/10 hover:shadow-md transition-all duration-150 rounded-sm py-1"
        wire:click='redirectToGoogle'><img class="w-5 inline-block" src="{{ asset('assets/auth/google.png') }}"
            alt=""> Continue with Google</button>

    <div class="mt-6 pt-4 border-t border-white/20 text-center text-sm text-white/60">
        Don't have an account?
        <a href="{{ route('register') }}" wire:navigate class="font-semibold text-white hover:underline">Sign up</a>
    </div>

</div>
