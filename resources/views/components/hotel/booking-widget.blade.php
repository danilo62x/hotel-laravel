@props([
    'variant' => 'row',
    'submitExpr' => null,
    'submitLabelKey' => 'booking.search',
])
{{-- Booking widget (dates + guests) bound to the ht-booking Alpine store —
    mirrors hotel/react components/hotel/BookingWidget.tsx. --}}
<div x-data="{
        get nights() { return htHelpers.nights($store.booking.checkIn, $store.booking.checkOut); },
        today: htHelpers.todayISO(),
        onCheckIn(v) {
            const co = v >= $store.booking.checkOut ? htHelpers.addDays(v, 1) : $store.booking.checkOut;
            $store.booking.setDates(v, co);
        },
        onCheckOut(v) { if (v > $store.booking.checkIn) $store.booking.setDates($store.booking.checkIn, v); },
    }"
    class="{{ $variant === 'row' ? 'grid gap-3 sm:grid-cols-2 lg:grid-cols-[1fr_1fr_auto_auto] lg:items-end' : 'space-y-3' }}">
    <label class="block">
        <span class="mb-1.5 flex items-center gap-1.5 text-xs font-medium text-muted">
            <x-icon name="calendar" :size="14" /> <span x-text="$t('booking.checkIn')"></span>
        </span>
        <input type="date" :min="today" :value="$store.booking.checkIn" @change="onCheckIn($event.target.value)"
            class="focus-ring w-full rounded-lg border border-themed bg-transparent px-3 py-2.5 text-sm text-body" />
    </label>
    <label class="block">
        <span class="mb-1.5 flex items-center gap-1.5 text-xs font-medium text-muted">
            <x-icon name="calendar" :size="14" /> <span x-text="$t('booking.checkOut')"></span>
        </span>
        <input type="date" :min="$store.booking.checkIn" :value="$store.booking.checkOut" @change="onCheckOut($event.target.value)"
            class="focus-ring w-full rounded-lg border border-themed bg-transparent px-3 py-2.5 text-sm text-body" />
    </label>
    <label class="block">
        <span class="mb-1.5 flex items-center gap-1.5 text-xs font-medium text-muted">
            <x-icon name="users" :size="14" /> <span x-text="$t('booking.guests')"></span>
        </span>
        <select :value="$store.booking.guests" @change="$store.booking.setGuests(Number($event.target.value))"
            class="focus-ring w-full rounded-lg border border-themed bg-transparent px-3 py-2.5 text-sm text-body">
            <template x-for="g in [1,2,3,4,5,6]" :key="g">
                <option :value="g" class="bg-white dark:bg-gray-dark" x-text="$t('booking.guestCount', { count: g })"></option>
            </template>
        </select>
    </label>
    <button type="button" @click="{{ $submitExpr ?? "window.location.href = '/quartos'" }}"
        class="flex h-11 items-center justify-center gap-2 rounded-lg bg-brand-500 px-5 text-sm font-medium text-white transition hover:bg-brand-600">
        <x-icon name="search" :size="16" />
        <span x-text="$t('{{ $submitLabelKey }}')"></span>
    </button>
    @if ($variant === 'stacked')
        <p class="text-center text-xs text-muted" x-text="$t('booking.nights', { count: nights })"></p>
    @endif
</div>
