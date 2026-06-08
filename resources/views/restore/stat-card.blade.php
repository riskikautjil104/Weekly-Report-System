@props([
    'label',
    'value',
    'hint' => null,
    'icon' => null,
    'tone' => 'primary',
])

@php
    $toneClasses = [
        'primary' => 'text-primary bg-primary/10',
        'success' => 'text-emerald-700 bg-emerald-100',
        'warning' => 'text-amber-700 bg-amber-100',
        'danger' => 'text-rose-700 bg-rose-100',
        'neutral' => 'text-secondary bg-surface-container',
    ];

    $iconClasses = $toneClasses[$tone] ?? $toneClasses['primary'];
@endphp

<article class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm">
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-on-surface-variant">{{ $label }}</p>
            <p class="mt-3 text-3xl font-bold tracking-tight text-on-surface">{{ $value }}</p>
        </div>

        @if ($icon)
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl {{ $iconClasses }}">
                <span class="material-symbols-outlined">{{ $icon }}</span>
            </div>
        @endif
    </div>

    @if ($hint)
        <p class="mt-4 text-sm text-on-surface-variant">{{ $hint }}</p>
    @endif
</article>
