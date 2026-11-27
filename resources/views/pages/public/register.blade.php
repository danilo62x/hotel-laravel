<x-layout.blank :pageTitle="$pageTitle ?? null">
    <x-ui.auth-shell titleKey="auth.registerTitle" subtitleKey="auth.registerSubtitle">
        <x-slot:footer>
            <span x-text="$t('auth.hasAccount')"></span>
            <a href="{{ route('login') }}" class="font-medium text-brand-500 hover:text-brand-600" x-text="$t('auth.loginCta')"></a>
        </x-slot:footer>

        <form method="POST" action="{{ route('register.submit') }}" class="space-y-5"
            x-data="{ showPassword: false }"
            @submit="$store.auth.setUser({ id: 1, name: $refs.name.value, email: $refs.email.value, role: 'Recepção', phone: '' })">
            @csrf

            <div>
                <label class="mb-2 block text-sm font-medium text-heading" for="name" x-text="$t('auth.name')"></label>
                <div class="relative">
                    <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><x-icon name="user" :size="18" /></span>
                    <input id="name" x-ref="name" name="name" type="text" required value="{{ old('name') }}" placeholder="Helena Castro"
                        class="h-11 w-full rounded-lg border border-themed bg-gray-50 pl-10 pr-3 text-sm text-body outline-none focus:border-brand-300 focus-ring dark:bg-gray-900" />
                </div>
                @error('name')<p class="mt-1 text-xs text-error-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-heading" for="email" x-text="$t('auth.email')"></label>
                <div class="relative">
                    <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><x-icon name="mail" :size="18" /></span>
                    <input id="email" x-ref="email" name="email" type="email" required value="{{ old('email') }}" placeholder="seu@email.com"
                        class="h-11 w-full rounded-lg border border-themed bg-gray-50 pl-10 pr-3 text-sm text-body outline-none focus:border-brand-300 focus-ring dark:bg-gray-900" />
                </div>
                @error('email')<p class="mt-1 text-xs text-error-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-heading" for="password" x-text="$t('auth.password')"></label>
                <div class="relative">
                    <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><x-icon name="lock" :size="18" /></span>
                    <input id="password" name="password" :type="showPassword ? 'text' : 'password'" required placeholder="••••••••"
                        class="h-11 w-full rounded-lg border border-themed bg-gray-50 pl-10 pr-10 text-sm text-body outline-none focus:border-brand-300 focus-ring dark:bg-gray-900" />
                    <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200" @click="showPassword = !showPassword">
                        <template x-if="showPassword"><x-icon name="eye-off" :size="18" /></template>
                        <template x-if="!showPassword"><x-icon name="eye" :size="18" /></template>
                    </button>
                </div>
                @error('password')<p class="mt-1 text-xs text-error-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-heading" for="password_confirmation" x-text="$t('auth.password')"></label>
                <div class="relative">
                    <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><x-icon name="lock" :size="18" /></span>
                    <input id="password_confirmation" name="password_confirmation" :type="showPassword ? 'text' : 'password'" required placeholder="••••••••"
                        class="h-11 w-full rounded-lg border border-themed bg-gray-50 pl-10 pr-3 text-sm text-body outline-none focus:border-brand-300 focus-ring dark:bg-gray-900" />
                </div>
            </div>

            <button type="submit"
                class="flex h-11 w-full items-center justify-center rounded-lg bg-brand-500 text-sm font-medium text-white shadow-theme-xs transition hover:bg-brand-600 focus-ring"
                x-text="$t('auth.registerCta')"></button>
        </form>
    </x-ui.auth-shell>
</x-layout.blank>
