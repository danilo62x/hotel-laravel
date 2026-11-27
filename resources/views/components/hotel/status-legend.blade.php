{{-- Room-status legend — mirrors StatusLegend in RoomStatusTile.tsx. --}}
@php($statuses = [
    'livre' => 'bg-success-500',
    'ocupado' => 'bg-brand-500',
    'reservado' => 'bg-gray-400',
    'limpeza' => 'bg-warning-500',
    'manutencao' => 'bg-error-500',
])
<div class="flex flex-wrap items-center gap-x-5 gap-y-2" x-data>
    @foreach ($statuses as $key => $dot)
        <span class="inline-flex items-center gap-2 text-xs text-body">
            <span class="h-3 w-3 rounded-full {{ $dot }}"></span>
            <span x-text="$t('roomStatuses.{{ $key }}')"></span>
        </span>
    @endforeach
</div>
