@props([
    'status' => '',
])
{{-- Reservation status pill. `status` is an Alpine expression resolving to a
    status key (confirmada/checkin/checkout/cancelada/noshow). --}}
<span x-data="{ st: {{ $status }} }"
    class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium"
    :class="{
        'bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400': st === 'confirmada',
        'bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-500': st === 'checkin',
        'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300': st === 'checkout',
        'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500': st === 'cancelada',
        'bg-warning-50 text-warning-700 dark:bg-warning-500/15 dark:text-warning-500': st === 'noshow',
    }">
    <span class="h-1.5 w-1.5 rounded-full"
        :class="{
            'bg-brand-500': st === 'confirmada', 'bg-success-500': st === 'checkin',
            'bg-gray-400': st === 'checkout', 'bg-error-500': st === 'cancelada', 'bg-warning-500': st === 'noshow',
        }"></span>
    <span x-text="$t('reservationStatuses.' + st)"></span>
</span>
