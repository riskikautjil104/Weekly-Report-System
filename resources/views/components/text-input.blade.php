@props(['disabled' => false])

<input
    {{ $attributes->merge([
        'class' => 'block w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder-white/30 shadow-sm backdrop-blur transition focus:border-[#4d8aff]/50 focus:bg-white/10 focus:outline-none focus:ring-2 focus:ring-[#4d8aff]/20'
    ]) }}
>
