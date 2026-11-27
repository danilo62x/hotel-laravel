@props(['pageTitle' => null])
<!DOCTYPE html>
<html lang="pt-BR" :class="{ 'dark': $store.ui.darkMode }" x-data>
<head>
    @include('layouts.partials-head')
</head>
<body>
    <div class="flex h-screen overflow-hidden" style="background-color: var(--tx-body-bg)" x-data>
        <x-layout.app-sidebar />

        <div x-show="$store.ui.sidebarMobileOpen" x-cloak
            class="fixed inset-0 z-40 bg-gray-900/50 lg:hidden"
            @click="$store.ui.toggleSidebarMobile(false)"></div>

        <div class="relative flex flex-1 flex-col overflow-x-hidden overflow-y-auto">
            <x-layout.app-header />
            <main class="flex-1">
                <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
                    {{ $slot }}
                </div>
            </main>
            <x-layout.app-footer />
        </div>

        <x-ui.toast-stack />
    </div>
    @stack('scripts')
</body>
</html>
