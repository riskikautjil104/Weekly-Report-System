@props(['status'])

@php
    $normalized = strtolower(trim((string) $status));

    $label = match ($normalized) {
        'selesai' => 'Selesai',
        'progress' => 'Progress',
        'kendala' => 'Kendala',
        'admin' => 'Admin',
        'user' => 'User',
        'active' => 'Active',
        'pending' => 'Pending',
        'inactive' => 'Inactive',
        default => $status,
    };

    $classes = match ($normalized) {
        'selesai', 'active', 'admin' => 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20',
        'kendala', 'inactive' => 'bg-rose-500/10 text-rose-500 border-rose-500/20',
        'progress', 'pending', 'user' => 'bg-amber-500/10 text-amber-500 border-amber-500/20',
        default => 'bg-slate-500/10 text-slate-500 border-slate-500/20',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] {$classes}"]) }}>
    {{ $label }}
</span>
