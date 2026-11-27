@php($links = [
    ['route' => 'rooms', 'pattern' => 'rooms*', 'key' => 'nav.rooms'],
    ['route' => 'amenities', 'pattern' => 'amenities', 'key' => 'nav.amenities'],
    ['route' => 'about', 'pattern' => 'about', 'key' => 'nav.about'],
    ['route' => 'contact', 'pattern' => 'contact', 'key' => 'nav.contact'],
])
<header
    x-data="{ scrolled: false, mobileOpen: false }"
    @scroll.window="scrolled = window.scrollY > 8"
    x-init="scrolled = window.scrollY > 8"
    class="sticky top-0 z-40 border-b transition-colors"
    :class="scrolled ? 'surface-header border-themed backdrop-blur' : 'border-transparent bg-transparent'">
    <div class="mx-auto flex h-16 max-w-7xl items-center gap-3 px-4 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-500 text-white shadow-theme-md">
                <x-icon name="concierge-bell" :size="18" />
            </span>
            <span class="text-lg font-bold text-heading" x-text="$t('brand')"></span>
        </a>

        <nav class="ml-6 hidden items-center gap-1 lg:flex">
            @foreach ($links as $l)
                <a href="{{ route($l['route']) }}"
                    class="rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs($l['pattern']) ? 'text-brand-600 dark:text-brand-400' : 'text-body hover:text-heading' }}"
                    x-text="$t('{{ $l['key'] }}')"></a>
            @endforeach
        </nav>

        <div class="ml-auto flex items-center gap-1 sm:gap-2">
            <button type="button" @click="$store.ui.toggleDarkMode()" :aria-label="$t('common.theme')"
                class="flex h-10 w-10 items-center justify-center rounded-full border border-themed text-body transition hover:bg-gray-50 dark:hover:bg-gray-800">
                <template x-if="$store.ui.darkMode"><x-icon name="sun" :size="18" /></template>
                <template x-if="!$store.ui.darkMode"><x-icon name="moon" :size="18" /></template>
            </button>
            <x-ui.language-switcher />

            <template x-if="$store.auth.isAuthenticated">
                <a href="{{ route('dashboard') }}"
                    class="hidden h-10 items-center rounded-lg bg-brand-500 px-4 text-sm font-medium text-white transition hover:bg-brand-600 sm:flex"
                    x-text="$t('nav.dashboard')"></a>
            </template>
            <template x-if="!$store.auth.isAuthenticated">
                <span class="hidden items-center gap-2 sm:flex">
                    <a href="{{ route('login') }}"
                        class="flex h-10 items-center rounded-lg border border-themed px-4 text-sm font-medium text-body transition hover:bg-gray-50 dark:hover:bg-gray-800"
                        x-text="$t('nav.login')"></a>
                    <a href="{{ route('rooms') }}"
                        class="flex h-10 items-center rounded-lg bg-brand-500 px-4 text-sm font-medium text-white transition hover:bg-brand-600"
                        x-text="$t('nav.book')"></a>
                </span>
            </template>

            <button type="button" @click="mobileOpen = !mobileOpen"
                class="flex h-10 w-10 items-center justify-center rounded-lg text-body lg:hidden" aria-label="Menu">
                <template x-if="mobileOpen"><x-icon name="x" :size="22" /></template>
                <template x-if="!mobileOpen"><x-icon name="menu" :size="22" /></template>
            </button>
        </div>
    </div>

    <div x-show="mobileOpen" x-transition x-cloak class="surface-card border-t border-themed lg:hidden">
        <nav class="flex flex-col gap-1 px-4 py-4 sm:px-6">
            @foreach ($links as $l)
                <a href="{{ route($l['route']) }}" @click="mobileOpen = false"
                    class="rounded-lg px-3 py-2.5 text-sm font-medium text-body hover:bg-gray-50 dark:hover:bg-gray-800"
                    x-text="$t('{{ $l['key'] }}')"></a>
            @endforeach
            <div class="mt-2 flex flex-col gap-2 border-t border-themed pt-3">
                <template x-if="$store.auth.isAuthenticated">
                    <a href="{{ route('dashboard') }}" class="flex h-11 items-center justify-center rounded-lg bg-brand-500 text-sm font-medium text-white" x-text="$t('nav.dashboard')"></a>
                </template>
                <template x-if="!$store.auth.isAuthenticated">
                    <span class="flex flex-col gap-2">
                        <a href="{{ route('login') }}" class="flex h-11 items-center justify-center rounded-lg border border-themed text-sm font-medium text-body" x-text="$t('nav.login')"></a>
                        <a href="{{ route('rooms') }}" class="flex h-11 items-center justify-center rounded-lg bg-brand-500 text-sm font-medium text-white" x-text="$t('nav.book')"></a>
                    </span>
                </template>
            </div>
        </nav>
    </div>
</header>
