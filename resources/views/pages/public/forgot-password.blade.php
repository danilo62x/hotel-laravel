<x-layout.blank :pageTitle="$pageTitle ?? null">
    <x-ui.auth-shell titleKey="auth.forgotTitle" subtitleKey="auth.forgotSubtitle">
        <x-slot:footer>
            <a href="{{ route('login') }}" class="font-medium text-brand-500 hover:text-brand-600" x-text="$t('auth.backToLogin')"></a>
        </x-slot:footer>

        <form class="space-y-5" x-data="{ sent: false }" @submit.prevent="sent = true; $store.ui.notifySuccess($t('auth.resetSent'))">
            <template x-if="sent">
                <p class="rounded-lg bg-success-50 px-4 py-3 text-center text-sm text-success-700 dark:bg-success-500/15 dark:text-success-500" x-text="$t('auth.resetSent')"></p>
            </template>

            <div>
                <label class="mb-2 block text-sm font-medium text-heading" for="email" x-text="$t('auth.email')"></label>
                <div class="relative">
                    <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><x-icon name="mail" :size="18" /></span>
                    <input id="email" name="email" type="email" required placeholder="seu@email.com"
                        class="h-11 w-full rounded-lg border border-themed bg-gray-50 pl-10 pr-3 text-sm text-body outline-none focus:border-brand-300 focus-ring dark:bg-gray-900" />
                </div>
            </div>

            <button type="submit"
                class="flex h-11 w-full items-center justify-center rounded-lg bg-brand-500 text-sm font-medium text-white shadow-theme-xs transition hover:bg-brand-600 focus-ring"
                x-text="$t('auth.sendLink')"></button>
        </form>
    </x-ui.auth-shell>
</x-layout.blank>
