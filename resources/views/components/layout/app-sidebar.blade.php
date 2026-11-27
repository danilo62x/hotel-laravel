@php($sections = [
    ['titleKey' => 'appNav.main', 'items' => [
        ['route' => 'dashboard', 'pattern' => 'dashboard', 'labelKey' => 'appNav.dashboard', 'icon' => 'dashboard'],
        ['route' => 'app.reservations', 'pattern' => 'app.reservations', 'labelKey' => 'appNav.reservations', 'icon' => 'calendar'],
    ]],
    ['titleKey' => 'appNav.frontdesk', 'items' => [
        ['route' => 'app.room-map', 'pattern' => 'app.room-map', 'labelKey' => 'appNav.roomMap', 'icon' => 'grid'],
        ['route' => 'app.checkin', 'pattern' => 'app.checkin', 'labelKey' => 'appNav.checkin', 'icon' => 'log-in'],
        ['route' => 'app.guests', 'pattern' => 'app.guests', 'labelKey' => 'appNav.guests', 'icon' => 'users'],
    ]],
    ['titleKey' => 'appNav.revenue', 'items' => [
        ['route' => 'app.rates', 'pattern' => 'app.rates', 'labelKey' => 'appNav.rates', 'icon' => 'sliders'],
    ]],
    ['titleKey' => 'appNav.account', 'items' => [
        ['route' => 'app.settings', 'pattern' => 'app.settings', 'labelKey' => 'appNav.settings', 'icon' => 'settings'],
    ]],
])
<aside x-data
    :style="`width: ${$store.ui.sidebarCollapsed ? '90px' : '280px'}`"
    class="surface-sidebar fixed left-0 top-0 z-50 flex h-screen flex-col overflow-y-hidden border-r px-4 transition-[transform,width] duration-300 lg:static lg:translate-x-0"
    :class="$store.ui.sidebarMobileOpen ? 'translate-x-0' : '-translate-x-full'">

    <div class="flex items-center pt-7 pb-6" :class="$store.ui.sidebarCollapsed ? 'justify-center' : 'justify-between'">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-500 text-white shadow-theme-sm">
                <x-icon name="concierge-bell" :size="18" />
            </span>
            <span x-show="!$store.ui.sidebarCollapsed" data-brand-text class="text-lg font-semibold text-heading" x-text="$t('brand')"></span>
        </a>
        <button type="button" x-show="!$store.ui.sidebarCollapsed" @click="$store.ui.toggleSidebar()"
            class="is-sidebar-inactive hidden h-8 w-8 items-center justify-center rounded-lg border border-themed lg:flex"
            :title="$t('appNav.collapse')">
            <x-icon name="chevron-right" :size="14" class="rotate-180" />
        </button>
    </div>

    <div class="flex flex-col gap-5 overflow-y-auto no-scrollbar pb-4">
        @foreach ($sections as $section)
            <nav>
                <h3 x-show="!$store.ui.sidebarCollapsed" class="mb-2 px-2 text-[11px] font-semibold uppercase tracking-wider text-muted"
                    x-text="$t('{{ $section['titleKey'] }}')"></h3>
                <ul class="flex flex-col gap-1">
                    @foreach ($section['items'] as $item)
                        @php($active = request()->routeIs($item['pattern']))
                        <li>
                            <a href="{{ route($item['route']) }}"
                                @click="$store.ui.toggleSidebarMobile(false)"
                                :title="$store.ui.sidebarCollapsed ? $t('{{ $item['labelKey'] }}') : null"
                                class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors {{ $active ? 'is-sidebar-active' : 'is-sidebar-inactive' }}"
                                :class="$store.ui.sidebarCollapsed ? 'justify-center' : ''">
                                <x-icon name="{{ $item['icon'] }}" :size="20" />
                                <span x-show="!$store.ui.sidebarCollapsed" class="flex-1" x-text="$t('{{ $item['labelKey'] }}')"></span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        @endforeach
    </div>

    <div class="mt-auto space-y-3 border-t border-themed py-4">
        <div x-show="!$store.ui.sidebarCollapsed" class="rounded-xl bg-brand-50 p-4 dark:bg-brand-500/10">
            <p class="text-xs font-medium text-muted" x-text="$t('appNav.proTitle')"></p>
            <p class="mt-0.5 text-sm font-semibold text-heading" x-text="$t('appNav.proDesc')"></p>
            <a href="{{ route('app.rates') }}"
                class="mt-3 flex h-9 w-full items-center justify-center rounded-lg bg-brand-500 text-xs font-medium text-white transition hover:bg-brand-600"
                x-text="$t('appNav.viewRates')"></a>
        </div>
        <a href="{{ route('home') }}"
            :title="$store.ui.sidebarCollapsed ? $t('nav.site') : null"
            class="is-sidebar-inactive group flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors"
            :class="$store.ui.sidebarCollapsed ? 'justify-center' : ''">
            <x-icon name="globe" :size="20" />
            <span x-show="!$store.ui.sidebarCollapsed" x-text="$t('nav.site')"></span>
        </a>
        <form method="POST" action="{{ route('logout') }}" @submit="$store.auth.logout()">
            @csrf
            <button type="submit"
                :title="$store.ui.sidebarCollapsed ? $t('appNav.logout') : null"
                class="is-sidebar-inactive group flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors"
                :class="$store.ui.sidebarCollapsed ? 'justify-center' : ''">
                <x-icon name="logout" :size="20" />
                <span x-show="!$store.ui.sidebarCollapsed" x-text="$t('appNav.logout')"></span>
            </button>
        </form>
    </div>
</aside>
