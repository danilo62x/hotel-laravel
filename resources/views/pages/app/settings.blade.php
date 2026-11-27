<x-layout.app :pageTitle="$pageTitle ?? null">
    <x-app.page-header title="settings.title" subtitle="settings.subtitle" />

    <div x-data="settingsPage()">
        {{-- Tabs --}}
        <div class="mb-6 flex flex-wrap gap-1 border-b border-themed">
            @foreach (['profile' => 'user', 'hotel' => 'bed', 'notifications' => 'bell'] as $key => $icon)
                <button type="button" @click="tab = '{{ $key }}'"
                    class="flex items-center gap-2 border-b-2 px-4 py-2.5 text-sm font-medium transition"
                    :class="tab === '{{ $key }}' ? 'border-brand-500 text-brand-600 dark:text-brand-400' : 'border-transparent text-muted hover:text-body'">
                    <x-icon name="{{ $icon }}" :size="16" /> <span x-text="$t('settings.tabs.{{ $key }}')"></span>
                </button>
            @endforeach
        </div>

        {{-- Profile --}}
        <div x-show="tab === 'profile'" class="max-w-2xl">
            <div class="surface-card rounded-2xl border p-6">
                <div class="flex items-center gap-4">
                    <span class="flex h-16 w-16 items-center justify-center rounded-full bg-brand-500 text-lg font-bold text-white" x-text="htHelpers.initials($store.auth.user?.name)"></span>
                    <button type="button" class="rounded-lg border border-themed px-4 py-2 text-sm font-medium text-body hover:bg-gray-50 dark:hover:bg-gray-800" x-text="$t('settings.profile.changePhoto')"></button>
                </div>
                <form @submit.prevent="saveProfile()" class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-heading" x-text="$t('settings.profile.name')"></label>
                        <input x-model="profile.name" type="text" class="focus-ring h-10 w-full rounded-lg border border-themed bg-transparent px-3 text-sm text-body" />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-heading" x-text="$t('settings.profile.email')"></label>
                        <input x-model="profile.email" type="email" class="focus-ring h-10 w-full rounded-lg border border-themed bg-transparent px-3 text-sm text-body" />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-heading" x-text="$t('settings.profile.role')"></label>
                        <input x-model="profile.role" type="text" class="focus-ring h-10 w-full rounded-lg border border-themed bg-transparent px-3 text-sm text-body" />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-heading" x-text="$t('settings.profile.phone')"></label>
                        <input x-model="profile.phone" type="tel" class="focus-ring h-10 w-full rounded-lg border border-themed bg-transparent px-3 text-sm text-body" />
                    </div>
                    <div class="sm:col-span-2">
                        <button type="submit" class="h-10 rounded-lg bg-brand-500 px-5 text-sm font-medium text-white hover:bg-brand-600" x-text="$t('settings.profile.save')"></button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Hotel --}}
        <div x-show="tab === 'hotel'" x-cloak class="max-w-3xl">
            <div class="surface-card rounded-2xl border p-6">
                <form @submit.prevent="$store.ui.notifySuccess($t('settings.hotel.saved'))" class="grid gap-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium text-heading" x-text="$t('settings.hotel.hotelName')"></label>
                        <input type="text" :value="$t('brand')" class="focus-ring h-10 w-full rounded-lg border border-themed bg-transparent px-3 text-sm text-body" />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-heading" x-text="$t('settings.hotel.checkInTime')"></label>
                        <input type="time" value="14:00" class="focus-ring h-10 w-full rounded-lg border border-themed bg-transparent px-3 text-sm text-body" />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-heading" x-text="$t('settings.hotel.checkOutTime')"></label>
                        <input type="time" value="12:00" class="focus-ring h-10 w-full rounded-lg border border-themed bg-transparent px-3 text-sm text-body" />
                    </div>
                    <div class="sm:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium text-heading" x-text="$t('settings.hotel.address')"></label>
                        <input type="text" :value="$t('contact.addressValue')" class="focus-ring h-10 w-full rounded-lg border border-themed bg-transparent px-3 text-sm text-body" />
                    </div>
                    <div class="sm:col-span-2">
                        <button type="submit" class="h-10 rounded-lg bg-brand-500 px-5 text-sm font-medium text-white hover:bg-brand-600" x-text="$t('common.save')"></button>
                    </div>
                </form>
            </div>

            <div class="surface-card mt-5 rounded-2xl border p-6">
                <h3 class="mb-4 text-sm font-semibold text-heading" x-text="$t('settings.hotel.roomTypes')"></h3>
                <ul class="divide-y divide-themed">
                    <template x-for="rt in $store.pms.roomTypes" :key="rt.id">
                        <li class="flex items-center justify-between py-3">
                            <div class="flex items-center gap-3">
                                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-50 text-brand-500 dark:bg-brand-500/15"><x-icon name="bed" :size="16" /></span>
                                <div>
                                    <p class="text-sm font-medium text-heading" x-text="rt.name"></p>
                                    <p class="text-xs text-muted" x-text="$t('settings.hotel.roomCount', { count: roomCount(rt.id) })"></p>
                                </div>
                            </div>
                            <span class="text-sm font-semibold text-heading" x-text="$currency(rt.baseRate)"></span>
                        </li>
                    </template>
                </ul>
            </div>
        </div>

        {{-- Notifications --}}
        <div x-show="tab === 'notifications'" x-cloak class="max-w-2xl">
            <div class="surface-card rounded-2xl border p-6">
                <ul class="divide-y divide-themed">
                    <template x-for="n in notifs" :key="n.key">
                        <li class="flex items-center justify-between py-4">
                            <div class="pr-4">
                                <p class="text-sm font-medium text-heading" x-text="$t('settings.notifications.' + n.key)"></p>
                                <p class="text-xs text-muted" x-text="$t('settings.notifications.' + n.key + 'Desc')"></p>
                            </div>
                            <button type="button" @click="n.on = !n.on; $store.ui.notifySuccess($t('settings.notifications.saved'))"
                                class="relative inline-flex h-6 w-11 shrink-0 items-center rounded-full transition"
                                :class="n.on ? 'bg-brand-500' : 'bg-gray-300 dark:bg-gray-600'">
                                <span class="inline-block h-4 w-4 transform rounded-full bg-white transition" :class="n.on ? 'translate-x-6' : 'translate-x-1'"></span>
                            </button>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function settingsPage() {
                return {
                    tab: 'profile',
                    profile: {
                        name: $store.auth.user?.name || '',
                        email: $store.auth.user?.email || '',
                        role: $store.auth.user?.role || 'Recepção',
                        phone: $store.auth.user?.phone || '',
                    },
                    notifs: [
                        { key: 'newReservation', on: true },
                        { key: 'checkinReminder', on: true },
                        { key: 'lowAvailability', on: false },
                        { key: 'dailyReport', on: true },
                    ],
                    roomCount(rtId) { return $store.pms.rooms.filter(r => r.roomTypeId === rtId).length; },
                    saveProfile() {
                        $store.auth.updateProfile(this.profile);
                        $store.ui.notifySuccess(this.$t('settings.profile.saved'));
                    },
                };
            }
        </script>
    @endpush
</x-layout.app>
