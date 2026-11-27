<x-layout.public :pageTitle="$pageTitle ?? null">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8"
        x-data="roomsPage()">
        <div class="mb-8">
            <h1 class="text-title-sm font-bold text-heading" x-text="$t('rooms.title')"></h1>
            <p class="mt-1 text-muted" x-text="$t('rooms.subtitle')"></p>
        </div>

        <div class="grid gap-8 lg:grid-cols-[260px_1fr]">
            {{-- Filters --}}
            <aside class="surface-card h-fit rounded-2xl border p-5">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="flex items-center gap-2 text-sm font-semibold text-heading">
                        <x-icon name="filter" :size="16" class="text-brand-500" /> <span x-text="$t('rooms.filters')"></span>
                    </h2>
                    <button type="button" @click="reset()" class="text-xs font-medium text-brand-600 hover:text-brand-700" x-text="$t('common.clearFilters')"></button>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="mb-1.5 block text-xs font-medium text-muted" x-text="$t('rooms.capacity')"></label>
                        <select x-model.number="capacity" class="focus-ring w-full rounded-lg border border-themed bg-transparent px-3 py-2 text-sm text-body">
                            <option :value="0" class="bg-white dark:bg-gray-dark" x-text="$t('common.all')"></option>
                            <template x-for="c in [1,2,3,4]" :key="c">
                                <option :value="c" class="bg-white dark:bg-gray-dark" x-text="$t('booking.guestCount', { count: c })"></option>
                            </template>
                        </select>
                    </div>

                    <div>
                        <label class="mb-1.5 flex items-center justify-between text-xs font-medium text-muted">
                            <span x-text="$t('rooms.maxRate')"></span>
                            <span class="text-brand-600" x-text="$currency(maxRate)"></span>
                        </label>
                        <input type="range" min="300" max="1000" step="20" x-model.number="maxRate" class="w-full" />
                    </div>

                    <div>
                        <label class="mb-2 block text-xs font-medium text-muted" x-text="$t('rooms.amenities')"></label>
                        <div class="space-y-2">
                            <template x-for="a in ['wifi','ac','minibar','balcony','seaView','workspace']" :key="a">
                                <label class="flex items-center gap-2 text-sm text-body">
                                    <input type="checkbox" :value="a" x-model="amenities" class="h-4 w-4 rounded border-themed accent-brand-500" />
                                    <span x-text="$t('amenities.' + a)"></span>
                                </label>
                            </template>
                        </div>
                    </div>
                </div>
            </aside>

            {{-- Results --}}
            <div>
                <p class="mb-4 text-sm text-muted" x-text="$t('rooms.resultsCount', { count: results.length })"></p>
                <template x-if="results.length > 0">
                    <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                        <template x-for="rt in results" :key="rt.id">
                            <x-hotel.room-type-card rt="rt" />
                        </template>
                    </div>
                </template>
                <template x-if="results.length === 0">
                    <div class="surface-card flex flex-col items-center rounded-2xl border p-12 text-center">
                        <span class="flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 text-gray-400 dark:bg-gray-800">
                            <x-icon name="search" :size="26" />
                        </span>
                        <h3 class="mt-4 text-base font-semibold text-heading" x-text="$t('rooms.emptyTitle')"></h3>
                        <p class="mt-1 text-sm text-muted" x-text="$t('rooms.emptyDesc')"></p>
                    </div>
                </template>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function roomsPage() {
                return {
                    capacity: 0,
                    maxRate: 1000,
                    amenities: [],
                    get results() {
                        return htHelpers.filterRoomTypes($store.pms.roomTypes, {
                            capacity: this.capacity || undefined,
                            maxRate: this.maxRate,
                            amenities: this.amenities,
                        });
                    },
                    reset() { this.capacity = 0; this.maxRate = 1000; this.amenities = []; },
                };
            }
        </script>
    @endpush
</x-layout.public>
