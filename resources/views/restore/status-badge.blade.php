@props(['status'])

@php
    $key = strtolower((string) $status);

    $map = [
        'selesai' => ['Selesai', 'bg-emerald-100 text-emerald-800 ring-1 ring-emerald-200'],
        'progress' => ['Progress', 'bg-amber-100 text-amber-800 ring-1 ring-amber-200'],
        'kendala' => ['Kendala', 'bg-rose-100 text-rose-800 ring-1 ring-rose-200'],
        'active' => ['ACTIVE', 'bg-emerald-100 text-emerald-800 ring-1 ring-emerald-200'],
        'pending' => ['PENDING', 'bg-surface-container-high text-on-surface-variant ring-1 ring-outline-variant'],
    ];

    [$label, $classes] = $map[$key] ?? [strtoupper($key ?: 'unknown'), 'bg-surface-container-high text-on-surface-variant ring-1 ring-outline-variant'];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-lg px-3 py-1 text-xs font-semibold tracking-wide ' . $classes]) }}>
    {{ $label }}
</span>
