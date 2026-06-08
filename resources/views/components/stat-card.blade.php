@props([
    'label',
    'value',
    'hint',
    'icon',
    'tone' => 'primary',
])

@php
    $toneClasses = match ($tone) {
        'success' => ['badge' => 'bg-emerald-500/10 text-emerald-500', 'value' => 'text-emerald-400'],
        'warning' => ['badge' => 'bg-amber-500/10 text-amber-500', 'value' => 'text-amber-400'],
        'danger' => ['badge' => 'bg-rose-500/10 text-rose-500', 'value' => 'text-rose-400'],
        default => ['badge' => 'bg-primary/10 text-primary', 'value' => 'text-primary'],
    };
@endphp

<article {{ $attributes->merge(['class' => 'rounded-2xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm']) }}>
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-on-surface-variant">{{ $label }}</p>
            <p class="mt-3 text-2xl font-bold tracking-tight {{ $toneClasses['value'] }}">{{ $value }}</p>
        </div>
        <div class="flex h-11 w-11 items-center justify-center rounded-2xl {{ $toneClasses['badge'] }}">
            <span class="material-symbols-outlined">{{ $icon }}</span>
        </div>
    </div>
    <p class="mt-4 text-sm text-on-surface-variant">{{ $hint }}</p>
</article>
