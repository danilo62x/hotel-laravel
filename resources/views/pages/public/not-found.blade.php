<x-layout.blank :pageTitle="$pageTitle ?? null">
    <div class="flex min-h-screen flex-col items-center justify-center bg-gradient-to-br from-brand-50 via-white to-brand-100 px-4 text-center dark:from-gray-900 dark:via-gray-dark dark:to-gray-900" x-data>
        <p class="text-title-2xl font-bold text-brand-500">404</p>
        <h1 class="mt-2 text-title-sm font-bold text-heading" x-text="$t('notFound.title')"></h1>
        <p class="mt-2 max-w-md text-muted" x-text="$t('notFound.desc')"></p>
        <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
            <a href="{{ route('home') }}" class="inline-flex h-11 items-center gap-2 rounded-lg bg-brand-500 px-6 text-sm font-medium text-white transition hover:bg-brand-600">
                <x-icon name="home" :size="16" /> <span x-text="$t('notFound.home')"></span>
            </a>
            <template x-if="$store.auth.isAuthenticated">
                <a href="{{ route('dashboard') }}" class="inline-flex h-11 items-center gap-2 rounded-lg border border-themed px-6 text-sm font-medium text-body transition hover:bg-gray-50 dark:hover:bg-gray-800">
                    <x-icon name="dashboard" :size="16" /> <span x-text="$t('notFound.dashboard')"></span>
                </a>
            </template>
        </div>
    </div>
</x-layout.blank>
