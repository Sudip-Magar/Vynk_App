<div>
    <div x-data="{ isHidden: true }">
        <section class=" mb-3  border-b border-white/40 pb-1">
            <div class="text-center text-2xl font-bold">Register</div>
            <p class="text-sm text-white/70 mt-1 text-center">Your circle starts here.</p>
        </section>
        @if (session('error'))
            <div class="mb-3 rounded-lg border border-red-400/40 bg-red-500/20 px-3 py-2 text-center text-sm font-medium text-red-100">
                {{ session('error') }}
            </div>
        @endif
        <form wire:submit='registerUser'>
            <div class="mb-2">
                <div class="flex items-center justify-between mb-1">
                    <label class=" inline-block mx-1" for="name">Name:</label>
                    @error('name')
                        <p class="text-sm text-red-300 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div
                    class="flex  items-center gap-2 border border-white/30 rounded-sm  focus-within:border-white/70 px-2">
                    <x-icon name="o-user" />
                    <input type="text" value="" placeholder="Jonh Walker" id="name" wire:model='name'
                        class="inline-block outline-0 w-full py-1  " />
                </div>
            </div>

            <div class="mb-2">
                <div class="flex items-center justify-between mb-1">
                    <label class="inline-block mx-1" for="email">Email:</label>
                    @error('email')
                        <p class="text-sm text-red-300 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div
                    class="flex items-center gap-2 border border-white/30 rounded-sm  focus-within:border-white/70 px-2">
                    <x-icon name="o-envelope" />
                    <input type="email" value="" placeholder="abc@gmail.com" id="email" wire:model='email'
                        class="inline-block outline-0 w-full py-1  " />
                </div>
            </div>

            <div class="mb-2">
                <div class="flex items-center justify-between mb-1">
                    <label class="inline-block mx-1" for="username">Username:</label>
                    @error('username')
                        <p class="text-sm text-red-300 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div
                    class="flex  items-center gap-2 border border-white/30 rounded-sm  focus-within:border-white/70 px-2">
                    <x-icon name="o-at-symbol" />
                    <input type="text" value="" placeholder="abcd123" id="username" wire:model='username'
                        class="inline-block outline-0 w-full py-1  " />
                </div>
            </div>

            <div class="">
                <div class="flex items-center justify-between mb-1">
                    <label class="inline-block mx-1" for="password">Password:</label>
                    @error('password')
                        <p class="text-sm text-red-300 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex  items-center border border-white/30 rounded-sm  focus-within:border-white/70 px-2">
                    <input wire:model='password' :type="isHidden ? 'password' : 'text'" value=""
                        placeholder="•••••••••••••" class="inline-block outline-0 w-full py-1" id="password" />
                    <button @click.prevent="isHidden = !isHidden" class="cursor-pointer">
                        <x-icon name="o-eye" class="w-5 h-5" x-show="!isHidden" x-cloak />
                        <x-icon name="o-eye-slash" class="w-5 h-5" x-show="isHidden" />
                    </button>
                </div>
            </div>
            <x-button spinner="registerUser" type="submit"
                class="block bg-white/80 text-black w-full text-center mt-4 cursor-pointer rounded-sm hover:bg-white  hover:shadow-md transition-all duration-150">Register</x-button>


        </form>
        <div class="my-3 divider before:bg-white/40 after:bg-white/40">Or</div>

        <button
            class="cursor-pointer inline-block text-center w-full border border-white/20 hover:bg-white/30 hover:border-white/10 hover:shadow-md transition-all duration-150 rounded-sm py-2"
            wire:click='redirectToGoogle'><img class="w-5 inline-block" src="{{ asset('assets/auth/google.png') }}"
                alt=""> Continue with Google</button>

        <div class="mt-6 pt-4 border-t border-white/20 text-center text-sm text-white/60">
            Already have an account?
            <a href="{{ route('login') }}" wire:navigate class="font-semibold text-white hover:underline">Log in</a>
        </div>

    </div>
</div>
