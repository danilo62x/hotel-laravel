<x-layout.public :pageTitle="$pageTitle ?? null">
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8" x-data>
        <div class="mb-10 text-center">
            <h1 class="text-title-md font-bold text-heading" x-text="$t('amenitiesPage.title')"></h1>
            <p class="mx-auto mt-3 max-w-2xl text-muted" x-text="$t('amenitiesPage.subtitle')"></p>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach (\App\Support\HtData::hotelAmenities() as $a)
                <div class="surface-card flex gap-4 rounded-2xl border p-6" x-data>
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-500 dark:bg-brand-500/15">
                        <x-icon name="{{ $a['icon'] }}" :size="24" />
                    </span>
                    <div>
                        <h3 class="text-base font-semibold text-heading" x-text="$t('hotelAmenities.{{ $a['key'] }}')"></h3>
                        <p class="mt-1 text-sm text-muted" x-text="$t('hotelAmenities.{{ $a['key'] }}Desc')"></p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layout.public>
