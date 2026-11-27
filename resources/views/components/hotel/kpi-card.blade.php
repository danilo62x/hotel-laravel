@props([
    'icon' => 'chart',
    'tone' => 'brand',
    'labelKey' => '',
    'value' => '',
    'hint' => null,
])
@php($toneCls = [
    'brand' => 'bg-brand-50 text-brand-500 dark:bg-brand-500/15',
    'success' => 'bg-success-50 text-success-600 dark:bg-success-500/15',
    'warning' => 'bg-warning-50 text-warning-600 dark:bg-warning-500/15',
    'error' => 'bg-error-50 text-error-500 dark:bg-error-500/15',
    'info' => 'bg-blue-light-50 text-blue-light-600 dark:bg-blue-light-500/15',
][$tone] ?? 'bg-brand-50 text-brand-500 dark:bg-brand-500/15')
<div class="surface-card rounded-2xl border p-5 shadow-theme-sm" x-data>
    <div class="flex items-center gap-3">
        <span class="flex h-11 w-11 items-center justify-center rounded-xl {{ $toneCls }}">
            <x-icon :name="$icon" :size="20" />
        </span>
        <p class="text-sm text-muted" x-text="$t('{{ $labelKey }}')"></p>
    </div>
    <h4 class="mt-4 text-2xl font-bold tabular-nums text-heading" x-html="{{ $value }}"></h4>
    @if ($hint)
        <p class="mt-1 text-xs text-muted" x-text="$t('{{ $hint }}')"></p>
    @endif
</div>
