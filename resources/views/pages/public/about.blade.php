<x-layout.public :pageTitle="$pageTitle ?? null">
    {{-- Hero --}}
    <section class="relative overflow-hidden" x-data>
        <div class="absolute inset-0">
            <img src="{{ \App\Support\HtData::photoUrl('deluxe-vista-mar', 2, 1600, 700) }}" alt="" class="h-full w-full object-cover" />
            <div class="absolute inset-0 bg-gray-950/70"></div>
        </div>
        <div class="relative mx-auto max-w-4xl px-4 py-24 text-center sm:px-6 lg:px-8">
            <h1 class="text-title-md font-bold text-white" x-text="$t('about.title')"></h1>
            <p class="mt-3 text-lg text-gray-200" x-text="$t('about.subtitle')"></p>
        </div>
    </section>

    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8" x-data>
        {{-- Mission --}}
        <div class="grid items-center gap-8 lg:grid-cols-2">
            <div>
                <h2 class="text-title-sm font-bold text-heading" x-text="$t('about.missionTitle')"></h2>
                <p class="mt-3 leading-relaxed text-body" x-text="$t('about.missionText')"></p>
            </div>
            <div class="overflow-hidden rounded-2xl border border-themed">
                <img src="{{ \App\Support\HtData::photoUrl('master-suite', 3, 800, 500) }}" alt="" class="h-full w-full object-cover" />
            </div>
        </div>

        {{-- Values --}}
        <div class="mt-16">
            <h2 class="mb-8 text-center text-title-sm font-bold text-heading" x-text="$t('about.valuesTitle')"></h2>
            <div class="grid gap-6 md:grid-cols-3">
                @foreach ([['heart', 'value1'], ['star', 'value2'], ['shield-check', 'value3']] as [$icon, $v])
                    <div class="surface-card rounded-2xl border p-6 text-center" x-data>
                        <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-500 dark:bg-brand-500/15">
                            <x-icon name="{{ $icon }}" :size="24" />
                        </span>
                        <h3 class="mt-4 text-base font-semibold text-heading" x-text="$t('about.{{ $v }}Title')"></h3>
                        <p class="mt-1 text-sm text-muted" x-text="$t('about.{{ $v }}Text')"></p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Stats --}}
        <div class="mt-16 grid grid-cols-2 gap-6 rounded-2xl border border-themed bg-brand-500 p-8 text-center lg:grid-cols-4"
            x-data="{ stats: [{ value: '15', key: 'years' }, { value: '120+', key: 'rooms' }, { value: '60k', key: 'guests' }, { value: '4.8', key: 'rating' }] }">
            <template x-for="s in stats" :key="s.key">
                <div>
                    <p class="text-title-sm font-bold text-white" x-text="s.value"></p>
                    <p class="mt-1 text-sm text-brand-100" x-text="$t('about.stats.' + s.key)"></p>
                </div>
            </template>
        </div>
    </div>
</x-layout.public>
