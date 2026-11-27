@props([
    'name' => '',
    'size' => 'md',
])
@php($sizeClass = [
    'xs' => 'h-7 w-7 text-[10px]',
    'sm' => 'h-9 w-9 text-xs',
    'md' => 'h-11 w-11 text-sm',
    'lg' => 'h-14 w-14 text-base',
    'xl' => 'h-16 w-16 text-lg',
][$size] ?? 'h-11 w-11 text-sm')
@php(
    $initials = collect(preg_split('/\s+/', trim($name)))
        ->filter()->take(2)
        ->map(fn ($p) => mb_strtoupper(mb_substr($p, 0, 1)))
        ->implode('') ?: '?'
)
<span class="relative inline-flex shrink-0">
    <span class="flex items-center justify-center rounded-full bg-brand-500 font-bold text-white {{ $sizeClass }}">{{ $initials }}</span>
</span>
