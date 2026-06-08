@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <section class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-secondary">System Reports</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-on-surface">Operational Monitoring</h2>
                <p class="mt-2 max-w-2xl text-sm text-on-surface-variant">{{ $pageLead }}</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('reports.system.export', request()->query()) }}" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                    <span class="material-symbols-outlined text-[20px]">description</span>
                    Export Weekly Report .docx
                </a>
                <a href="{{ route('reports.system.print', request()->query()) }}" target="_blank" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-secondary transition hover:bg-surface-container-high">
                    <span class="material-symbols-outlined text-[20px]">picture_as_pdf</span>
                    Print / PDF
                </a>
            </div>
        </section>

        <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
            <form method="GET" action="{{ route('reports.system') }}" class="grid gap-4 md:grid-cols-4">
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
                    <a href="{{ route('reports.system') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-secondary transition hover:bg-surface-container-high">
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
                    <p class="mt-2 text-sm font-semibold text-on-surface">All User Accounts</p>
                </div>

                <div class="rounded-xl border border-outline-variant bg-surface-container-low p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Most Active</p>
                    <p class="mt-2 text-sm font-semibold text-on-surface">{{ $mostActiveUser }}</p>
                </div>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <x-stat-card label="Total Activities" :value="$summary['total_tasks']" hint="Semua log pada periode ini" icon="list_alt" tone="primary" />
            <x-stat-card label="Completion Rate" :value="$summary['completion_rate'] . '%'" hint="Rata-rata ketuntasan tim" icon="check_circle" tone="success" />
            <x-stat-card label="Active Users" :value="$activeUsers" hint="Akun yang punya aktivitas" icon="groups" tone="neutral" />
            <x-stat-card label="Open Blockers" :value="$summary['kendala']" hint="Aktivitas yang masih kendala" icon="priority_high" tone="warning" />
        </section>

        <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">User Overview</p>
                    <h3 class="mt-1 text-xl font-bold text-on-surface">Ringkasan per User</h3>
                </div>
                <span class="rounded-full bg-surface-container px-3 py-1 text-xs font-semibold text-primary">{{ $filters['dateRange'] }}</span>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-0">
                    <thead>
                        <tr class="text-left text-xs uppercase tracking-[0.18em] text-secondary">
                            <th class="border-b border-outline-variant px-4 py-3">User</th>
                            <th class="border-b border-outline-variant px-4 py-3">Total</th>
                            <th class="border-b border-outline-variant px-4 py-3">Selesai</th>
                            <th class="border-b border-outline-variant px-4 py-3">Progress</th>
                            <th class="border-b border-outline-variant px-4 py-3">Kendala</th>
                            <th class="border-b border-outline-variant px-4 py-3">Submission Rate</th>
                            <th class="border-b border-outline-variant px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        @forelse ($reports as $report)
                            <tr class="align-top hover:bg-surface-container transition-colors">
                                <td class="px-4 py-4 text-sm font-medium text-on-surface">{{ $report['user'] }}</td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $report['total'] }}</td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $report['selesai'] }}</td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $report['progress'] }}</td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $report['kendala'] }}</td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $report['submission_rate'] }}%</td>
                                <td class="px-4 py-4"><x-status-badge :status="$report['status']" /></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-sm text-on-surface-variant">
                                    Belum ada data aktivitas untuk rentang ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
