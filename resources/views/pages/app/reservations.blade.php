<x-layout.app :pageTitle="$pageTitle ?? null">
    <x-app.page-header title="reservations.title" subtitle="reservations.subtitle">
        <x-slot:action>
            <button type="button" @click="$dispatch('open-create')"
                class="inline-flex h-10 items-center gap-2 rounded-lg bg-brand-500 px-4 text-sm font-medium text-white transition hover:bg-brand-600">
                <x-icon name="plus" :size="16" /> <span x-text="$t('reservations.new')"></span>
            </button>
        </x-slot:action>
    </x-app.page-header>

    <div x-data="reservationsPage()">
        {{-- Filters --}}
        <div class="surface-card mb-5 grid gap-3 rounded-2xl border p-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="relative">
                <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><x-icon name="search" :size="16" /></span>
                <input type="text" x-model="$store.pms.filters.query" :placeholder="$t('reservations.searchPlaceholder')"
                    class="focus-ring h-10 w-full rounded-lg border border-themed bg-transparent pl-9 pr-3 text-sm text-body" />
            </div>
            <select x-model="$store.pms.filters.status" class="focus-ring h-10 rounded-lg border border-themed bg-transparent px-3 text-sm text-body">
                <option value="" class="bg-white dark:bg-gray-dark" x-text="$t('reservations.allStatuses')"></option>
                <template x-for="s in ['confirmada','checkin','checkout','cancelada','noshow']" :key="s">
                    <option :value="s" class="bg-white dark:bg-gray-dark" x-text="$t('reservationStatuses.' + s)"></option>
                </template>
            </select>
            <select x-model="$store.pms.filters.channel" class="focus-ring h-10 rounded-lg border border-themed bg-transparent px-3 text-sm text-body">
                <option value="" class="bg-white dark:bg-gray-dark" x-text="$t('reservations.allChannels')"></option>
                <template x-for="c in htHelpers.CHANNELS" :key="c">
                    <option :value="c" class="bg-white dark:bg-gray-dark" x-text="$t('channels.' + c)"></option>
                </template>
            </select>
            <div class="grid grid-cols-2 gap-2">
                <input type="date" x-model="$store.pms.filters.from" class="focus-ring h-10 rounded-lg border border-themed bg-transparent px-2 text-sm text-body" />
                <input type="date" x-model="$store.pms.filters.to" class="focus-ring h-10 rounded-lg border border-themed bg-transparent px-2 text-sm text-body" />
            </div>
        </div>

        {{-- Table --}}
        <div class="surface-card overflow-hidden rounded-2xl border">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[760px] text-left text-sm">
                    <thead class="border-b border-themed text-xs uppercase tracking-wide text-muted">
                        <tr>
                            <th class="px-4 py-3" x-text="$t('reservations.columns.code')"></th>
                            <th class="px-4 py-3" x-text="$t('reservations.columns.guest')"></th>
                            <th class="px-4 py-3" x-text="$t('reservations.columns.roomType')"></th>
                            <th class="px-4 py-3" x-text="$t('reservations.columns.checkIn')"></th>
                            <th class="px-4 py-3" x-text="$t('reservations.columns.channel')"></th>
                            <th class="px-4 py-3 text-right" x-text="$t('reservations.columns.total')"></th>
                            <th class="px-4 py-3" x-text="$t('reservations.columns.status')"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-themed">
                        <template x-for="r in paged.items" :key="r.id">
                            <tr class="cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800/50" @click="openDetail(r)">
                                <td class="px-4 py-3 font-medium text-heading" x-text="r.code"></td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2.5">
                                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-brand-500 text-[11px] font-bold text-white" x-text="htHelpers.initials($store.pms.guestById(r.guestId)?.name)"></span>
                                        <span class="text-body" x-text="$store.pms.guestById(r.guestId)?.name"></span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-body" x-text="$store.pms.roomTypeById(r.roomTypeId)?.name"></td>
                                <td class="px-4 py-3 text-muted" x-text="$dateShort(r.checkIn)"></td>
                                <td class="px-4 py-3 text-muted" x-text="$t('channels.' + r.channel)"></td>
                                <td class="px-4 py-3 text-right font-medium text-heading" x-text="$currency(r.total)"></td>
                                <td class="px-4 py-3"><x-hotel.reservation-pill status="r.status" /></td>
                            </tr>
                        </template>
                        <template x-if="filtered.length === 0">
                            <tr><td colspan="7" class="px-4 py-12 text-center text-sm text-muted" x-text="$t('common.noResults')"></td></tr>
                        </template>
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="flex items-center justify-between border-t border-themed px-4 py-3 text-sm" x-show="paged.pageCount > 1">
                <span class="text-muted" x-text="page + ' / ' + paged.pageCount"></span>
                <div class="flex gap-2">
                    <button type="button" @click="page = Math.max(1, page - 1)" :disabled="page <= 1"
                        class="rounded-lg border border-themed px-3 py-1.5 text-body disabled:opacity-40" x-text="$t('common.previous')"></button>
                    <button type="button" @click="page = Math.min(paged.pageCount, page + 1)" :disabled="page >= paged.pageCount"
                        class="rounded-lg border border-themed px-3 py-1.5 text-body disabled:opacity-40" x-text="$t('common.next')"></button>
                </div>
            </div>
        </div>

        {{-- Create modal --}}
        <div x-show="createOpen" x-cloak class="fixed inset-0 z-[80] flex items-center justify-center p-4" @open-create.window="openCreate()">
            <div class="absolute inset-0 bg-gray-900/50" @click="createOpen = false"></div>
            <div class="surface-card relative w-full max-w-lg rounded-2xl border p-6 shadow-theme-xl" x-transition>
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-heading" x-text="$t('reservations.newTitle')"></h3>
                    <button type="button" @click="createOpen = false" class="text-gray-400 hover:text-gray-600"><x-icon name="x" :size="20" /></button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-heading" x-text="$t('reservations.guest')"></label>
                        <select x-model.number="draft.guestId" class="focus-ring h-10 w-full rounded-lg border border-themed bg-transparent px-3 text-sm text-body">
                            <template x-for="g in $store.pms.guests" :key="g.id">
                                <option :value="g.id" class="bg-white dark:bg-gray-dark" x-text="g.name"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-heading" x-text="$t('reservations.roomType')"></label>
                        <select x-model.number="draft.roomTypeId" class="focus-ring h-10 w-full rounded-lg border border-themed bg-transparent px-3 text-sm text-body">
                            <template x-for="rt in $store.pms.roomTypes" :key="rt.id">
                                <option :value="rt.id" class="bg-white dark:bg-gray-dark" x-text="rt.name"></option>
                            </template>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-heading" x-text="$t('booking.checkIn')"></label>
                            <input type="date" x-model="draft.checkIn" class="focus-ring h-10 w-full rounded-lg border border-themed bg-transparent px-3 text-sm text-body" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-heading" x-text="$t('booking.checkOut')"></label>
                            <input type="date" x-model="draft.checkOut" class="focus-ring h-10 w-full rounded-lg border border-themed bg-transparent px-3 text-sm text-body" />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-heading" x-text="$t('booking.guests')"></label>
                            <input type="number" min="1" max="6" x-model.number="draft.guests" class="focus-ring h-10 w-full rounded-lg border border-themed bg-transparent px-3 text-sm text-body" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-heading" x-text="$t('reservations.channel')"></label>
                            <select x-model="draft.channel" class="focus-ring h-10 w-full rounded-lg border border-themed bg-transparent px-3 text-sm text-body">
                                <template x-for="c in htHelpers.CHANNELS" :key="c">
                                    <option :value="c" class="bg-white dark:bg-gray-dark" x-text="$t('channels.' + c)"></option>
                                </template>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="createOpen = false" class="h-10 rounded-lg border border-themed px-4 text-sm font-medium text-body hover:bg-gray-50 dark:hover:bg-gray-800" x-text="$t('common.cancel')"></button>
                        <button type="button" @click="create()" class="h-10 rounded-lg bg-brand-500 px-4 text-sm font-medium text-white hover:bg-brand-600" x-text="$t('reservations.create')"></button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail drawer --}}
        <div x-show="detail" x-cloak class="fixed inset-0 z-[80] flex justify-end">
            <div class="absolute inset-0 bg-gray-900/50" @click="detail = null"></div>
            <div class="surface-card relative h-full w-full max-w-md overflow-y-auto border-l p-6 shadow-theme-xl" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0">
                <template x-if="detail">
                    <div>
                        <div class="mb-5 flex items-start justify-between">
                            <div>
                                <p class="text-xs text-muted" x-text="detail.code"></p>
                                <h3 class="text-lg font-semibold text-heading" x-text="$store.pms.guestById(detail.guestId)?.name"></h3>
                            </div>
                            <button type="button" @click="detail = null" class="text-gray-400 hover:text-gray-600"><x-icon name="x" :size="20" /></button>
                        </div>

                        <div class="space-y-3 text-sm">
                            <div class="flex items-center justify-between"><span class="text-muted" x-text="$t('reservations.roomType')"></span><span class="font-medium text-heading" x-text="$store.pms.roomTypeById(detail.roomTypeId)?.name"></span></div>
                            <div class="flex items-center justify-between"><span class="text-muted" x-text="$t('reservations.room')"></span><span class="font-medium text-heading" x-text="detail.roomId ? $store.pms.roomById(detail.roomId)?.number : $t('reservations.unassigned')"></span></div>
                            <div class="flex items-center justify-between"><span class="text-muted" x-text="$t('booking.checkIn')"></span><span class="font-medium text-heading" x-text="$date(detail.checkIn)"></span></div>
                            <div class="flex items-center justify-between"><span class="text-muted" x-text="$t('booking.checkOut')"></span><span class="font-medium text-heading" x-text="$date(detail.checkOut)"></span></div>
                            <div class="flex items-center justify-between"><span class="text-muted" x-text="$t('reservations.guest')"></span><span class="font-medium text-heading" x-text="$t('booking.guestCount', { count: detail.guests })"></span></div>
                            <div class="flex items-center justify-between"><span class="text-muted" x-text="$t('reservations.channel')"></span><span class="font-medium text-heading" x-text="$t('channels.' + detail.channel)"></span></div>
                        </div>

                        <div class="mt-5 rounded-xl border border-themed p-4">
                            <p class="mb-2 text-sm font-semibold text-heading" x-text="$t('reservations.billing')"></p>
                            <div class="space-y-2 text-sm">
                                <div class="flex items-center justify-between"><span class="text-muted" x-text="$t('detail.total')"></span><span class="font-semibold text-heading" x-text="$currency(detail.total)"></span></div>
                                <div class="flex items-center justify-between"><span class="text-muted" x-text="$t('reservations.paid')"></span><span class="text-success-600" x-text="$currency(detail.paid)"></span></div>
                                <div class="flex items-center justify-between border-t border-themed pt-2"><span class="text-muted" x-text="$t('reservations.balance')"></span><span class="font-semibold text-heading" x-text="$currency(detail.total - detail.paid)"></span></div>
                            </div>
                        </div>

                        <template x-if="detail.notes">
                            <div class="mt-4 rounded-xl bg-warning-50 p-3 text-sm text-warning-700 dark:bg-warning-500/10 dark:text-warning-400">
                                <p class="font-medium" x-text="$t('reservations.notes')"></p>
                                <p x-text="detail.notes"></p>
                            </div>
                        </template>

                        <div class="mt-5">
                            <p class="mb-2 text-sm font-medium text-heading" x-text="$t('reservations.changeStatus')"></p>
                            <div class="flex flex-wrap gap-2">
                                <template x-for="s in ['confirmada','checkin','checkout','cancelada','noshow']" :key="s">
                                    <button type="button" @click="setStatus(s)" :disabled="detail.status === s"
                                        class="rounded-lg border border-themed px-3 py-1.5 text-xs font-medium text-body transition hover:border-brand-300 disabled:opacity-40"
                                        :class="detail.status === s ? 'border-brand-500 bg-brand-50 dark:bg-brand-500/10' : ''"
                                        x-text="$t('reservationStatuses.' + s)"></button>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function reservationsPage() {
                return {
                    page: 1,
                    createOpen: false,
                    detail: null,
                    draft: {},
                    get filtered() {
                        return htHelpers.filterReservations($store.pms.reservations, $store.pms.guests, $store.pms.filters);
                    },
                    get paged() { return htHelpers.paginate(this.filtered, this.page, 8); },
                    openDetail(r) { this.detail = r; },
                    openCreate() {
                        this.draft = {
                            guestId: $store.pms.guests[0]?.id,
                            roomTypeId: $store.pms.roomTypes[0]?.id,
                            checkIn: htHelpers.TODAY,
                            checkOut: htHelpers.addDays(htHelpers.TODAY, 2),
                            guests: 2,
                            channel: 'direto',
                        };
                        this.createOpen = true;
                    },
                    create() {
                        $store.pms.createReservation(this.draft);
                        this.createOpen = false;
                        this.page = 1;
                        $store.ui.notifySuccess(this.$t('reservations.created'));
                    },
                    setStatus(s) {
                        $store.pms.setReservationStatus(this.detail.id, s);
                        this.detail = $store.pms.reservations.find(r => r.id === this.detail.id);
                        $store.ui.notifySuccess(this.$t('reservations.statusUpdated'));
                    },
                };
            }
        </script>
    @endpush
</x-layout.app>
