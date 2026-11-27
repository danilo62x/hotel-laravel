{{-- Shared <head> contents + window.HT bootstrap for all layouts. --}}
<meta charset="UTF-8" />
<link rel="icon" type="image/svg+xml" href="/favicon.svg" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="manifest" href="/manifest.webmanifest" />
<meta name="theme-color" content="#465fff" />
<title>{{ isset($pageTitle) && $pageTitle ? $pageTitle . ' — ' : '' }}Hotel — Reservas &amp; PMS</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])
<script>
    // Canonical mock data shared with the Alpine stores (mirrors hotel/react src/data + stores).
    window.HT = {
        today: @json(\App\Support\HtData::TODAY),
        roomTypes: @json(\App\Support\HtData::roomTypes()),
        rooms: @json(\App\Support\HtData::rooms()),
        reservations: @json(\App\Support\HtData::reservations()),
        guests: @json(\App\Support\HtData::guests()),
        rates: @json(\App\Support\HtData::rates()),
        hotelAmenities: @json(\App\Support\HtData::hotelAmenities()),
        occupancySeries: @json(\App\Support\HtData::occupancySeries()),
        user: @json(session('user')),
    };
</script>
@stack('head')
