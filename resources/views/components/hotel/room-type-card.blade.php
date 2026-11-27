@props([
    'rt' => 'rt',
])
{{-- Room-type card — mirrors hotel/react components/hotel/RoomTypeCard.tsx.
    `rt` is an Alpine expression resolving to a room-type object. --}}
<a x-data="{ rt: {{ $rt }} }" :href="`/quartos/${rt.slug}`"
    class="group surface-card flex flex-col overflow-hidden rounded-2xl border transition hover:shadow-theme-lg">
    <div class="relative aspect-[4/3] overflow-hidden bg-gray-100 dark:bg-gray-800">
        <img :src="htHelpers.photoUrl(rt.slug, 1, 600, 450)" :alt="rt.name" loading="lazy"
            class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
        <template x-if="rt.featured">
            <span class="absolute left-3 top-3 inline-flex items-center gap-1.5 rounded-full bg-brand-500 px-2.5 py-1 text-xs font-medium text-white">
                <x-icon name="star" :size="12" /> <span x-text="$t('rooms.featured')"></span>
            </span>
        </template>
        <span class="absolute bottom-3 right-3 rounded-lg bg-gray-900/70 px-2.5 py-1 text-xs font-medium text-white backdrop-blur"
            x-text="rt.size + ' m²'"></span>
    </div>

    <div class="flex flex-1 flex-col p-5">
        <h3 class="text-base font-semibold text-heading group-hover:text-brand-600" x-text="rt.name"></h3>
        <p class="mt-1 line-clamp-2 text-sm text-muted" x-text="rt.description"></p>

        <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-1.5 text-xs text-muted">
            <span class="inline-flex items-center gap-1.5">
                <x-icon name="users" :size="14" /> <span x-text="$t('booking.guestCount', { count: rt.capacity })"></span>
            </span>
            <span class="inline-flex items-center gap-1.5">
                <x-icon name="bed" :size="14" /> <span x-text="$t('beds.' + rt.bed)"></span>
            </span>
        </div>

        <div class="mt-3 flex flex-wrap gap-1.5">
            <template x-for="a in rt.amenities.slice(0, 3)" :key="a">
                <span class="rounded-md bg-gray-100 px-2 py-0.5 text-[11px] text-gray-600 dark:bg-gray-800 dark:text-gray-300"
                    x-text="$t('amenities.' + a)"></span>
            </template>
        </div>

        <div class="mt-auto flex items-end justify-between pt-4">
            <div>
                <span class="text-xs text-muted" x-text="$t('common.from')"></span>
                <p class="text-lg font-bold text-heading">
                    <span x-text="$currency(rt.baseRate)"></span>
                    <span class="text-xs font-normal text-muted" x-text="$t('common.perNight')"></span>
                </p>
            </div>
            <span class="inline-flex items-center gap-1 text-sm font-medium text-brand-600 dark:text-brand-400">
                <span x-text="$t('rooms.view')"></span> <x-icon name="arrow-right" :size="14" />
            </span>
        </div>
    </div>
</a>
