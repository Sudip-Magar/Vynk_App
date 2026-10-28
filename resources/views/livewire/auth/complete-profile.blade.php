<div x-data="{ isHidden: true }">
    <section class="mb-4 border-b border-white/40 pb-3 text-center">
        @if ($avatar)
            <img src="{{ $avatar }}" alt="" referrerpolicy="no-referrer"
                class="w-14 h-14 rounded-full mx-auto mb-2 border border-white/30">
        @else
            <x-icon name="o-user-circle" class="w-12 h-12 mx-auto" />
        @endif
        <div class="text-2xl font-bold">Almost done{{ $name ? ', '.Str::before($name, ' ') : '' }}</div>
        <p class="text-sm text-white/70 mt-1">Choose a username and password to create your account.</p>
    </section>

    <form wire:submit="createAccount">
        <div class="mb-2">
            <label class="mb-1 inline-block mx-1" for="username">Username:</label>
            <div class="flex items-center gap-2 border border-white/30 rounded-sm focus-within:border-white/70 px-2">
                <x-icon name="o-at-symbol" />
                <input type="text" placeholder="abcd123" id="username" wire:model="username" autocomplete="username"
                    class="inline-block outline-0 w-full py-1" />
            </div>
            @error('username') <p class="text-xs text-red-300 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1 inline-block mx-1" for="password">Password:</label>
            <div class="flex items-center border border-white/30 rounded-sm focus-within:border-white/70 px-2">
                <input :type="isHidden ? 'password' : 'text'" placeholder="•••••••••••••" id="password"
                    wire:model="password" autocomplete="new-password" class="inline-block outline-0 w-full py-1" />
                <button type="button" @click.prevent="isHidden = !isHidden" aria-label="Toggle password visibility">
                    <x-icon name="o-eye" class="w-5 h-5" x-show="!isHidden" x-cloak />
                    <x-icon name="o-eye-slash" class="w-5 h-5" x-show="isHidden" />
                </button>
            </div>
            @error('password') <p class="text-xs text-red-300 mt-1">{{ $message }}</p> @enderror
        </div>

        <x-button spinner="createAccount" type="submit"
            class="block bg-white/80 text-black w-full text-center mt-4 cursor-pointer rounded-sm hover:bg-white hover:shadow-md transition-all duration-150">Create account</x-button>
    </form>

    <div class="mt-6 pt-4 border-t border-white/20 text-center text-sm text-white/60">
        <a href="{{ route('login') }}" wire:navigate class="hover:underline">Cancel</a>
    </div>
</div>
