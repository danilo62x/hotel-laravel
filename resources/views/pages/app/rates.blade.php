<x-layout.app :pageTitle="$pageTitle ?? null">
    <x-app.page-header title="rates.title" subtitle="rates.subtitle" />

    <div x-data="ratesPage()">
        <div class="surface-card mb-5 flex flex-wrap items-center gap-3 rounded-2xl border p-4">
            <p class="text-xs text-muted" x-text="$t('rates.legendHint')"></p>
        </div>

        <div class="surface-card overflow-hidden rounded-2xl border">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[820px] border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-themed">
                            <th class="sticky left-0 z-10 bg-card-bg px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-muted surface-card" x-text="$t('rates.roomType')"></th>
                            <template x-for="d in dates" :key="d">
                                <th class="px-2 py-3 text-center text-xs font-medium text-muted">
                                    <div x-text="$dateShort(d)"></div>
                                </th>
                            </template>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-themed">
                        <template x-for="rt in $store.pms.roomTypes" :key="rt.id">
                            <tr>
                                <td class="sticky left-0 z-10 bg-card-bg px-4 py-3 font-medium text-heading surface-card" x-text="rt.name"></td>
                                <template x-for="d in dates" :key="d">
                                    <td class="px-1.5 py-2 text-center">
                                        <button type="button" @click="openEdit(rt, d)"
                                            class="flex w-full flex-col items-center rounded-lg border px-1.5 py-1.5 transition hover:border-brand-300"
                                            :class="cell(rt.id, d).closed
                                                ? 'border-error-200 bg-error-50 dark:border-error-500/30 dark:bg-error-500/10'
                                                : (cell(rt.id, d).available === 0 ? 'border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-800' : 'border-themed')">
                                            <span class="text-xs font-semibold"
                                                :class="cell(rt.id, d).closed ? 'text-error-600 dark:text-error-400' : 'text-heading'"
                                                x-text="cell(rt.id, d).closed ? $t('rates.closed') : $currency(cell(rt.id, d).rate)"></span>
                                            <span class="text-[10px] text-muted"
                                                x-text="cell(rt.id, d).closed ? '—' : (cell(rt.id, d).available === 0 ? $t('rates.soldOut') : cell(rt.id, d).available)"></span>
                                        </button>
                                    </td>
                                </template>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Edit modal --}}
        <div x-show="editing" x-cloak class="fixed inset-0 z-[80] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-gray-900/50" @click="editing = null"></div>
            <div class="surface-card relative w-full max-w-sm rounded-2xl border p-6 shadow-theme-xl" x-transition>
                <template x-if="editing">
                    <div class="space-y-4">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-heading" x-text="$t('rates.editTitle')"></h3>
                                <p class="text-sm text-muted" x-text="editing.rtName + ' · ' + $date(editing.date)"></p>
                            </div>
                            <button type="button" @click="editing = null" class="text-gray-400 hover:text-gray-600"><x-icon name="x" :size="20" /></button>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-heading" x-text="$t('rates.nightlyRate')"></label>
                            <input type="number" min="0" step="10" x-model.number="rateValue" class="focus-ring h-10 w-full rounded-lg border border-themed bg-transparent px-3 text-sm text-body" />
                        </div>
                        <div class="flex items-center justify-between rounded-lg bg-gray-50 px-3 py-2.5 dark:bg-gray-900">
                            <div>
                                <p class="text-sm font-medium text-heading" x-text="$t('rates.openForSale')"></p>
                                <p class="text-xs text-muted" x-text="$t('rates.openHint')"></p>
                            </div>
                            <button type="button" @click="toggleClosed()"
                                class="relative inline-flex h-6 w-11 items-center rounded-full transition"
                                :class="!isClosed ? 'bg-brand-500' : 'bg-gray-300 dark:bg-gray-600'">
                                <span class="inline-block h-4 w-4 transform rounded-full bg-white transition" :class="!isClosed ? 'translate-x-6' : 'translate-x-1'"></span>
                            </button>
                        </div>
                        <p class="text-xs text-muted" x-text="$t('rates.available', { count: editing.available })"></p>
                        <div class="flex justify-end gap-2 pt-1">
                            <button type="button" @click="editing = null" class="rounded-lg border border-themed px-4 py-2 text-sm font-medium text-body" x-text="$t('common.cancel')"></button>
                            <button type="button" @click="save()" class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600" x-text="$t('common.save')"></button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function ratesPage() {
                return {
                    editing: null,
                    rateValue: 0,
                    isClosed: false,
                    get dates() { return htHelpers.rateDates($store.pms.rates); },
                    cell(roomTypeId, date) {
                        return htHelpers.rateOn($store.pms.rates, roomTypeId, date) || { rate: 0, available: 0, closed: false };
                    },
                    openEdit(rt, date) {
                        const e = this.cell(rt.id, date);
                        this.editing = { rtId: rt.id, rtName: rt.name, date, available: e.available };
                        this.rateValue = e.rate;
                        this.isClosed = e.closed;
                    },
                    toggleClosed() {
                        $store.pms.toggleClosed(this.editing.rtId, this.editing.date);
                        this.isClosed = !this.isClosed;
                        $store.ui.notifySuccess(this.$t('rates.availabilityUpdated'));
                    },
                    save() {
                        $store.pms.setRate(this.editing.rtId, this.editing.date, this.rateValue);
                        $store.ui.notifySuccess(this.$t('rates.saved'));
                        this.editing = null;
                    },
                };
            }
        </script>
    @endpush
</x-layout.app>
