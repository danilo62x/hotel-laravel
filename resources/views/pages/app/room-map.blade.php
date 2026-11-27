<x-layout.app :pageTitle="$pageTitle ?? null">
    <x-app.page-header title="roomMap.title" subtitle="roomMap.subtitle" />

    <div x-data="roomMapPage()">
        {{-- Legend + counts --}}
        <div class="surface-card mb-5 flex flex-wrap items-center justify-between gap-4 rounded-2xl border p-4">
            <x-hotel.status-legend />
            <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-muted">
                <span><span x-text="$t('roomStatuses.livre')"></span>: <b class="text-heading" x-text="counts.livre"></b></span>
                <span><span x-text="$t('roomStatuses.ocupado')"></span>: <b class="text-heading" x-text="counts.ocupado"></b></span>
                <span><span x-text="$t('roomStatuses.limpeza')"></span>: <b class="text-heading" x-text="counts.limpeza"></b></span>
                <span><span x-text="$t('roomStatuses.manutencao')"></span>: <b class="text-heading" x-text="counts.manutencao"></b></span>
            </div>
        </div>

        {{-- Floors --}}
        <div class="space-y-6">
            <template x-for="fg in floors" :key="fg.floor">
                <div class="surface-card rounded-2xl border p-5">
                    <h3 class="mb-4 flex items-center gap-2 text-sm font-semibold text-heading">
                        <x-icon name="layers" :size="16" class="text-brand-500" />
                        <span x-text="$t('roomMap.floor', { floor: fg.floor })"></span>
                    </h3>
                    <div class="grid grid-cols-3 gap-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8">
                        <template x-for="room in fg.rooms" :key="room.id">
                            <button type="button" @click="active = room"
                                :title="`${room.number} · ${$store.pms.roomTypeById(room.roomTypeId)?.name} · ${$t('roomStatuses.' + room.status)}`"
                                class="flex flex-col items-start gap-1 rounded-xl border p-3 text-left transition hover:shadow-theme-md focus-ring"
                                :class="htHelpers.roomStatusTone(room.status)">
                                <div class="flex w-full items-center justify-between">
                                    <span class="text-sm font-bold" x-text="room.number"></span>
                                    <span x-html="iconFor(room.status)"></span>
                                </div>
                                <span class="truncate text-[11px] opacity-80" x-text="$store.pms.roomTypeById(room.roomTypeId)?.name"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </template>
        </div>

        {{-- Room actions modal --}}
        <div x-show="active" x-cloak class="fixed inset-0 z-[80] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-gray-900/50" @click="active = null"></div>
            <div class="surface-card relative w-full max-w-sm rounded-2xl border p-6 shadow-theme-xl" x-transition>
                <template x-if="active">
                    <div class="space-y-4">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-heading" x-text="$t('roomMap.roomTitle', { number: active.number })"></h3>
                                <p class="text-sm text-muted" x-text="$store.pms.roomTypeById(active.roomTypeId)?.name"></p>
                            </div>
                            <button type="button" @click="active = null" class="text-gray-400 hover:text-gray-600"><x-icon name="x" :size="20" /></button>
                        </div>
                        <div class="flex items-center justify-between rounded-lg bg-gray-50 px-3 py-2.5 dark:bg-gray-900">
                            <span class="text-sm text-muted" x-text="$t('roomMap.currentStatus')"></span>
                            <x-hotel.room-pill status="active.status" />
                        </div>
                        <p class="text-sm font-medium text-heading" x-text="$t('roomMap.changeStatus')"></p>
                        <div class="grid grid-cols-1 gap-2">
                            <template x-for="s in htHelpers.ROOM_STATUSES" :key="s">
                                <button type="button" @click="apply(s)" :disabled="s === active.status"
                                    class="flex items-center gap-3 rounded-lg border px-4 py-2.5 text-sm font-medium transition disabled:opacity-40"
                                    :class="s === active.status ? 'border-brand-500 bg-brand-50 dark:bg-brand-500/10' : 'border-themed text-body hover:border-brand-300'">
                                    <span x-html="iconFor(s)"></span>
                                    <span x-text="$t('roomMap.setTo', { status: $t('roomStatuses.' + s) })"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const ROOM_ICON_SVG = {
                livre: '<path d="M2 8v12"/><path d="M2 13h20v7"/><path d="M22 13v-3a2 2 0 0 0-2-2H10v5"/>',
                ocupado: '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>',
                limpeza: '<path d="M12 3l1.9 5.1L19 10l-5.1 1.9L12 17l-1.9-5.1L5 10l5.1-1.9z"/>',
                manutencao: '<path d="M14.7 6.3a4 4 0 0 0-5.4 5.3L3 18l3 3 6.4-6.3a4 4 0 0 0 5.3-5.4l-2.6 2.6-2.3-2.3z"/>',
                reservado: '<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>',
            };
            function roomMapPage() {
                return {
                    active: null,
                    get floors() { return htHelpers.roomsByFloor($store.pms.rooms); },
                    get counts() { return htHelpers.countRoomsByStatus($store.pms.rooms); },
                    iconFor(status) {
                        const body = ROOM_ICON_SVG[status] || ROOM_ICON_SVG.reservado;
                        return `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">${body}</svg>`;
                    },
                    apply(status) {
                        if (!this.active) return;
                        const num = this.active.number;
                        $store.pms.setRoomStatus(this.active.id, status);
                        $store.ui.notifySuccess(this.$t('roomMap.statusUpdated', { number: num }));
                        this.active = null;
                    },
                };
            }
        </script>
    @endpush
</x-layout.app>
