@php($notifications = [
    ['id' => 1, 'titleKey' => 'newReservation', 'name' => 'Sofía Hernández', 'time' => 'Há 5 min', 'read' => false],
    ['id' => 2, 'titleKey' => 'checkinReady', 'name' => 'Juliana Ferreira', 'time' => 'Há 1 hora', 'read' => false],
    ['id' => 3, 'titleKey' => 'maintenance', 'name' => 'Quarto 405', 'time' => 'Há 3 horas', 'read' => true],
])
<header class="surface-header sticky top-0 z-30 flex w-full border-b"
    x-data="{ notifOpen: false, dropdownOpen: false,
        get initials() {
            const u = $store.auth.user;
            if (!u || !u.name) return '?';
            return u.name.split(' ').slice(0, 2).map(w => (w[0] || '').toUpperCase()).join('');
        } }">
    <div class="flex flex-grow items-center justify-between gap-4 px-4 py-3 md:px-6 2xl:px-10">
        <div class="flex items-center gap-3">
            <button type="button" aria-label="Toggle sidebar"
                @click="window.innerWidth < 1024 ? $store.ui.toggleSidebarMobile() : $store.ui.toggleSidebar()"
                class="flex h-10 w-10 items-center justify-center rounded-lg border border-themed text-muted hover:bg-gray-50 dark:hover:bg-gray-800">
                <x-icon name="menu" :size="20" />
            </button>

            <div class="hidden md:block">
                <div class="relative">
                    <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <x-icon name="search" :size="18" />
                    </span>
                    <input type="text" :placeholder="$t('appNav.searchPlaceholder')"
                        class="h-10 w-[260px] rounded-lg border border-themed bg-gray-50 pl-10 pr-12 text-sm text-body placeholder-gray-400 outline-none focus:border-brand-300 focus-ring dark:bg-gray-900 xl:w-[360px]" />
                    <kbd class="absolute right-3 top-1/2 -translate-y-1/2 rounded border border-themed bg-white px-1.5 py-0.5 text-xs text-muted dark:bg-gray-900">⌘ K</kbd>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <x-ui.language-switcher />
            <button type="button" aria-label="Toggle dark mode" @click="$store.ui.toggleDarkMode()"
                class="flex h-10 w-10 items-center justify-center rounded-full border border-themed text-muted hover:bg-gray-50 dark:hover:bg-gray-800">
                <template x-if="$store.ui.darkMode"><x-icon name="sun" :size="18" /></template>
                <template x-if="!$store.ui.darkMode"><x-icon name="moon" :size="18" /></template>
            </button>

            <div class="relative" @click.outside="notifOpen = false">
                <button type="button" aria-label="Notifications" @click="notifOpen = !notifOpen"
                    class="relative flex h-10 w-10 items-center justify-center rounded-full border border-themed text-muted hover:bg-gray-50 dark:hover:bg-gray-800">
                    <x-icon name="bell" :size="18" />
                    <span class="absolute top-1.5 right-1.5 flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-error-400 opacity-75"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-error-500"></span>
                    </span>
                </button>
                <div x-show="notifOpen" x-transition x-cloak class="surface-card absolute right-0 mt-3 w-80 rounded-xl border shadow-theme-lg">
                    <div class="flex items-center justify-between border-b border-themed px-4 py-3">
                        <p class="text-sm font-semibold text-heading" x-text="$t('appNav.notifications')"></p>
                    </div>
                    <ul class="max-h-72 divide-y divide-themed overflow-y-auto">
                        @foreach ($notifications as $n)
                            <li class="flex gap-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <span class="mt-1 flex h-2 w-2 shrink-0 rounded-full {{ $n['read'] ? 'bg-gray-300' : 'bg-brand-500' }}"></span>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-heading" x-text="$t('notifications.{{ $n['titleKey'] }}', { name: @js($n['name']) })"></p>
                                    <p class="text-xs text-muted">{{ $n['time'] }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="relative" @click.outside="dropdownOpen = false">
                <button type="button" class="ml-1 flex items-center gap-3" @click="dropdownOpen = !dropdownOpen">
                    <span class="hidden text-right lg:block">
                        <span class="block text-sm font-medium text-heading" x-text="$store.auth.user?.name || 'Convidado'"></span>
                        <span class="block text-xs text-muted">
                            <span x-text="$store.auth.user?.role || '—'"></span>
                        </span>
                    </span>
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-500 font-semibold text-white" x-text="initials"></span>
                    <x-icon name="chevron-down" :size="16" class="text-muted" />
                </button>

                <div x-show="dropdownOpen" x-transition x-cloak class="surface-card absolute right-0 mt-3 w-56 rounded-xl border shadow-theme-lg">
                    <div class="border-b border-themed px-4 py-3">
                        <p class="text-sm font-medium text-heading" x-text="$store.auth.user?.name || 'Convidado'"></p>
                        <p class="text-xs text-muted" x-text="$store.auth.user?.email || ''"></p>
                    </div>
                    <ul class="py-1">
                        <li>
                            <a href="{{ route('app.settings') }}" @click="dropdownOpen = false"
                                class="flex items-center gap-2 px-4 py-2 text-sm text-body hover:bg-gray-50 dark:hover:bg-gray-800">
                                <x-icon name="settings" :size="16" /> <span x-text="$t('appNav.settings')"></span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('home') }}" @click="dropdownOpen = false"
                                class="flex items-center gap-2 px-4 py-2 text-sm text-body hover:bg-gray-50 dark:hover:bg-gray-800">
                                <x-icon name="globe" :size="16" /> <span x-text="$t('nav.site')"></span>
                            </a>
                        </li>
                    </ul>
                    <div class="border-t border-themed py-1">
                        <form method="POST" action="{{ route('logout') }}" @submit="$store.auth.logout()">
                            @csrf
                            <button type="submit"
                                class="flex w-full items-center gap-2 px-4 py-2 text-sm text-error-600 hover:bg-error-50 dark:hover:bg-error-500/10">
                                <x-icon name="logout" :size="16" /> <span x-text="$t('appNav.logout')"></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
