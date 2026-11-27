@props([
    'status' => '',
])
{{-- Room status pill. `status` is an Alpine expression resolving to a room
    status key (livre/ocupado/limpeza/manutencao/reservado). --}}
<span x-data="{ st: {{ $status }} }"
    class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium"
    :class="{
        'bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-500': st === 'livre',
        'bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400': st === 'ocupado',
        'bg-warning-50 text-warning-700 dark:bg-warning-500/15 dark:text-warning-500': st === 'limpeza',
        'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500': st === 'manutencao',
        'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300': st === 'reservado',
    }">
    <span class="h-1.5 w-1.5 rounded-full"
        :class="{
            'bg-success-500': st === 'livre', 'bg-brand-500': st === 'ocupado',
            'bg-warning-500': st === 'limpeza', 'bg-error-500': st === 'manutencao', 'bg-gray-400': st === 'reservado',
        }"></span>
    <span x-text="$t('roomStatuses.' + st)"></span>
</span>
