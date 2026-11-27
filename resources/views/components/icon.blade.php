@props([
    'name' => '',
    'size' => 20,
    'strokeWidth' => 1.8,
])

{{-- Inline-SVG icon set — mirrors saas/react src/components/ui/IconBase.tsx --}}
<svg
    width="{{ $size }}"
    height="{{ $size }}"
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-width="{{ $strokeWidth }}"
    stroke-linecap="round"
    stroke-linejoin="round"
    {{ $attributes->merge(['class' => 'shrink-0']) }}
>
    @switch($name)
        @case('dashboard')
            <rect x="3" y="3" width="7" height="9" rx="1" />
            <rect x="14" y="3" width="7" height="5" rx="1" />
            <rect x="14" y="12" width="7" height="9" rx="1" />
            <rect x="3" y="16" width="7" height="5" rx="1" />
            @break
        @case('grid')
            <rect x="3" y="3" width="7" height="7" rx="1" />
            <rect x="14" y="3" width="7" height="7" rx="1" />
            <rect x="3" y="14" width="7" height="7" rx="1" />
            <rect x="14" y="14" width="7" height="7" rx="1" />
            @break
        @case('user')
            <circle cx="12" cy="8" r="4" />
            <path d="M4 21c0-4 4-7 8-7s8 3 8 7" />
            @break
        @case('users')
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
            <circle cx="9" cy="7" r="4" />
            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
            @break
        @case('settings')
            <circle cx="12" cy="12" r="3" />
            <path d="M19.4 15a1.7 1.7 0 0 0 .3 1.8l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.8-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.8.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.8 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.5-1.1 1.7 1.7 0 0 0-.3-1.8l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.8.3h0a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.8-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.8v0a1.7 1.7 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z" />
            @break
        @case('logout')
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
            <polyline points="16 17 21 12 16 7" />
            <line x1="21" y1="12" x2="9" y2="12" />
            @break
        @case('search')
            <circle cx="11" cy="11" r="7" />
            <line x1="21" y1="21" x2="16.65" y2="16.65" />
            @break
        @case('bell')
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
            <path d="M13.7 21a2 2 0 0 1-3.4 0" />
            @break
        @case('sun')
            <circle cx="12" cy="12" r="5" />
            <line x1="12" y1="1" x2="12" y2="3" />
            <line x1="12" y1="21" x2="12" y2="23" />
            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64" />
            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78" />
            <line x1="1" y1="12" x2="3" y2="12" />
            <line x1="21" y1="12" x2="23" y2="12" />
            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36" />
            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22" />
            @break
        @case('moon')
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
            @break
        @case('menu')
            <line x1="3" y1="6" x2="21" y2="6" />
            <line x1="3" y1="12" x2="21" y2="12" />
            <line x1="3" y1="18" x2="21" y2="18" />
            @break
        @case('x')
            <line x1="18" y1="6" x2="6" y2="18" />
            <line x1="6" y1="6" x2="18" y2="18" />
            @break
        @case('chevron-down')
            <polyline points="6 9 12 15 18 9" />
            @break
        @case('chevron-right')
            <polyline points="9 18 15 12 9 6" />
            @break
        @case('arrow-up')
            <line x1="12" y1="19" x2="12" y2="5" />
            <polyline points="5 12 12 5 19 12" />
            @break
        @case('arrow-down')
            <line x1="12" y1="5" x2="12" y2="19" />
            <polyline points="19 12 12 19 5 12" />
            @break
        @case('arrow-right')
            <line x1="5" y1="12" x2="19" y2="12" />
            <polyline points="12 5 19 12 12 19" />
            @break
        @case('check')
            <polyline points="20 6 9 17 4 12" />
            @break
        @case('check-circle')
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
            <polyline points="22 4 12 14.01 9 11.01" />
            @break
        @case('eye')
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
            <circle cx="12" cy="12" r="3" />
            @break
        @case('eye-off')
            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" />
            <line x1="1" y1="1" x2="23" y2="23" />
            @break
        @case('plus')
            <line x1="12" y1="5" x2="12" y2="19" />
            <line x1="5" y1="12" x2="19" y2="12" />
            @break
        @case('minus')
            <line x1="5" y1="12" x2="19" y2="12" />
            @break
        @case('edit')
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
            @break
        @case('trash')
            <polyline points="3 6 5 6 21 6" />
            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
            <line x1="10" y1="11" x2="10" y2="17" />
            <line x1="14" y1="11" x2="14" y2="17" />
            @break
        @case('mail')
            <path d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z" />
            <polyline points="22 6 12 13 2 6" />
            @break
        @case('lock')
            <rect x="3" y="11" width="18" height="11" rx="2" />
            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
            @break
        @case('trending-up')
            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
            <polyline points="17 6 23 6 23 12" />
            @break
        @case('trending-down')
            <polyline points="23 18 13.5 8.5 8.5 13.5 1 6" />
            <polyline points="17 18 23 18 23 12" />
            @break
        @case('dollar')
            <line x1="12" y1="1" x2="12" y2="23" />
            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
            @break
        @case('credit-card')
            <rect x="1" y="4" width="22" height="16" rx="2" />
            <line x1="1" y1="10" x2="23" y2="10" />
            @break
        @case('package')
            <line x1="16.5" y1="9.4" x2="7.5" y2="4.21" />
            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
            <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
            <line x1="12" y1="22.08" x2="12" y2="12" />
            @break
        @case('chart')
            <line x1="3" y1="21" x2="21" y2="21" />
            <rect x="5" y="11" width="3" height="9" rx="0.5" />
            <rect x="10.5" y="6" width="3" height="14" rx="0.5" />
            <rect x="16" y="14" width="3" height="6" rx="0.5" />
            @break
        @case('bar-chart')
            <line x1="12" y1="20" x2="12" y2="10" />
            <line x1="18" y1="20" x2="18" y2="4" />
            <line x1="6" y1="20" x2="6" y2="16" />
            @break
        @case('activity')
            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
            @break
        @case('tag')
            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z" />
            <circle cx="7" cy="7" r="1.5" fill="currentColor" />
            @break
        @case('info')
            <circle cx="12" cy="12" r="10" />
            <line x1="12" y1="16" x2="12" y2="12" />
            <line x1="12" y1="8" x2="12.01" y2="8" />
            @break
        @case('help')
            <circle cx="12" cy="12" r="10" />
            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" />
            <line x1="12" y1="17" x2="12.01" y2="17" />
            @break
        @case('cookie')
            <path d="M21 12c0 5-4 9-9 9s-9-4-9-9 4-9 9-9c0 .3 0 .6.05.88a3.5 3.5 0 0 0 3.62 3.62c.27.04.55.05.83.05A3.5 3.5 0 0 0 19.5 11c.5.3 1 .5 1.5.5z" />
            <circle cx="9" cy="11" r="1" fill="currentColor" />
            <circle cx="14" cy="16" r="1" fill="currentColor" />
            <circle cx="9" cy="16" r="0.7" fill="currentColor" />
            <circle cx="15.5" cy="11.5" r="0.7" fill="currentColor" />
            @break
        @case('star')
            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
            @break
        @case('zap')
            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" />
            @break
        @case('shield')
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
            @break
        @case('shield-check')
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
            <polyline points="9 11 11 13 15 9" />
            @break
        @case('rocket')
            <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z" />
            <path d="M12 15l-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z" />
            <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0" />
            @break
        @case('globe')
            <circle cx="12" cy="12" r="10" />
            <line x1="2" y1="12" x2="22" y2="12" />
            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
            @break
        @case('copy')
            <rect x="9" y="9" width="13" height="13" rx="2" />
            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
            @break
        @case('download')
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
            <polyline points="7 10 12 15 17 10" />
            <line x1="12" y1="15" x2="12" y2="3" />
            @break
        @case('filter')
            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3" />
            @break
        @case('dots-vertical')
            <circle cx="12" cy="5" r="1.5" fill="currentColor" />
            <circle cx="12" cy="12" r="1.5" fill="currentColor" />
            <circle cx="12" cy="19" r="1.5" fill="currentColor" />
            @break
        @case('folder')
            <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z" />
            @break
        @case('key')
            <path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3" />
            @break
        @case('link')
            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" />
            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />
            @break
        @case('file-text')
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
            <polyline points="14 2 14 8 20 8" />
            <line x1="16" y1="13" x2="8" y2="13" />
            <line x1="16" y1="17" x2="8" y2="17" />
            <line x1="10" y1="9" x2="8" y2="9" />
            @break
        @case('briefcase')
            <rect x="2" y="7" width="20" height="14" rx="2" />
            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
            @break
        @case('layers')
            <polygon points="12 2 2 7 12 12 22 7 12 2" />
            <polyline points="2 17 12 22 22 17" />
            <polyline points="2 12 12 17 22 12" />
            @break
        @case('clock')
            <circle cx="12" cy="12" r="10" />
            <polyline points="12 6 12 12 16 14" />
            @break
        @case('message-circle')
            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8z" />
            @break
        @case('map-pin')
            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
            <circle cx="12" cy="10" r="3" />
            @break
        @case('phone')
            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z" />
            @break
        @case('refresh-cw')
            <polyline points="23 4 23 10 17 10" />
            <polyline points="1 20 1 14 7 14" />
            <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15" />
            @break
        @case('slack')
            <rect x="13" y="2" width="3" height="8" rx="1.5" />
            <rect x="8" y="14" width="3" height="8" rx="1.5" />
            <rect x="14" y="13" width="8" height="3" rx="1.5" />
            <rect x="2" y="8" width="8" height="3" rx="1.5" />
            @break
        @case('github')
            <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22" />
            @break
        @case('home')
            <path d="M3 9.5L12 3l9 6.5V20a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1z" />
            @break

        {{-- ── finance / banking ── --}}
        @case('wallet')
            <path d="M3 7a2 2 0 0 1 2-2h13a1 1 0 0 1 1 1v2" />
            <path d="M3 7v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2H5a2 2 0 0 1-2-2z" />
            <circle cx="16.5" cy="12.5" r="1.2" fill="currentColor" />
            @break
        @case('bank')
            <line x1="3" y1="21" x2="21" y2="21" />
            <line x1="3" y1="10" x2="21" y2="10" />
            <polyline points="5 6 12 3 19 6" />
            <line x1="4" y1="10" x2="4" y2="21" />
            <line x1="9" y1="10" x2="9" y2="21" />
            <line x1="15" y1="10" x2="15" y2="21" />
            <line x1="20" y1="10" x2="20" y2="21" />
            @break
        @case('arrow-up-right')
            <line x1="7" y1="17" x2="17" y2="7" />
            <polyline points="7 7 17 7 17 17" />
            @break
        @case('arrow-down-left')
            <line x1="17" y1="7" x2="7" y2="17" />
            <polyline points="17 17 7 17 7 7" />
            @break
        @case('arrow-left')
            <line x1="19" y1="12" x2="5" y2="12" />
            <polyline points="12 19 5 12 12 5" />
            @break
        @case('chevron-left')
            <polyline points="15 18 9 12 15 6" />
            @break
        @case('pix')
            <path d="M12 3.5 8.5 7H10a2 2 0 0 1 1.4.6L12 8.2l.6-.6A2 2 0 0 1 14 7h1.5L12 3.5z" />
            <path d="M12 20.5 15.5 17H14a2 2 0 0 1-1.4-.6L12 15.8l-.6.6A2 2 0 0 1 10 17H8.5L12 20.5z" />
            <path d="M3.5 12 7 8.5V10a2 2 0 0 0 .6 1.4l.6.6-.6.6A2 2 0 0 0 7 14v1.5L3.5 12z" />
            <path d="M20.5 12 17 15.5V14a2 2 0 0 0-.6-1.4l-.6-.6.6-.6A2 2 0 0 0 17 10V8.5L20.5 12z" />
            @break
        @case('bitcoin')
            <circle cx="12" cy="12" r="9" />
            <path d="M9.5 8h4a2 2 0 0 1 0 4h-4m0 0h4.3a2 2 0 0 1 0 4H9.5m0-8V6.5m0 9.5V17.5m3-11.5V8m0 8v1.5M9.5 8v8" />
            @break
        @case('coins')
            <ellipse cx="9" cy="7" rx="6" ry="3" />
            <path d="M3 7v5c0 1.66 2.69 3 6 3s6-1.34 6-3V7" />
            <path d="M15 11.5c2.3-.3 4-1.3 4-2.5" />
            <path d="M9 15v3c0 1.66 2.69 3 6 3s6-1.34 6-3v-5" />
            @break
        @case('qr')
            <rect x="3" y="3" width="7" height="7" rx="1" />
            <rect x="14" y="3" width="7" height="7" rx="1" />
            <rect x="3" y="14" width="7" height="7" rx="1" />
            <line x1="14" y1="14" x2="14" y2="17" />
            <line x1="14" y1="20" x2="14" y2="21" />
            <line x1="17" y1="14" x2="21" y2="14" />
            <line x1="21" y1="17" x2="21" y2="21" />
            <line x1="17" y1="21" x2="18" y2="21" />
            <line x1="17" y1="17" x2="18" y2="17" />
            @break
        @case('pie-chart')
            <path d="M21.21 15.89A10 10 0 1 1 8 2.83" />
            <path d="M22 12A10 10 0 0 0 12 2v10z" />
            @break
        @case('smartphone')
            <rect x="5" y="2" width="14" height="20" rx="2" />
            <line x1="12" y1="18" x2="12.01" y2="18" />
            @break
        @case('repeat')
            <polyline points="17 1 21 5 17 9" />
            <path d="M3 11V9a4 4 0 0 1 4-4h14" />
            <polyline points="7 23 3 19 7 15" />
            <path d="M21 13v2a4 4 0 0 1-4 4H3" />
            @break
        @case('shopping-bag')
            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
            <line x1="3" y1="6" x2="21" y2="6" />
            <path d="M16 10a4 4 0 0 1-8 0" />
            @break
        @case('car')
            <path d="M5 13l1.5-4.5A2 2 0 0 1 8.4 7h7.2a2 2 0 0 1 1.9 1.5L19 13" />
            <path d="M3 13h18v4a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1v-1H6v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z" />
            <circle cx="7" cy="16" r="0.5" fill="currentColor" />
            <circle cx="17" cy="16" r="0.5" fill="currentColor" />
            @break
        @case('coffee')
            <path d="M4 8h13v5a4 4 0 0 1-4 4H8a4 4 0 0 1-4-4z" />
            <path d="M17 9h2a2 2 0 0 1 0 4h-2" />
            <line x1="6" y1="2" x2="6" y2="4" />
            <line x1="10" y1="2" x2="10" y2="4" />
            <line x1="14" y1="2" x2="14" y2="4" />
            @break
        @case('heart')
            <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1 7.8 7.8 7.8-7.8 1-1a5.5 5.5 0 0 0 0-7.8z" />
            @break
        @case('film')
            <rect x="2" y="4" width="20" height="16" rx="2" />
            <line x1="7" y1="4" x2="7" y2="20" />
            <line x1="17" y1="4" x2="17" y2="20" />
            <line x1="2" y1="12" x2="22" y2="12" />
            <line x1="2" y1="8" x2="7" y2="8" />
            <line x1="2" y1="16" x2="7" y2="16" />
            <line x1="17" y1="8" x2="22" y2="8" />
            <line x1="17" y1="16" x2="22" y2="16" />
            @break
        @case('plus-circle')
            <circle cx="12" cy="12" r="10" />
            <line x1="12" y1="8" x2="12" y2="16" />
            <line x1="8" y1="12" x2="16" y2="12" />
            @break
        @case('send')
            <line x1="22" y1="2" x2="11" y2="13" />
            <polygon points="22 2 15 22 11 13 2 9 22 2" />
            @break
        @case('alert-triangle')
            <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
            <line x1="12" y1="9" x2="12" y2="13" />
            <line x1="12" y1="17" x2="12.01" y2="17" />
            @break
        @case('pause')
            <rect x="6" y="4" width="4" height="16" rx="1" />
            <rect x="14" y="4" width="4" height="16" rx="1" />
            @break
        @case('snowflake')
            <line x1="12" y1="2" x2="12" y2="22" />
            <line x1="2" y1="12" x2="22" y2="12" />
            <line x1="5" y1="5" x2="19" y2="19" />
            <line x1="19" y1="5" x2="5" y2="19" />
            @break
        @case('file-invoice')
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
            <polyline points="14 2 14 8 20 8" />
            <line x1="8" y1="13" x2="16" y2="13" />
            <line x1="8" y1="17" x2="12" y2="17" />
            @break
        @case('sliders')
            <line x1="4" y1="21" x2="4" y2="14" />
            <line x1="4" y1="10" x2="4" y2="3" />
            <line x1="12" y1="21" x2="12" y2="12" />
            <line x1="12" y1="8" x2="12" y2="3" />
            <line x1="20" y1="21" x2="20" y2="16" />
            <line x1="20" y1="12" x2="20" y2="3" />
            <line x1="1" y1="14" x2="7" y2="14" />
            <line x1="9" y1="8" x2="15" y2="8" />
            <line x1="17" y1="16" x2="23" y2="16" />
            @break

        {{-- ── hotel / hospitality ── --}}
        @case('wifi')
            <path d="M5 12.55a11 11 0 0 1 14.08 0" />
            <path d="M1.42 9a16 16 0 0 1 21.16 0" />
            <path d="M8.53 16.11a6 6 0 0 1 6.95 0" />
            <line x1="12" y1="20" x2="12.01" y2="20" />
            @break
        @case('wave')
            <path d="M2 6c1.5 0 2.5 1.5 4 1.5S12 6 13.5 6 17.5 7.5 19 7.5 21.5 6 22 6" />
            <path d="M2 12c1.5 0 2.5 1.5 4 1.5S12 12 13.5 12s4 1.5 5.5 1.5S21.5 12 22 12" />
            <path d="M2 18c1.5 0 2.5 1.5 4 1.5S12 18 13.5 18s4 1.5 5.5 1.5S21.5 18 22 18" />
            @break
        @case('concierge-bell')
            <path d="M3 18h18" />
            <path d="M4 18a8 8 0 0 1 16 0" />
            <line x1="12" y1="6" x2="12" y2="10" />
            <path d="M10 6a2 2 0 0 1 4 0" />
            @break
        @case('dumbbell')
            <path d="M6.5 6.5 17.5 17.5" />
            <path d="m21 21-1-1" />
            <path d="m3 3 1 1" />
            <path d="m18 22 4-4" />
            <path d="m2 6 4-4" />
            <path d="m3 10 7-7" />
            <path d="m14 21 7-7" />
            @break
        @case('sparkles')
            <path d="M12 3l1.9 5.1L19 10l-5.1 1.9L12 17l-1.9-5.1L5 10l5.1-1.9z" />
            <path d="M19 15l.8 2.2L22 18l-2.2.8L19 21l-.8-2.2L16 18l2.2-.8z" />
            @break
        @case('wrench')
            <path d="M14.7 6.3a4 4 0 0 0-5.4 5.3L3 18l3 3 6.4-6.3a4 4 0 0 0 5.3-5.4l-2.6 2.6-2.3-2.3z" />
            @break
        @case('log-in')
            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
            <polyline points="10 17 15 12 10 7" />
            <line x1="15" y1="12" x2="3" y2="12" />
            @break
        @case('calendar')
            <rect x="3" y="4" width="18" height="18" rx="2" />
            <line x1="16" y1="2" x2="16" y2="6" />
            <line x1="8" y1="2" x2="8" y2="6" />
            <line x1="3" y1="10" x2="21" y2="10" />
            @break
        @case('star')
            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
            @break
        @case('bed')
            <path d="M2 8v12" />
            <path d="M2 13h20v7" />
            <path d="M22 13v-3a2 2 0 0 0-2-2H10v5" />
            <circle cx="6" cy="11" r="1.5" fill="currentColor" />
            @break
        @case('maximize')
            <path d="M8 3H5a2 2 0 0 0-2 2v3" />
            <path d="M21 8V5a2 2 0 0 0-2-2h-3" />
            <path d="M3 16v3a2 2 0 0 0 2 2h3" />
            <path d="M16 21h3a2 2 0 0 0 2-2v-3" />
            @break
        @case('tv')
            <rect x="2" y="7" width="20" height="13" rx="2" />
            <polyline points="17 2 12 7 7 2" />
            @break
    @endswitch
</svg>
