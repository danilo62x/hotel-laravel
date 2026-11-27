<x-layout.public :pageTitle="$pageTitle ?? null">
    {{-- Hero --}}
    <section class="relative overflow-hidden" x-data>
        <div class="absolute inset-0">
            <img src="{{ \App\Support\HtData::photoUrl('master-suite', 2, 1600, 900) }}" alt="" class="h-full w-full object-cover" />
            <div class="absolute inset-0 bg-gradient-to-r from-gray-950/85 via-gray-950/60 to-gray-950/30"></div>
        </div>
        <div class="relative mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8 lg:py-32">
            <div class="max-w-2xl">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-white backdrop-blur">
                    <x-icon name="star" :size="13" /> <span x-text="$t('home.heroBadge')"></span>
                </span>
                <h1 class="mt-5 text-title-md font-bold text-white sm:text-title-lg" x-text="$t('home.heroTitle')"></h1>
                <p class="mt-4 max-w-xl text-lg text-gray-200" x-text="$t('home.heroSubtitle')"></p>
            </div>

            <div class="mt-10 max-w-4xl rounded-2xl bg-white/95 p-5 shadow-theme-xl backdrop-blur dark:bg-gray-dark/95">
                <x-hotel.booking-widget variant="row" submitLabelKey="home.checkAvailability" submitExpr="window.location.href = '/quartos'" />
            </div>
        </div>
    </section>

    {{-- Stats --}}
    <section class="border-b border-themed surface-card" x-data="{ stats: [
            { value: '120+', key: 'rooms' }, { value: '4.8', key: 'rating' },
            { value: '60k', key: 'guests' }, { value: '15', key: 'years' },
        ] }">
        <div class="mx-auto grid max-w-7xl grid-cols-2 gap-6 px-4 py-10 sm:px-6 lg:grid-cols-4 lg:px-8">
            <template x-for="s in stats" :key="s.key">
                <div class="text-center">
                    <p class="text-title-sm font-bold text-brand-500" x-text="s.value"></p>
                    <p class="mt-1 text-sm text-muted" x-text="$t('home.stats.' + s.key)"></p>
                </div>
            </template>
        </div>
    </section>

    {{-- Featured rooms --}}
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8"
        x-data="{ get featured() { return $store.pms.roomTypes.filter(r => r.featured).slice(0, 3); } }">
        <div class="mb-8 text-center">
            <h2 class="text-title-sm font-bold text-heading" x-text="$t('home.featuredTitle')"></h2>
            <p class="mt-2 text-muted" x-text="$t('home.featuredSubtitle')"></p>
        </div>
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <template x-for="rt in featured" :key="rt.id">
                <x-hotel.room-type-card rt="rt" />
            </template>
        </div>
        <div class="mt-8 text-center">
            <a href="{{ route('rooms') }}"
                class="inline-flex h-11 items-center gap-2 rounded-lg border border-themed px-6 text-sm font-medium text-body transition hover:bg-gray-50 dark:hover:bg-gray-800">
                <span x-text="$t('home.viewAllRooms')"></span> <x-icon name="arrow-right" :size="16" />
            </a>
        </div>
    </section>

    {{-- Amenities --}}
    <section class="border-y border-themed surface-card">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="mb-8 text-center">
                <h2 class="text-title-sm font-bold text-heading" x-text="$t('home.amenitiesTitle')"></h2>
                <p class="mt-2 text-muted" x-text="$t('home.amenitiesSubtitle')"></p>
            </div>
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
                @foreach (\App\Support\HtData::hotelAmenities() as $a)
                    <div class="flex flex-col items-center gap-2 rounded-xl border border-themed p-4 text-center" x-data>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-500 dark:bg-brand-500/15">
                            <x-icon name="{{ $a['icon'] }}" :size="20" />
                        </span>
                        <span class="text-xs font-medium text-body" x-text="$t('hotelAmenities.{{ $a['key'] }}')"></span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Gallery --}}
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="mb-8 text-center">
            <h2 class="text-title-sm font-bold text-heading" x-text="$t('home.galleryTitle')"></h2>
            <p class="mt-2 text-muted" x-text="$t('home.gallerySubtitle')"></p>
        </div>
        <div class="grid grid-cols-2 gap-3 md:grid-cols-4">
            @php($gallery = ['deluxe-vista-mar', 'family-suite', 'master-suite', 'superior-twin', 'standard-casal', 'studio-executivo', 'deluxe-vista-mar', 'master-suite'])
            @foreach ($gallery as $i => $slug)
                <div class="overflow-hidden rounded-xl bg-gray-100 dark:bg-gray-800 {{ $i % 5 === 0 ? 'col-span-2 row-span-2' : '' }}">
                    <img src="{{ \App\Support\HtData::photoUrl($slug, ($i % 5) + 1, 500, 500) }}" alt="" loading="lazy"
                        class="aspect-square h-full w-full object-cover transition hover:scale-105" />
                </div>
            @endforeach
        </div>
    </section>

    {{-- Testimonials --}}
    <section class="border-y border-themed surface-card">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="mb-8 text-center">
                <h2 class="text-title-sm font-bold text-heading" x-text="$t('home.testimonialsTitle')"></h2>
                <p class="mt-2 text-muted" x-text="$t('home.testimonialsSubtitle')"></p>
            </div>
            <div class="grid gap-6 md:grid-cols-3">
                @foreach (\App\Support\HtData::testimonials() as $tm)
                    <figure class="rounded-2xl border border-themed p-6" x-data>
                        <div class="flex gap-1 text-warning-400">
                            @for ($i = 0; $i < 5; $i++)<x-icon name="star" :size="16" class="fill-current" />@endfor
                        </div>
                        <blockquote class="mt-4 text-sm text-body">“<span x-text="$t('testimonials.{{ $tm['key'] }}')"></span>”</blockquote>
                        <figcaption class="mt-4 flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-500 text-xs font-bold text-white"
                                x-text="htHelpers.initials($t('testimonials.{{ $tm['key'] }}Name'))"></span>
                            <div>
                                <p class="text-sm font-semibold text-heading" x-text="$t('testimonials.{{ $tm['key'] }}Name')"></p>
                                <p class="text-xs text-muted" x-text="$t('testimonials.{{ $tm['key'] }}Role')"></p>
                            </div>
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Location --}}
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8" x-data>
        <div class="grid items-center gap-8 lg:grid-cols-2">
            <div>
                <h2 class="text-title-sm font-bold text-heading" x-text="$t('home.locationTitle')"></h2>
                <p class="mt-3 text-muted" x-text="$t('home.locationText')"></p>
                <ul class="mt-5 space-y-3 text-sm">
                    <li class="flex items-center gap-3 text-body"><x-icon name="map-pin" :size="18" class="text-brand-500" /> <span x-text="$t('contact.addressValue')"></span></li>
                    <li class="flex items-center gap-3 text-body"><x-icon name="phone" :size="18" class="text-brand-500" /> <span x-text="$t('contact.phoneValue')"></span></li>
                    <li class="flex items-center gap-3 text-body"><x-icon name="mail" :size="18" class="text-brand-500" /> <span x-text="$t('contact.emailValue')"></span></li>
                </ul>
            </div>
            <div class="relative overflow-hidden rounded-2xl border border-themed">
                <img src="{{ \App\Support\HtData::photoUrl('deluxe-vista-mar', 3, 800, 500) }}" alt="" class="h-full w-full object-cover" />
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-brand-500" x-data>
        <div class="mx-auto max-w-7xl px-4 py-14 text-center sm:px-6 lg:px-8">
            <h2 class="text-title-sm font-bold text-white" x-text="$t('home.ctaTitle')"></h2>
            <p class="mt-2 text-brand-100" x-text="$t('home.ctaSubtitle')"></p>
            <a href="{{ route('rooms') }}"
                class="mt-6 inline-flex h-11 items-center gap-2 rounded-lg bg-white px-6 text-sm font-semibold text-brand-600 transition hover:bg-brand-50">
                <x-icon name="concierge-bell" :size="18" /> <span x-text="$t('home.ctaButton')"></span>
            </a>
        </div>
    </section>
</x-layout.public>
