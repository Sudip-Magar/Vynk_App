<div class="mx-auto w-full max-w-6xl px-4 py-4">
    <div class="grid grid-cols-1 gap-4 md:grid-cols-[4rem_minmax(0,1fr)] lg:grid-cols-[16rem_minmax(0,1fr)] xl:grid-cols-[16rem_minmax(0,1fr)_18rem]">

        {{-- left: links (icons only on tablet, icons + text on laptop and up, hidden on phones) --}}
        <aside class="hidden md:block">
            <nav class="sticky top-18 flex flex-col gap-1">
                @php
                    $links = [
                        ['Friends', 'o-users'],
                        ['Saved', 'o-bookmark'],
                        ['Memories', 'o-clock'],
                        ['Groups', 'o-user-group'],
                        ['Events', 'o-calendar-days'],
                        ['Photos', 'o-photo'],
                    ];
                @endphp

                @foreach ($links as [$label, $icon])
                    <a href="#" title="{{ $label }}"
                        class="flex items-center gap-3 rounded-xl p-3 text-sm font-medium text-base-content/80 transition hover:bg-base-100 md:justify-center lg:justify-start">
                        <x-icon :name="$icon" class="h-6 w-6 shrink-0 text-emerald-600 dark:text-emerald-400" />
                        <span class="hidden lg:inline">{{ $label }}</span>
                    </a>
                @endforeach
            </nav>
        </aside>

        {{-- middle: posts --}}
        <main class="mx-auto w-full min-w-0 max-w-2xl">
            @livewire('pages.post.post-list')
        </main>

        {{-- right: information (wide screens only) --}}
        <aside class="hidden xl:block">
            <div class="sticky top-18 flex flex-col gap-4">
                <section class="rounded-xl border border-base-300 bg-base-100 p-4">
                    <h2 class="mb-3 font-semibold">Suggested for you</h2>
                    <p class="text-sm text-base-content/60">People you may know will show up here.</p>
                </section>

                <section class="rounded-xl border border-base-300 bg-base-100 p-4">
                    <h2 class="mb-3 font-semibold">Trending</h2>
                    <p class="text-sm text-base-content/60">Popular topics will show up here.</p>
                </section>

                <p class="px-1 text-xs text-base-content/50">&copy; {{ date('Y') }} Vynk</p>
            </div>
        </aside>
    </div>
</div>
