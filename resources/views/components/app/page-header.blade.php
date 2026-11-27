@props([
    'title' => '',
    'subtitle' => null,
    'crumbs' => [],
])
{{-- $title / $subtitle accept already-translated strings or x-text expressions via slots. --}}
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
        @if (!empty($crumbs))
            <div class="mb-2">
                <nav aria-label="Breadcrumb">
                    <ol class="flex flex-wrap items-center gap-1.5 text-sm">
                        @foreach ($crumbs as $i => $crumb)
                            @php($last = $i === count($crumbs) - 1)
                            <li class="flex items-center gap-1.5">
                                @if (!empty($crumb['href']) && !$last)
                                    <a href="{{ $crumb['href'] }}"
                                        class="inline-flex items-center gap-1.5 text-muted transition hover:text-brand-600 dark:hover:text-brand-400"
                                        x-text="$t('{{ $crumb['key'] }}')"></a>
                                @else
                                    <span @if($last) aria-current="page" @endif
                                        class="inline-flex items-center gap-1.5 {{ $last ? 'font-medium text-heading' : 'text-muted' }}"
                                        x-text="$t('{{ $crumb['key'] }}')"></span>
                                @endif
                                @unless ($last)
                                    <x-icon name="chevron-right" :size="14" class="text-gray-400" />
                                @endunless
                            </li>
                        @endforeach
                    </ol>
                </nav>
            </div>
        @endif
        <h1 class="text-2xl font-bold text-heading" x-text="$t('{{ $title }}')"></h1>
        @if ($subtitle)
            <p class="mt-1 text-sm text-muted" x-text="$t('{{ $subtitle }}')"></p>
        @endif
    </div>
    @isset($action)
        <div class="shrink-0">{{ $action }}</div>
    @endisset
</div>
