<x-layout.public :pageTitle="$pageTitle ?? null">
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8"
        x-data="roomDetail(@js($slug))" x-init="init()">

        {{-- Not found --}}
        <template x-if="!rt">
            <div class="surface-card flex flex-col items-center rounded-2xl border p-16 text-center">
                <span class="flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 text-gray-400 dark:bg-gray-800">
                    <x-icon name="bed" :size="26" />
                </span>
                <h2 class="mt-4 text-lg font-semibold text-heading" x-text="$t('detail.notFound')"></h2>
                <p class="mt-1 text-sm text-muted" x-text="$t('detail.notFoundDesc')"></p>
                <a href="{{ route('rooms') }}" class="mt-5 inline-flex h-10 items-center gap-2 rounded-lg bg-brand-500 px-5 text-sm font-medium text-white hover:bg-brand-600">
                    <x-icon name="arrow-left" :size="16" /> <span x-text="$t('detail.backToRooms')"></span>
                </a>
            </div>
        </template>

        <template x-if="rt">
            <div>
                <a href="{{ route('rooms') }}" class="mb-5 inline-flex items-center gap-1.5 text-sm text-muted hover:text-brand-600">
                    <x-icon name="arrow-left" :size="15" /> <span x-text="$t('detail.backToRooms')"></span>
                </a>

                <div class="grid gap-8 lg:grid-cols-[1.6fr_1fr]">
                    {{-- Left: gallery + content --}}
                    <div class="space-y-6">
                        {{-- Gallery --}}
                        <div>
                            <div class="overflow-hidden rounded-2xl bg-gray-100 dark:bg-gray-800">
                                <img :src="htHelpers.photoUrl(rt.slug, activePhoto, 900, 600)" :alt="rt.name" class="aspect-[3/2] w-full object-cover" />
                            </div>
                            <div class="mt-3 grid grid-cols-5 gap-2">
                                <template x-for="i in rt.photos" :key="i">
                                    <button type="button" @click="activePhoto = i"
                                        class="overflow-hidden rounded-lg border-2 transition"
                                        :class="activePhoto === i ? 'border-brand-500' : 'border-transparent'">
                                        <img :src="htHelpers.photoUrl(rt.slug, i, 160, 120)" alt="" class="aspect-[4/3] w-full object-cover" />
                                    </button>
                                </template>
                            </div>
                        </div>

                        <div>
                            <div class="flex flex-wrap items-center gap-3">
                                <h1 class="text-title-sm font-bold text-heading" x-text="rt.name"></h1>
                                <template x-if="rt.featured">
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-500 px-2.5 py-1 text-xs font-medium text-white">
                                        <x-icon name="star" :size="12" /> <span x-text="$t('rooms.featured')"></span>
                                    </span>
                                </template>
                            </div>
                            <div class="mt-3 flex flex-wrap gap-x-5 gap-y-2 text-sm text-muted">
                                <span class="inline-flex items-center gap-1.5"><x-icon name="users" :size="16" /> <span x-text="$t('booking.guestCount', { count: rt.capacity })"></span></span>
                                <span class="inline-flex items-center gap-1.5"><x-icon name="bed" :size="16" /> <span x-text="$t('beds.' + rt.bed)"></span></span>
                                <span class="inline-flex items-center gap-1.5"><x-icon name="maximize" :size="16" /> <span x-text="rt.size + ' m²'"></span></span>
                            </div>
                        </div>

                        <div>
                            <h2 class="text-base font-semibold text-heading" x-text="$t('detail.description')"></h2>
                            <p class="mt-2 text-sm leading-relaxed text-body" x-text="rt.description"></p>
                        </div>

                        <div>
                            <h2 class="text-base font-semibold text-heading" x-text="$t('detail.amenities')"></h2>
                            <div class="mt-3 grid grid-cols-2 gap-2 sm:grid-cols-3">
                                <template x-for="a in rt.amenities" :key="a">
                                    <span class="inline-flex items-center gap-2 rounded-lg border border-themed px-3 py-2 text-sm text-body">
                                        <x-icon name="check" :size="14" class="text-success-500" /> <span x-text="$t('amenities.' + a)"></span>
                                    </span>
                                </template>
                            </div>
                        </div>
                    </div>

                    {{-- Right: booking wizard --}}
                    <aside class="lg:sticky lg:top-24 lg:h-fit">
                        <div class="surface-card rounded-2xl border p-5 shadow-theme-sm">
                            <div class="flex items-baseline justify-between">
                                <p class="text-2xl font-bold text-heading">
                                    <span x-text="$currency(rt.baseRate)"></span>
                                    <span class="text-sm font-normal text-muted" x-text="$t('common.perNight')"></span>
                                </p>
                            </div>

                            {{-- Step 1: dates --}}
                            <div x-show="step === 1" class="mt-4 space-y-3">
                                <x-hotel.booking-widget variant="stacked" submitExpr="goToGuest()" submitLabelKey="detail.book" />
                                <template x-if="!available">
                                    <p class="rounded-lg bg-error-50 px-3 py-2 text-center text-xs text-error-600 dark:bg-error-500/15 dark:text-error-500" x-text="$t('detail.notAvailable')"></p>
                                </template>
                                <div class="flex items-center justify-between border-t border-themed pt-3 text-sm">
                                    <span class="text-muted" x-text="$t('detail.total')"></span>
                                    <span class="font-bold text-heading" x-text="$currency(quote)"></span>
                                </div>
                            </div>

                            {{-- Step 2: guest details --}}
                            <div x-show="step === 2" class="mt-4 space-y-3" x-cloak>
                                <p class="text-sm font-semibold text-heading" x-text="$t('detail.guestDetails')"></p>
                                <input x-model="form.name" type="text" :placeholder="$t('detail.fullName')" class="focus-ring w-full rounded-lg border border-themed bg-transparent px-3 py-2.5 text-sm text-body" />
                                <input x-model="form.email" type="email" :placeholder="$t('detail.email')" class="focus-ring w-full rounded-lg border border-themed bg-transparent px-3 py-2.5 text-sm text-body" />
                                <input x-model="form.phone" type="tel" :placeholder="$t('detail.phone')" class="focus-ring w-full rounded-lg border border-themed bg-transparent px-3 py-2.5 text-sm text-body" />
                                <input x-model="form.document" type="text" :placeholder="$t('detail.document')" class="focus-ring w-full rounded-lg border border-themed bg-transparent px-3 py-2.5 text-sm text-body" />
                                <div class="flex items-center justify-between border-t border-themed pt-3 text-sm">
                                    <span class="text-muted" x-text="$t('booking.nights', { count: nights })"></span>
                                    <span class="font-bold text-heading" x-text="$currency(quote)"></span>
                                </div>
                                <div class="flex gap-2">
                                    <button type="button" @click="step = 1" class="flex h-11 flex-1 items-center justify-center rounded-lg border border-themed text-sm font-medium text-body hover:bg-gray-50 dark:hover:bg-gray-800" x-text="$t('common.back')"></button>
                                    <button type="button" @click="confirm()" :disabled="!form.name || !form.email"
                                        class="flex h-11 flex-[2] items-center justify-center rounded-lg bg-brand-500 text-sm font-medium text-white hover:bg-brand-600 disabled:opacity-40" x-text="$t('detail.confirm')"></button>
                                </div>
                            </div>

                            {{-- Step 3: confirmation --}}
                            <div x-show="step === 3" class="mt-4 text-center" x-cloak>
                                <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-success-50 text-success-500 dark:bg-success-500/15">
                                    <x-icon name="check-circle" :size="30" />
                                </span>
                                <h3 class="mt-4 text-base font-semibold text-heading" x-text="$t('detail.confirmed')"></h3>
                                <p class="mt-1 text-sm text-muted" x-text="$t('detail.confirmedDesc')"></p>
                                <p class="mt-3 text-sm font-semibold text-brand-600" x-text="lastCode"></p>
                                <a href="{{ route('rooms') }}" class="mt-5 inline-flex h-10 items-center justify-center rounded-lg border border-themed px-5 text-sm font-medium text-body hover:bg-gray-50 dark:hover:bg-gray-800" x-text="$t('detail.backToRooms')"></a>
                            </div>
                        </div>
                    </aside>
                </div>

                {{-- Similar --}}
                <div class="mt-14">
                    <h2 class="mb-6 text-title-sm font-bold text-heading" x-text="$t('detail.similar')"></h2>
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        <template x-for="r in similar" :key="r.id">
                            <x-hotel.room-type-card rt="r" />
                        </template>
                    </div>
                </div>
            </div>
        </template>
    </div>

    @push('scripts')
        <script>
            function roomDetail(slug) {
                return {
                    slug,
                    rt: null,
                    activePhoto: 1,
                    step: 1,
                    lastCode: '',
                    form: { name: '', email: '', phone: '', document: '' },
                    init() {
                        this.rt = $store.pms.roomTypeBySlug(slug) || null;
                        if (this.rt) $store.booking.selectRoomType(slug);
                    },
                    get nights() { return htHelpers.nights($store.booking.checkIn, $store.booking.checkOut); },
                    get available() {
                        return this.rt ? htHelpers.isAvailable($store.pms.rates, this.rt.id, $store.booking.checkIn, $store.booking.checkOut) : true;
                    },
                    get quote() {
                        if (!this.rt) return 0;
                        return htHelpers.quoteStay($store.pms.rates, this.rt.id, $store.booking.checkIn, $store.booking.checkOut, this.rt.baseRate);
                    },
                    get similar() {
                        if (!this.rt) return [];
                        return $store.pms.roomTypes.filter(r => r.id !== this.rt.id).slice(0, 3);
                    },
                    goToGuest() {
                        if (!this.available) { $store.ui.notifyError(this.$t('detail.notAvailable')); return; }
                        this.step = 2;
                    },
                    confirm() {
                        if (!this.form.name || !this.form.email) return;
                        const guest = $store.pms.addGuest({
                            name: this.form.name, email: this.form.email, phone: this.form.phone,
                            document: this.form.document, country: 'BR', tier: 'bronze', notes: '',
                        });
                        const res = $store.pms.createReservation({
                            guestId: guest.id, roomTypeId: this.rt.id,
                            checkIn: $store.booking.checkIn, checkOut: $store.booking.checkOut,
                            guests: $store.booking.guests, channel: 'direto', notes: this.$t('detail.bookedOnline'),
                        });
                        this.lastCode = res.code;
                        this.step = 3;
                        $store.ui.notifySuccess(this.$t('detail.confirmed'));
                    },
                };
            }
        </script>
    @endpush
</x-layout.public>
