<footer class="border-t border-themed surface-card" x-data>
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="flex flex-col items-start justify-between gap-8 lg:flex-row">
            <div class="max-w-sm">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-500 text-white">
                        <x-icon name="concierge-bell" :size="18" />
                    </span>
                    <span class="text-lg font-bold text-heading" x-text="$t('brand')"></span>
                </a>
                <p class="mt-4 text-sm text-muted" x-text="$t('footer.tagline')"></p>
                <ul class="mt-4 space-y-1.5 text-sm text-muted">
                    <li class="flex items-center gap-2"><x-icon name="map-pin" :size="15" class="text-brand-500" /> <span x-text="$t('contact.addressValue')"></span></li>
                    <li class="flex items-center gap-2"><x-icon name="phone" :size="15" class="text-brand-500" /> <span x-text="$t('contact.phoneValue')"></span></li>
                </ul>
            </div>
            <div class="flex flex-wrap gap-x-10 gap-y-2 text-sm">
                <a href="{{ route('rooms') }}" class="text-muted transition hover:text-brand-600" x-text="$t('nav.rooms')"></a>
                <a href="{{ route('amenities') }}" class="text-muted transition hover:text-brand-600" x-text="$t('nav.amenities')"></a>
                <a href="{{ route('about') }}" class="text-muted transition hover:text-brand-600" x-text="$t('nav.about')"></a>
                <a href="{{ route('contact') }}" class="text-muted transition hover:text-brand-600" x-text="$t('nav.contact')"></a>
            </div>
        </div>
        <div class="mt-10 flex flex-col items-center justify-between gap-4 border-t border-themed pt-6 sm:flex-row">
            <p class="text-xs text-muted">© {{ date('Y') }} <span x-text="$t('brand')"></span>. <span x-text="$t('footer.rights')"></span></p>
            <div class="flex items-center gap-3">
                @foreach (['github', 'slack', 'globe'] as $icon)
                    <a href="#" aria-label="{{ $icon }}"
                        class="flex h-9 w-9 items-center justify-center rounded-full border border-themed text-muted transition hover:text-brand-500">
                        <x-icon name="{{ $icon }}" :size="16" />
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</footer>
