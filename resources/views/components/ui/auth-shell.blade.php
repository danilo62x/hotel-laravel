@props([
    'titleKey' => '',
    'subtitleKey' => '',
])
<div class="relative flex min-h-screen items-center justify-center bg-gradient-to-br from-brand-50 via-white to-brand-100 px-4 py-10 dark:from-gray-900 dark:via-gray-dark dark:to-gray-900" x-data>
    <div class="absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-32 -right-32 h-96 w-96 rounded-full bg-brand-200/40 blur-3xl dark:bg-brand-500/10"></div>
        <div class="absolute -bottom-32 -left-32 h-96 w-96 rounded-full bg-warning-100/60 blur-3xl dark:bg-brand-700/10"></div>
    </div>

    <div class="w-full max-w-md">
        <div class="mb-6 flex flex-col items-center">
            <a href="{{ route('home') }}" class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-500 text-white shadow-theme-md">
                <x-icon name="concierge-bell" :size="26" />
            </a>
            <h1 class="mt-5 text-title-sm font-bold text-heading" x-text="$t('{{ $titleKey }}')"></h1>
            <p class="mt-2 text-center text-sm text-muted" x-text="$t('{{ $subtitleKey }}')"></p>
        </div>

        <div class="surface-card rounded-2xl border p-6 shadow-theme-md md:p-8">{{ $slot }}</div>

        @isset($footer)
            <p class="mt-6 text-center text-sm text-muted">{{ $footer }}</p>
        @endisset

        <p class="mt-6 text-center text-xs text-muted">
            <a href="{{ route('home') }}" class="hover:text-brand-500">← <span x-text="$t('brand')"></span></a>
        </p>
    </div>
</div>
