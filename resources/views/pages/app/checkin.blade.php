<x-layout.app :pageTitle="$pageTitle ?? null">
    <x-app.page-header title="checkin.title" subtitle="checkin.subtitle" />

    <div x-data="checkinPage()">
        {{-- Tabs --}}
        <div class="mb-5 flex gap-1 rounded-xl border border-themed p-1">
            <button type="button" @click="tab = 0"
                class="flex flex-1 items-center justify-center gap-2 rounded-lg px-4 py-2 text-sm font-medium transition"
                :class="tab === 0 ? 'bg-brand-500 text-white' : 'text-muted hover:text-body'">
                <x-icon name="log-in" :size="16" /> <span x-text="$t('checkin.arrivals') + ' (' + arrivals.length + ')'"></span>
            </button>
            <button type="button" @click="tab = 1"
                class="flex flex-1 items-center justify-center gap-2 rounded-lg px-4 py-2 text-sm font-medium transition"
                :class="tab === 1 ? 'bg-brand-500 text-white' : 'text-muted hover:text-body'">
                <x-icon name="logout" :size="16" /> <span x-text="$t('checkin.departures') + ' (' + departures.length + ')'"></span>
            </button>
        </div>

        {{-- Arrivals --}}
        <div x-show="tab === 0" class="space-y-3">
            <template x-if="arrivals.length === 0">
                <div class="surface-card flex flex-col items-center rounded-2xl border p-12 text-center">
                    <span class="flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 text-gray-400 dark:bg-gray-800"><x-icon name="log-in" :size="26" /></span>
                    <p class="mt-4 text-sm text-muted" x-text="$t('checkin.noArrivals')"></p>
                </div>
            </template>
            <template x-for="r in arrivals" :key="r.id">
                <div class="surface-card flex flex-col gap-4 rounded-2xl border p-4 sm:flex-row sm:items-center">
                    <div class="flex flex-1 items-center gap-3">
                        <span class="flex h-11 w-11 items-center justify-center rounded-full bg-brand-500 text-sm font-bold text-white" x-text="htHelpers.initials($store.pms.guestById(r.guestId)?.name)"></span>
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <p class="truncate font-semibold text-heading" x-text="$store.pms.guestById(r.guestId)?.name"></p>
                                <template x-if="$store.pms.guestById(r.guestId)?.tier === 'ouro'">
                                    <span class="inline-flex items-center gap-1 rounded-full bg-warning-50 px-2 py-0.5 text-[10px] font-medium text-warning-700 dark:bg-warning-500/15 dark:text-warning-400"><x-icon name="star" :size="10" /> VIP</span>
                                </template>
                            </div>
                            <p class="truncate text-sm text-muted" x-text="r.code + ' · ' + $store.pms.roomTypeById(r.roomTypeId)?.name"></p>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-4 text-sm">
                        <div>
                            <p class="text-xs text-muted" x-text="$t('booking.checkOut')"></p>
                            <p class="font-medium text-heading" x-text="$date(r.checkOut)"></p>
                        </div>
                        <div>
                            <p class="text-xs text-muted" x-text="$t('reservations.room')"></p>
                            <p class="font-medium text-heading" x-text="r.roomId ? $store.pms.roomById(r.roomId)?.number : $t('reservations.unassigned')"></p>
                        </div>
                        <button type="button" @click="openAssign(r)" :disabled="r.status === 'checkin'"
                            class="inline-flex h-10 items-center gap-2 rounded-lg bg-brand-500 px-4 text-sm font-medium text-white transition hover:bg-brand-600 disabled:opacity-50">
                            <x-icon name="log-in" :size="16" /> <span x-text="r.status === 'checkin' ? $t('checkin.done') : $t('checkin.doCheckIn')"></span>
                        </button>
                    </div>
                </div>
            </template>
        </div>

        {{-- Departures --}}
        <div x-show="tab === 1" class="space-y-3" x-cloak>
            <template x-if="departures.length === 0">
                <div class="surface-card flex flex-col items-center rounded-2xl border p-12 text-center">
                    <span class="flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 text-gray-400 dark:bg-gray-800"><x-icon name="logout" :size="26" /></span>
                    <p class="mt-4 text-sm text-muted" x-text="$t('checkin.noDepartures')"></p>
                </div>
            </template>
            <template x-for="r in departures" :key="r.id">
                <div class="surface-card flex flex-col gap-4 rounded-2xl border p-4 sm:flex-row sm:items-center">
                    <div class="flex flex-1 items-center gap-3">
                        <span class="flex h-11 w-11 items-center justify-center rounded-full bg-brand-500 text-sm font-bold text-white" x-text="htHelpers.initials($store.pms.guestById(r.guestId)?.name)"></span>
                        <div class="min-w-0">
                            <p class="truncate font-semibold text-heading" x-text="$store.pms.guestById(r.guestId)?.name"></p>
                            <p class="truncate text-sm text-muted" x-text="r.code + ' · ' + $store.pms.roomTypeById(r.roomTypeId)?.name"></p>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-4 text-sm">
                        <div>
                            <p class="text-xs text-muted" x-text="$t('booking.checkIn')"></p>
                            <p class="font-medium text-heading" x-text="$date(r.checkIn)"></p>
                        </div>
                        <div>
                            <p class="text-xs text-muted" x-text="$t('reservations.room')"></p>
                            <p class="font-medium text-heading" x-text="r.roomId ? $store.pms.roomById(r.roomId)?.number : $t('reservations.unassigned')"></p>
                        </div>
                        <div>
                            <p class="text-xs text-muted" x-text="$t('reservations.balance')"></p>
                            <p class="font-medium" :class="(r.total - r.paid) > 0 ? 'text-error-600' : 'text-success-600'" x-text="$currency(r.total - r.paid)"></p>
                        </div>
                        <button type="button" @click="closing = r" :disabled="r.status === 'checkout'"
                            class="inline-flex h-10 items-center gap-2 rounded-lg border border-themed px-4 text-sm font-medium text-body transition hover:border-brand-300 disabled:opacity-50">
                            <x-icon name="logout" :size="16" /> <span x-text="r.status === 'checkout' ? $t('checkin.done') : $t('checkin.doCheckOut')"></span>
                        </button>
                    </div>
                </div>
            </template>
        </div>

        {{-- Assign room modal --}}
        <div x-show="assigning" x-cloak class="fixed inset-0 z-[80] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-gray-900/50" @click="assigning = null"></div>
            <div class="surface-card relative w-full max-w-sm rounded-2xl border p-6 shadow-theme-xl" x-transition>
                <template x-if="assigning">
                    <div>
                        <div class="mb-4 flex items-start justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-heading" x-text="$t('checkin.assignRoom')"></h3>
                                <p class="text-sm text-muted" x-text="assigning.code + ' · ' + $store.pms.roomTypeById(assigning.roomTypeId)?.name"></p>
                            </div>
                            <button type="button" @click="assigning = null" class="text-gray-400 hover:text-gray-600"><x-icon name="x" :size="20" /></button>
                        </div>
                        <template x-if="freeRooms.length === 0">
                            <p class="text-sm text-muted" x-text="$t('checkin.noFreeRooms')"></p>
                        </template>
                        <template x-if="freeRooms.length > 0">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-heading" x-text="$t('checkin.selectRoom')"></label>
                                <select x-model.number="roomChoice" class="focus-ring w-full rounded-lg border border-themed bg-transparent px-3 py-2.5 text-sm text-body">
                                    <template x-for="rm in freeRooms" :key="rm.id">
                                        <option :value="rm.id" class="bg-white dark:bg-gray-dark" x-text="$t('roomMap.floor', { floor: rm.floor }) + ' · ' + rm.number"></option>
                                    </template>
                                </select>
                            </div>
                        </template>
                        <div class="mt-5 flex justify-end gap-2">
                            <button type="button" @click="assigning = null" class="rounded-lg border border-themed px-4 py-2 text-sm font-medium text-body" x-text="$t('common.cancel')"></button>
                            <button type="button" @click="confirmCheckIn()" :disabled="!roomChoice || freeRooms.length === 0" class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600 disabled:opacity-50" x-text="$t('checkin.confirm')"></button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- Close account modal --}}
        <div x-show="closing" x-cloak class="fixed inset-0 z-[80] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-gray-900/50" @click="closing = null"></div>
            <div class="surface-card relative w-full max-w-sm rounded-2xl border p-6 shadow-theme-xl" x-transition>
                <template x-if="closing">
                    <div>
                        <div class="mb-4 flex items-start justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-heading" x-text="$t('checkin.closeAccount')"></h3>
                                <p class="text-sm text-muted" x-text="closing.code + ' · ' + $store.pms.guestById(closing.guestId)?.name"></p>
                            </div>
                            <button type="button" @click="closing = null" class="text-gray-400 hover:text-gray-600"><x-icon name="x" :size="20" /></button>
                        </div>
                        <div class="space-y-1.5 text-sm">
                            <div class="flex justify-between"><span class="text-muted" x-text="$t('reservations.columns.total')"></span><span class="text-heading" x-text="$currency(closing.total)"></span></div>
                            <div class="flex justify-between"><span class="text-muted" x-text="$t('reservations.paid')"></span><span class="text-success-600" x-text="$currency(closing.paid)"></span></div>
                            <div class="flex justify-between border-t border-themed pt-1.5 font-semibold"><span class="text-heading" x-text="$t('reservations.balance')"></span><span class="text-heading" x-text="$currency(closing.total - closing.paid)"></span></div>
                            <p class="pt-2 text-xs text-muted" x-text="$t('checkin.closeHint')"></p>
                        </div>
                        <div class="mt-5 flex justify-end gap-2">
                            <button type="button" @click="closing = null" class="rounded-lg border border-themed px-4 py-2 text-sm font-medium text-body" x-text="$t('common.cancel')"></button>
                            <button type="button" @click="confirmCheckOut()" class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600" x-text="$t('checkin.confirmCheckOut')"></button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function checkinPage() {
                return {
                    tab: 0,
                    assigning: null,
                    closing: null,
                    roomChoice: 0,
                    get arrivals() { return htHelpers.arrivalsToday($store.pms.reservations, htHelpers.TODAY); },
                    get departures() { return htHelpers.departuresToday($store.pms.reservations, htHelpers.TODAY); },
                    get freeRooms() {
                        if (!this.assigning) return [];
                        return $store.pms.rooms.filter(rm => rm.roomTypeId === this.assigning.roomTypeId && (rm.status === 'livre' || rm.id === this.assigning.roomId));
                    },
                    openAssign(r) {
                        const free = $store.pms.rooms.find(rm => rm.roomTypeId === r.roomTypeId && rm.status === 'livre');
                        const anyFree = $store.pms.rooms.find(rm => rm.status === 'livre');
                        this.roomChoice = r.roomId ?? (free ? free.id : (anyFree ? anyFree.id : $store.pms.rooms[0].id));
                        this.assigning = r;
                    },
                    confirmCheckIn() {
                        if (!this.assigning) return;
                        const code = this.assigning.code;
                        $store.pms.checkIn(this.assigning.id, this.roomChoice);
                        $store.ui.notifySuccess(this.$t('checkin.checkedIn', { code }));
                        this.assigning = null;
                    },
                    confirmCheckOut() {
                        if (!this.closing) return;
                        const code = this.closing.code;
                        $store.pms.checkOut(this.closing.id);
                        $store.ui.notifySuccess(this.$t('checkin.checkedOut', { code }));
                        this.closing = null;
                    },
                };
            }
        </script>
    @endpush
</x-layout.app>
