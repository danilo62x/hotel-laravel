<x-layout.blank :pageTitle="$pageTitle ?? null">
    <x-ui.auth-shell titleKey="auth.loginTitle" subtitleKey="auth.loginSubtitle">
        <x-slot:footer>
            <span x-text="$t('auth.noAccount')"></span>
            <a href="{{ route('register') }}" class="font-medium text-brand-500 hover:text-brand-600" x-text="$t('auth.registerCta')"></a>
        </x-slot:footer>

        <form method="POST" action="{{ route('login.submit') }}" class="space-y-5"
            x-data="{ showPassword: false, remember: true }"
            @submit="$store.auth.setUser({ id: 1, name: '', email: $refs.email.value, role: 'Recepção', phone: '+55 11 4000-2000' })">
            @csrf
            <input type="hidden" name="redirect" value="{{ request('redirect') }}" />

            @error('global')
                <p class="rounded-lg bg-error-50 px-4 py-2 text-center text-sm text-error-600 dark:bg-error-500/15 dark:text-error-500">{{ $message }}</p>
            @enderror

            <div>
                <label class="mb-2 block text-sm font-medium text-heading" for="email" x-text="$t('auth.email')"></label>
                <div class="relative">
                    <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><x-icon name="mail" :size="18" /></span>
                    <input id="email" x-ref="email" name="email" type="email" required value="{{ old('email', \App\Support\MockUsers::DEMO_EMAIL) }}" placeholder="seu@email.com"
                        class="h-11 w-full rounded-lg border border-themed bg-gray-50 pl-10 pr-3 text-sm text-body outline-none focus:border-brand-300 focus-ring dark:bg-gray-900" />
                </div>
                @error('email')<p class="mt-1 text-xs text-error-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-heading" for="password" x-text="$t('auth.password')"></label>
                <div class="relative">
                    <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><x-icon name="lock" :size="18" /></span>
                    <input id="password" name="password" :type="showPassword ? 'text' : 'password'" required value="{{ \App\Support\MockUsers::DEMO_PASSWORD }}" placeholder="••••••••"
                        class="h-11 w-full rounded-lg border border-themed bg-gray-50 pl-10 pr-10 text-sm text-body outline-none focus:border-brand-300 focus-ring dark:bg-gray-900" />
                    <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200" @click="showPassword = !showPassword">
                        <template x-if="showPassword"><x-icon name="eye-off" :size="18" /></template>
                        <template x-if="!showPassword"><x-icon name="eye" :size="18" /></template>
                    </button>
                </div>
                @error('password')<p class="mt-1 text-xs text-error-500">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2 text-body">
                    <input type="checkbox" x-model="remember" name="remember" class="h-4 w-4 rounded border-themed accent-brand-500" />
                    <span x-text="$t('auth.remember')"></span>
                </label>
                <a href="{{ route('password.request') }}" class="font-medium text-brand-500 hover:text-brand-600" x-text="$t('auth.forgot')"></a>
            </div>

            <button type="submit"
                class="flex h-11 w-full items-center justify-center rounded-lg bg-brand-500 text-sm font-medium text-white shadow-theme-xs transition hover:bg-brand-600 focus-ring"
                x-text="$t('auth.loginCta')"></button>
        </form>

        <div class="mt-6 rounded-lg border border-dashed border-themed bg-gray-50/60 p-3 text-xs text-muted dark:bg-gray-900/40">
            <p class="font-medium text-body" x-text="$t('auth.demoTitle')"></p>
            <p>{{ \App\Support\MockUsers::DEMO_EMAIL }} / {{ \App\Support\MockUsers::DEMO_PASSWORD }}</p>
            <p class="mt-0.5" x-text="$t('auth.demoHint')"></p>
        </div>
    </x-ui.auth-shell>
</x-layout.blank>
