@props(['pageTitle' => null])
<!DOCTYPE html>
<html lang="pt-BR" :class="{ 'dark': $store.ui.darkMode }" x-data>
<head>
    @include('layouts.partials-head')
</head>
<body>
    <div class="flex min-h-screen flex-col" style="background-color: var(--tx-body-bg)" x-data>
        <x-layout.public-navbar />

        <main class="flex-1">
            {{ $slot }}
        </main>

        <x-layout.public-footer />
        <x-ui.toast-stack />
    </div>
    @stack('scripts')
</body>
</html>
