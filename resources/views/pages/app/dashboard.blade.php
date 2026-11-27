<x-layout.app :pageTitle="$pageTitle ?? null">
    @push('head')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.49.1/dist/apexcharts.min.js"></script>
    @endpush

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-heading" x-text="$t('dashboard.title')"></h1>
        <p class="mt-1 text-sm text-muted" x-data x-text="$t('dashboard.welcome', { name: ($store.auth.user?.name || '').split(' ')[0] })"></p>
    </div>

    <div x-data="dashboardPage()">
        {{-- KPIs --}}
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-5">
            <x-hotel.kpi-card icon="bed" tone="brand" labelKey="dashboard.kpis.occupancy" value="$percent(m.occupancy)" />
            <x-hotel.kpi-card icon="tag" tone="success" labelKey="dashboard.kpis.adr" value="$currency(m.adr)" />
            <x-hotel.kpi-card icon="trending-up" tone="info" labelKey="dashboard.kpis.revpar" value="$currency(m.revpar)" />
            <x-hotel.kpi-card icon="key" tone="warning" labelKey="dashboard.kpis.checkinsToday" value="m.arrivals + ' / ' + m.departures" hint="dashboard.kpis.checkinsHint" />
            <x-hotel.kpi-card icon="dollar" tone="brand" labelKey="dashboard.kpis.revenue" value="$currency(m.revenueToday)" hint="dashboard.kpis.revenueHint" />
        </div>

        {{-- Charts --}}
        <div class="mt-5 grid grid-cols-1 gap-5 xl:grid-cols-3">
            <div class="surface-card rounded-2xl border p-5 xl:col-span-2">
                <h3 class="text-base font-semibold text-heading" x-text="$t('dashboard.occupancyTitle')"></h3>
                <div class="mt-4" x-ref="area"></div>
            </div>
            <div class="surface-card rounded-2xl border p-5">
                <h3 class="text-base font-semibold text-heading" x-text="$t('dashboard.channelTitle')"></h3>
                <div class="mt-4" x-ref="donut"></div>
            </div>
        </div>

        {{-- Arrivals / Departures / Hotel status --}}
        <div class="mt-5 grid grid-cols-1 gap-5 xl:grid-cols-3">
            {{-- Arrivals --}}
            <div class="surface-card rounded-2xl border p-5">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-semibold text-heading" x-text="$t('dashboard.arrivalsToday')"></h3>
                    <a href="{{ route('app.checkin') }}" class="text-sm font-medium text-brand-600 hover:text-brand-700" x-text="$t('common.viewAll')"></a>
                </div>
                <template x-if="arrivals.length === 0">
                    <p class="mt-6 text-center text-sm text-muted" x-text="$t('dashboard.noArrivals')"></p>
                </template>
                <ul class="mt-4 divide-y divide-themed" x-show="arrivals.length > 0">
                    <template x-for="r in arrivals.slice(0, 5)" :key="r.id">
                        <li class="flex items-center gap-3 py-3">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-success-50 text-success-600 dark:bg-success-500/15">
                                <x-icon name="log-in" :size="16" />
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-heading" x-text="$store.pms.guestById(r.guestId)?.name"></p>
                                <p class="truncate text-xs text-muted" x-text="$store.pms.roomTypeById(r.roomTypeId)?.name + ' · ' + r.code"></p>
                            </div>
                            <x-hotel.reservation-pill status="r.status" />
                        </li>
                    </template>
                </ul>
            </div>

            {{-- Departures --}}
            <div class="surface-card rounded-2xl border p-5">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-semibold text-heading" x-text="$t('dashboard.departuresToday')"></h3>
                    <a href="{{ route('app.checkin') }}" class="text-sm font-medium text-brand-600 hover:text-brand-700" x-text="$t('common.viewAll')"></a>
                </div>
                <template x-if="departures.length === 0">
                    <p class="mt-6 text-center text-sm text-muted" x-text="$t('dashboard.noDepartures')"></p>
                </template>
                <ul class="mt-4 divide-y divide-themed" x-show="departures.length > 0">
                    <template x-for="r in departures.slice(0, 5)" :key="r.id">
                        <li class="flex items-center gap-3 py-3">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-warning-50 text-warning-600 dark:bg-warning-500/15">
                                <x-icon name="logout" :size="16" />
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-heading" x-text="$store.pms.guestById(r.guestId)?.name"></p>
                                <p class="truncate text-xs text-muted" x-text="$store.pms.roomTypeById(r.roomTypeId)?.name + ' · ' + r.code"></p>
                            </div>
                            <x-hotel.reservation-pill status="r.status" />
                        </li>
                    </template>
                </ul>
            </div>

            {{-- Hotel status --}}
            <div class="surface-card rounded-2xl border p-5">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-semibold text-heading" x-text="$t('dashboard.hotelStatus')"></h3>
                    <a href="{{ route('app.room-map') }}" class="text-sm font-medium text-brand-600 hover:text-brand-700" x-text="$t('dashboard.viewMap')"></a>
                </div>
                <ul class="mt-4 space-y-3">
                    <template x-for="s in statusList" :key="s.key">
                        <li class="flex items-center gap-3">
                            <span class="h-3 w-3 rounded-full" :class="s.color"></span>
                            <span class="flex-1 text-sm text-body" x-text="$t('roomStatuses.' + s.key)"></span>
                            <span class="text-sm font-semibold text-heading" x-text="counts[s.key]"></span>
                        </li>
                    </template>
                    <li class="flex items-center gap-3 border-t border-themed pt-3">
                        <span class="h-3 w-3 rounded-full bg-gray-300"></span>
                        <span class="flex-1 text-sm font-medium text-body" x-text="$t('dashboard.totalRooms')"></span>
                        <span class="text-sm font-bold text-heading" x-text="m.totalRooms"></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function dashboardPage() {
                return {
                    areaChart: null,
                    donutChart: null,
                    statusList: [
                        { key: 'livre', color: 'bg-success-500' },
                        { key: 'ocupado', color: 'bg-brand-500' },
                        { key: 'reservado', color: 'bg-gray-400' },
                        { key: 'limpeza', color: 'bg-warning-500' },
                        { key: 'manutencao', color: 'bg-error-500' },
                    ],
                    get m() {
                        return htHelpers.computeMetrics($store.pms.rooms, $store.pms.reservations, $store.pms.roomTypes, htHelpers.TODAY);
                    },
                    get counts() { return htHelpers.countRoomsByStatus($store.pms.rooms); },
                    get arrivals() { return htHelpers.arrivalsToday($store.pms.reservations, htHelpers.TODAY); },
                    get departures() { return htHelpers.departuresToday($store.pms.reservations, htHelpers.TODAY); },
                    init() {
                        this.$nextTick(() => { this.renderArea(); this.renderDonut(); });
                        this.$watch('$store.ui.darkMode', () => this.rebuild());
                        this.$watch('$store.ui.lang', () => this.rebuild());
                    },
                    rebuild() {
                        if (this.areaChart) { this.areaChart.destroy(); this.areaChart = null; }
                        if (this.donutChart) { this.donutChart.destroy(); this.donutChart = null; }
                        this.renderArea(); this.renderDonut();
                    },
                    renderArea() {
                        const base = htChart.base();
                        const s = window.HT.occupancySeries;
                        this.areaChart = new ApexCharts(this.$refs.area, {
                            ...base,
                            chart: { ...base.chart, type: 'area', height: 300 },
                            colors: ['#465fff'],
                            series: [{ name: this.$t('dashboard.kpis.occupancy'), data: s.occupancy }],
                            xaxis: { categories: s.categories },
                            yaxis: { max: 100, labels: { formatter: v => Math.round(v) + '%' } },
                            fill: { type: 'gradient', gradient: { opacityFrom: 0.4, opacityTo: 0.05 } },
                            legend: { show: false },
                        });
                        this.areaChart.render();
                    },
                    renderDonut() {
                        const base = htChart.base();
                        const channels = htHelpers.CHANNELS;
                        const rev = htHelpers.revenueByChannel($store.pms.reservations);
                        this.donutChart = new ApexCharts(this.$refs.donut, {
                            ...base,
                            chart: { ...base.chart, type: 'donut', height: 300 },
                            colors: ['#465fff', '#12b76a', '#f79009', '#0ba5ec'],
                            series: channels.map(c => rev[c]),
                            labels: channels.map(c => this.$t('channels.' + c)),
                            legend: { ...base.legend, position: 'bottom' },
                            dataLabels: { enabled: true },
                            stroke: { width: 0 },
                            plotOptions: { pie: { donut: { size: '62%' } } },
                            tooltip: { ...base.tooltip, y: { formatter: v => htHelpers.formatCurrency(v) } },
                        });
                        this.donutChart.render();
                    },
                };
            }
        </script>
    @endpush
</x-layout.app>
