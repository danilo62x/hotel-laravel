<x-layout.app :pageTitle="$pageTitle ?? null">
    <x-app.page-header title="guests.title" subtitle="guests.subtitle" />

    <div x-data="guestsPage()">
        {{-- Filters --}}
        <div class="surface-card mb-5 grid gap-3 rounded-2xl border p-4 sm:grid-cols-[1fr_200px]">
            <div class="relative">
                <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><x-icon name="search" :size="16" /></span>
                <input type="text" x-model="query" :placeholder="$t('guests.searchPlaceholder')"
                    class="focus-ring h-10 w-full rounded-lg border border-themed bg-transparent pl-9 pr-3 text-sm text-body" />
            </div>
            <select x-model="tier" class="focus-ring h-10 rounded-lg border border-themed bg-transparent px-3 text-sm text-body">
                <option value="" class="bg-white dark:bg-gray-dark" x-text="$t('guests.allTiers')"></option>
                <template x-for="t in ['ouro','prata','bronze']" :key="t">
                    <option :value="t" class="bg-white dark:bg-gray-dark" x-text="$t('tiers.' + t)"></option>
                </template>
            </select>
        </div>

        <p class="mb-4 text-sm text-muted" x-text="$t('guests.resultsCount', { count: filtered.length })"></p>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <template x-for="g in paged.items" :key="g.id">
                <button type="button" @click="detail = g"
                    class="surface-card flex items-start gap-3 rounded-2xl border p-4 text-left transition hover:shadow-theme-md">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-brand-500 text-sm font-bold text-white" x-text="htHelpers.initials(g.name)"></span>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center justify-between gap-2">
                            <p class="truncate font-semibold text-heading" x-text="g.name"></p>
                            <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] font-medium"
                                :class="{
                                    'bg-warning-50 text-warning-700 dark:bg-warning-500/15 dark:text-warning-400': g.tier === 'ouro',
                                    'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300': g.tier === 'prata',
                                    'bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400': g.tier === 'bronze',
                                }" x-text="$t('tiers.' + g.tier)"></span>
                        </div>
                        <p class="truncate text-xs text-muted" x-text="g.email"></p>
                        <p class="mt-1 text-xs text-muted" x-text="$t('guests.staysCount', { count: g.stays })"></p>
                    </div>
                </button>
            </template>
            <template x-if="filtered.length === 0">
                <div class="surface-card col-span-full flex flex-col items-center rounded-2xl border p-12 text-center">
                    <span class="flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 text-gray-400 dark:bg-gray-800"><x-icon name="users" :size="26" /></span>
                    <p class="mt-4 text-sm text-muted" x-text="$t('common.noResults')"></p>
                </div>
            </template>
        </div>

        <div class="mt-5 flex items-center justify-between text-sm" x-show="paged.pageCount > 1">
            <span class="text-muted" x-text="page + ' / ' + paged.pageCount"></span>
            <div class="flex gap-2">
                <button type="button" @click="page = Math.max(1, page - 1)" :disabled="page <= 1" class="rounded-lg border border-themed px-3 py-1.5 text-body disabled:opacity-40" x-text="$t('common.previous')"></button>
                <button type="button" @click="page = Math.min(paged.pageCount, page + 1)" :disabled="page >= paged.pageCount" class="rounded-lg border border-themed px-3 py-1.5 text-body disabled:opacity-40" x-text="$t('common.next')"></button>
            </div>
        </div>

        {{-- Guest profile drawer --}}
        <div x-show="detail" x-cloak class="fixed inset-0 z-[80] flex justify-end">
            <div class="absolute inset-0 bg-gray-900/50" @click="detail = null"></div>
            <div class="surface-card relative h-full w-full max-w-md overflow-y-auto border-l p-6 shadow-theme-xl" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0">
                <template x-if="detail">
                    <div>
                        <div class="mb-5 flex items-start justify-between">
                            <h3 class="text-lg font-semibold text-heading" x-text="$t('guests.profile')"></h3>
                            <button type="button" @click="detail = null" class="text-gray-400 hover:text-gray-600"><x-icon name="x" :size="20" /></button>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="flex h-14 w-14 items-center justify-center rounded-full bg-brand-500 text-base font-bold text-white" x-text="htHelpers.initials(detail.name)"></span>
                            <div>
                                <p class="font-semibold text-heading" x-text="detail.name"></p>
                                <p class="text-sm text-muted" x-text="$t('tiers.' + detail.tier) + ' · ' + $t('guests.staysCount', { count: detail.stays })"></p>
                            </div>
                        </div>
                        <div class="mt-5 space-y-3 text-sm">
                            <div class="flex items-center gap-3"><x-icon name="mail" :size="16" class="text-muted" /> <span class="text-body" x-text="detail.email"></span></div>
                            <div class="flex items-center gap-3"><x-icon name="phone" :size="16" class="text-muted" /> <span class="text-body" x-text="detail.phone"></span></div>
                            <div class="flex items-center gap-3"><x-icon name="file-text" :size="16" class="text-muted" /> <span class="text-body" x-text="detail.document + ' · ' + detail.country"></span></div>
                        </div>
                        <template x-if="detail.notes">
                            <div class="mt-4 rounded-xl bg-gray-50 p-3 text-sm text-body dark:bg-gray-900" x-text="detail.notes"></div>
                        </template>

                        <h4 class="mb-2 mt-6 text-sm font-semibold text-heading" x-text="$t('guests.history')"></h4>
                        <template x-if="history.length === 0">
                            <p class="text-sm text-muted" x-text="$t('guests.noHistory')"></p>
                        </template>
                        <ul class="space-y-2" x-show="history.length > 0">
                            <template x-for="r in history" :key="r.id">
                                <li class="flex items-center justify-between rounded-lg border border-themed px-3 py-2">
                                    <div>
                                        <p class="text-sm font-medium text-heading" x-text="$store.pms.roomTypeById(r.roomTypeId)?.name"></p>
                                        <p class="text-xs text-muted" x-text="r.code + ' · ' + $dateShort(r.checkIn)"></p>
                                    </div>
                                    <x-hotel.reservation-pill status="r.status" />
                                </li>
                            </template>
                        </ul>
                    </div>
                </template>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function guestsPage() {
                return {
                    query: '',
                    tier: '',
                    page: 1,
                    detail: null,
                    get filtered() {
                        const q = this.query.trim().toLowerCase();
                        return $store.pms.guests.filter(g => {
                            if (this.tier && g.tier !== this.tier) return false;
                            if (!q) return true;
                            return g.name.toLowerCase().includes(q) || g.email.toLowerCase().includes(q) || g.document.toLowerCase().includes(q);
                        });
                    },
                    get paged() { return htHelpers.paginate(this.filtered, this.page, 9); },
                    get history() {
                        if (!this.detail) return [];
                        return $store.pms.reservations.filter(r => r.guestId === this.detail.id);
                    },
                };
            }
        </script>
    @endpush
</x-layout.app>
