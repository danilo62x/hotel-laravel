@props(['pageTitle' => null])
<!DOCTYPE html>
<html lang="pt-BR" :class="{ 'dark': $store.ui.darkMode }" x-data>
<head>
    @include('layouts.partials-head')
</head>
<body>
    {{ $slot }}
    <x-ui.toast-stack />
    @stack('scripts')
</body>
</html>
