<header class="sticky top-0 z-40 border-b border-base-300 bg-base-100/80 text-base-content backdrop-blur">
    <nav class="mx-auto flex h-14 w-full max-w-6xl items-center justify-between gap-3 px-4">

        {{-- logo --}}
        <a href="{{ route('home') }}" wire:navigate
            class="app_log text-2xl font-bold text-emerald-600 dark:text-emerald-400">Vynk</a>

        {{-- search: full bar on tablet and up --}}
        <label
            class="hidden md:flex flex-1 max-w-md items-center gap-2 rounded-full bg-base-200 px-4 py-1.5 focus-within:ring-2 focus-within:ring-emerald-500/50">
            <x-icon name="o-magnifying-glass" class="w-5 h-5 text-base-content/50" />
            <input type="search" placeholder="Search Vynk" aria-label="Search"
                class="w-full bg-transparent text-sm outline-none placeholder:text-base-content/50" />
        </label>

        <div class="flex items-center gap-1">

            {{-- search icon: phones only --}}
            <a href="#" aria-label="Search"
                class="md:hidden grid h-10 w-10 place-items-center rounded-full text-base-content/70 transition hover:bg-base-200">
                <x-icon name="o-magnifying-glass" class="w-6 h-6" />
            </a>

            <a href="{{ route('home') }}" wire:navigate aria-label="Home" title="Home"
                class="grid h-10 w-10 place-items-center rounded-full transition {{ request()->routeIs('home') ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'text-base-content/70 hover:bg-base-200' }}">
                <x-icon name="o-home" class="w-6 h-6" />
            </a>

            <a href="#" aria-label="Messages" title="Messages"
                class="grid h-10 w-10 place-items-center rounded-full text-base-content/70 transition hover:bg-base-200">
                <x-icon name="o-chat-bubble-left-right" class="w-6 h-6" />
            </a>

            <a href="#" aria-label="Notifications" title="Notifications"
                class="grid h-10 w-10 place-items-center rounded-full text-base-content/70 transition hover:bg-base-200">
                <x-icon name="o-bell" class="w-6 h-6" />
            </a>

            {{-- dark mode toggle --}}
            <button type="button" x-data="{ dark: document.documentElement.dataset.theme === 'dark' }"
                @click="dark = toggleTheme() === 'dark'" @theme-changed.window="dark = $event.detail === 'dark'"
                aria-label="Toggle dark mode" :title="dark ? 'Light mode' : 'Dark mode'"
                class="grid h-10 w-10 cursor-pointer place-items-center rounded-full text-base-content/70 transition hover:bg-base-200">
                <x-icon name="o-moon" class="w-6 h-6" x-show="!dark" x-cloak />
                <x-icon name="o-sun" class="w-6 h-6" x-show="dark" x-cloak />
            </button>

            {{-- account menu --}}
            @auth
                <div class="relative ml-1" x-data="{ open: false }" @click.outside="open = false"
                    @keydown.escape.window="open = false">
                    <button type="button" @click="open = !open" aria-label="Account menu" :aria-expanded="open"
                        class="block cursor-pointer rounded-full p-0.5 transition hover:ring-2 hover:ring-emerald-500/40">
                        @if ($user->avatar)
                            <img src="{{ $user->avatar }}" alt="" referrerpolicy="no-referrer"
                                class="h-9 w-9 rounded-full object-cover">
                        @else
                            <span
                                class="grid h-9 w-9 place-items-center rounded-full bg-emerald-600 text-sm font-semibold text-white">{{ $initials }}</span>
                        @endif
                    </button>

                    <div x-show="open" x-cloak x-transition.origin.top.right
                        class="absolute right-0 mt-2 w-64 rounded-xl border border-base-300 bg-base-100 p-2 text-base-content shadow-lg">
                        <div class="px-3 py-2">
                            <div class="truncate font-semibold">{{ $user->name }}</div>
                            @if ($user->username)
                                <div class="truncate text-sm text-base-content/60">{{ '@'.$user->username }}</div>
                            @endif
                        </div>

                        <div class="my-1 border-t border-base-300"></div>

                        <a href="#"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm hover:bg-base-200">
                            <x-icon name="o-user" class="w-5 h-5" /> Profile
                        </a>
                        <a href="#"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm hover:bg-base-200">
                            <x-icon name="o-cog-6-tooth" class="w-5 h-5" /> Settings
                        </a>

                        <div class="my-1 border-t border-base-300"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex w-full cursor-pointer items-center gap-3 rounded-lg px-3 py-2 text-left text-sm text-red-600 hover:bg-red-500/10 dark:text-red-400">
                                <x-icon name="o-arrow-right-start-on-rectangle" class="w-5 h-5" /> Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </nav>
</header>
