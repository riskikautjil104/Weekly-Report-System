@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-secondary">Print Preview</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-on-surface">Weekly Report PDF</h2>
            </div>
            <button onclick="window.print()" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm">
                <span class="material-symbols-outlined text-[20px]">print</span>
                Print
            </button>
        </div>

        <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
            <div class="grid gap-4 md:grid-cols-4">
                <x-stat-card label="Total Task" :value="$summary['total_tasks']" hint="Semua aktivitas pada periode terpilih" icon="assignment" tone="primary" />
                <x-stat-card label="Selesai" :value="$summary['selesai']" hint="Task yang sudah final" icon="check_circle" tone="success" />
                <x-stat-card label="Progress" :value="$summary['progress']" hint="Task yang masih berjalan" icon="hourglass_top" tone="warning" />
                <x-stat-card label="Kendala" :value="$summary['kendala']" hint="Task yang butuh bantuan" icon="report" tone="danger" />
            </div>
        </section>
    </div>
@endsection
