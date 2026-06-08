@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <section class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-secondary">My Reports</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-on-surface">Weekly Report Summary</h2>
                <p class="mt-2 max-w-2xl text-sm text-on-surface-variant">{{ $pageLead }}</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('reports.export', request()->query()) }}" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-secondary transition hover:bg-surface-container-high">
                    <span class="material-symbols-outlined text-[20px]">file_download</span>
                    Export Excel
                </a>
                <a href="{{ route('reports.print', request()->query()) }}" target="_blank" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                    <span class="material-symbols-outlined text-[20px]">picture_as_pdf</span>
                    Export PDF
                </a>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <x-stat-card label="Total Task" :value="$summary['total_tasks']" hint="Semua aktivitas pada periode terpilih" icon="assignment" tone="primary" />
            <x-stat-card label="Selesai" :value="$summary['selesai']" hint="Task yang sudah final" icon="check_circle" tone="success" />
            <x-stat-card label="Progress" :value="$summary['progress']" hint="Task yang masih berjalan" icon="hourglass_top" tone="warning" />
            <x-stat-card label="Kendala" :value="$summary['kendala']" hint="Task yang butuh bantuan" icon="report" tone="danger" />
        </section>

        <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
            <form method="GET" action="{{ route('reports.index') }}" class="grid gap-4 md:grid-cols-4">
                <label class="space-y-2">
                    <span class="text-sm font-semibold text-on-surface">From Date</span>
                    <input type="date" name="date_from" value="{{ $filters['date_from'] }}" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                </label>

                <label class="space-y-2">
                    <span class="text-sm font-semibold text-on-surface">To Date</span>
                    <input type="date" name="date_to" value="{{ $filters['date_to'] }}" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                </label>

                <label class="space-y-2">
                    <span class="text-sm font-semibold text-on-surface">Status</span>
                    <select name="status" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                        <option value="all" @selected(($filters['status'] ?? 'all') === 'all')>All Status</option>
                        <option value="selesai" @selected(($filters['status'] ?? '') === 'selesai')>Selesai</option>
                        <option value="progress" @selected(($filters['status'] ?? '') === 'progress')>Progress</option>
                        <option value="kendala" @selected(($filters['status'] ?? '') === 'kendala')>Kendala</option>
                    </select>
                </label>

                <div class="flex items-end gap-3">
                    <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                        <span class="material-symbols-outlined text-[20px]">filter_alt</span>
                        Apply Filters
                    </button>
                    <a href="{{ route('reports.index') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-secondary transition hover:bg-surface-container-high">
                        Reset
                    </a>
                </div>
            </form>

            <div class="mt-4 grid gap-4 md:grid-cols-3">
                <div class="rounded-xl border border-outline-variant bg-surface-container-low p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Date Range</p>
                    <p class="mt-2 text-sm font-semibold text-on-surface">{{ $filters['dateRange'] }}</p>
                </div>
                <div class="rounded-xl border border-outline-variant bg-surface-container-low p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Scope</p>
                    <p class="mt-2 text-sm font-semibold text-on-surface">My Activity Logs</p>
                </div>
                <div class="rounded-xl border border-outline-variant bg-surface-container-low p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Report Status</p>
                    <p class="mt-2 text-sm font-semibold text-on-surface">{{ ucfirst($filters['status'] ?: 'all') }}</p>
                </div>
            </div>
        </section>

        <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Weekly Recap</p>
                    <h3 class="mt-1 text-xl font-bold text-on-surface">Rekap Mingguan</h3>
                </div>
                <span class="rounded-full bg-surface-container px-3 py-1 text-xs font-semibold text-primary">{{ $weekLabel }}</span>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-0">
                    <thead>
                        <tr class="text-left text-xs uppercase tracking-[0.18em] text-secondary">
                            <th class="border-b border-outline-variant px-4 py-3">Periode</th>
                            <th class="border-b border-outline-variant px-4 py-3">Total Task</th>
                            <th class="border-b border-outline-variant px-4 py-3">Selesai</th>
                            <th class="border-b border-outline-variant px-4 py-3">Progress</th>
                            <th class="border-b border-outline-variant px-4 py-3">Kendala</th>
                            <th class="border-b border-outline-variant px-4 py-3">Completion</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        @forelse ($weeklyReports as $report)
                            <tr class="align-top hover:bg-surface-container transition-colors">
                                <td class="px-4 py-4 text-sm font-medium text-on-surface">{{ $report['periode'] }}</td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $report['total'] }}</td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $report['selesai'] }}</td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $report['progress'] }}</td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $report['kendala'] }}</td>
                                <td class="px-4 py-4">
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">{{ $report['rate'] }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-sm text-on-surface-variant">
                                    Tidak ada data untuk rentang yang dipilih.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Activity Log</p>
                    <h3 class="mt-1 text-xl font-bold text-on-surface">Detail Aktivitas</h3>
                </div>
                <span class="rounded-full bg-surface-container px-3 py-1 text-xs font-semibold text-primary">{{ count($activities) }} activities</span>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-0">
                    <thead>
                        <tr class="text-left text-xs uppercase tracking-[0.18em] text-secondary">
                            <th class="border-b border-outline-variant px-4 py-3">Tanggal</th>
                            <th class="border-b border-outline-variant px-4 py-3">Aktivitas</th>
                            <th class="border-b border-outline-variant px-4 py-3">Status</th>
                            <th class="border-b border-outline-variant px-4 py-3">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        @forelse ($activities as $activity)
                            <tr class="align-top hover:bg-surface-container transition-colors">
                                <td class="px-4 py-4 text-sm font-medium text-on-surface">{{ $activity->tanggal?->translatedFormat('d M Y') }}</td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $activity->aktivitas }}</td>
                                <td class="px-4 py-4"><x-status-badge :status="$activity->status" /></td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $activity->keterangan ?: '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-sm text-on-surface-variant">
                                    Belum ada aktivitas pada filter ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
