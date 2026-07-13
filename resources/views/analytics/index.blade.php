@extends('layouts.app')

@section('content')
    @php
        $a = $analytics;
        $p = $a['payroll'];
        $rp = fn ($n) => $payrollCalculator->formatRupiah($n);
    @endphp

    <div class="space-y-6">
        <section class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-secondary">Analytics</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-on-surface">Analisis Laporan</h2>
                <p class="mt-2 max-w-2xl text-sm text-on-surface-variant">
                    @if ($isAdmin)
                        Analisis aktivitas harian, produktivitas, dan estimasi biaya lembur seluruh tim.
                    @else
                        Analisis aktivitas dan lembur kamu per minggu, bulan, atau periode custom.
                    @endif
                </p>
            </div>
        </section>

        @include('partials.overtime-filters', [
            'action' => $isAdmin ? route('admin.analytics.index') : route('analytics.index'),
            'filters' => $filters,
            'users' => $users,
            'showUserFilter' => $isAdmin,
            'showExport' => $isAdmin,
        ])

        @if ($isAdmin)
            @php
                $exportRoute = route('admin.analytics.export', request()->query());
                $printRoute = route('admin.analytics.print', request()->query());
            @endphp
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const form = document.getElementById('overtime-filter-form');
                    if (!form) return;
                    const exportBtn = form.querySelector('a[href*="export"]');
                    const printBtn = form.querySelector('a[href*="print"]');
                    if (exportBtn) exportBtn.href = @json($exportRoute);
                    if (printBtn) printBtn.href = @json($printRoute);
                });
            </script>
        @endif

        {{-- Payroll reference --}}
        <section class="rounded-2xl border border-primary/20 bg-primary/5 p-6 shadow-sm">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">payments</span>
                <h3 class="text-lg font-semibold text-on-surface">Referensi Gaji (Senin–Sabtu, 26 hari/bulan)</h3>
            </div>
            <div class="mt-4 grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
                <div class="rounded-xl bg-white/80 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Gaji Bulanan</p>
                    <p class="mt-1 text-lg font-bold text-on-surface">{{ $rp($p['monthly_salary']) }}</p>
                </div>
                <div class="rounded-xl bg-white/80 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Per Hari</p>
                    <p class="mt-1 text-lg font-bold text-on-surface">{{ $rp($p['daily_rate']) }}</p>
                    <p class="text-xs text-on-surface-variant">{{ $p['working_days_per_month'] }} hari kerja</p>
                </div>
                <div class="rounded-xl bg-white/80 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Per Jam</p>
                    <p class="mt-1 text-lg font-bold text-on-surface">{{ $rp($p['hourly_rate']) }}</p>
                    <p class="text-xs text-on-surface-variant">{{ $p['hours_per_day'] }} jam/hari ({{ $p['work_start'] }}–{{ $p['work_end'] }})</p>
                </div>
                <div class="rounded-xl bg-white/80 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Rate Lembur/Jam</p>
                    <p class="mt-1 text-lg font-bold text-primary">{{ $rp($p['overtime_hourly_rate']) }}</p>
                    <p class="text-xs text-on-surface-variant">× {{ $p['overtime_multiplier'] }} dari gaji/jam</p>
                </div>
                <div class="rounded-xl bg-white/80 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Biaya Lembur Periode</p>
                    <p class="mt-1 text-lg font-bold text-primary">{{ $rp($a['overtime']['approved_cost']) }}</p>
                    <p class="text-xs text-on-surface-variant">{{ $a['overtime']['approved_hours'] }} jam disetujui</p>
                </div>
            </div>
        </section>

        {{-- Activity stats --}}
        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <x-stat-card label="Total Task" :value="$a['summary']['total_tasks']" hint="Aktivitas dalam periode" icon="assignment" tone="primary" />
            <x-stat-card label="Completion Rate" :value="$a['summary']['completion_rate'] . '%'" hint="Rasio task selesai" icon="check_circle" tone="success" />
            <x-stat-card label="Konsistensi Input" :value="$a['consistency']['logging_rate'] . '%'" hint="{{ $a['consistency']['days_with_activity'] }}/{{ $a['consistency']['working_days'] }} hari kerja tercatat" icon="calendar_month" tone="warning" />
            <x-stat-card label="Rata-rata Task/Hari" :value="$a['consistency']['avg_tasks_per_day']" hint="Saat hari input aktif" icon="trending_up" tone="neutral" />
        </section>

        <section class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
            {{-- Weekly breakdown --}}
            <article class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Breakdown Mingguan</p>
                <h3 class="mt-1 text-xl font-bold text-on-surface">Aktivitas per Minggu</h3>

                <div class="mt-6 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-xs font-semibold uppercase tracking-wider text-on-surface-variant">
                            <tr>
                                <th class="pb-3 pr-4">Minggu</th>
                                <th class="pb-3 pr-4">Total</th>
                                <th class="pb-3 pr-4">Selesai</th>
                                <th class="pb-3 pr-4">Progress</th>
                                <th class="pb-3 pr-4">Kendala</th>
                                <th class="pb-3">Rate</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant">
                            @forelse ($a['weekly_breakdown'] as $week)
                                @if ($week['total_tasks'] > 0)
                                    <tr>
                                        <td class="py-3 pr-4 font-medium text-on-surface">{{ $week['label'] }}</td>
                                        <td class="py-3 pr-4">{{ $week['total_tasks'] }}</td>
                                        <td class="py-3 pr-4 text-emerald-700">{{ $week['selesai'] }}</td>
                                        <td class="py-3 pr-4 text-amber-700">{{ $week['progress'] }}</td>
                                        <td class="py-3 pr-4 text-rose-700">{{ $week['kendala'] }}</td>
                                        <td class="py-3">
                                            <span class="rounded-full bg-surface-container px-2 py-1 text-xs font-semibold text-primary">{{ $week['completion_rate'] }}%</span>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="6" class="py-6 text-on-surface-variant">Belum ada data aktivitas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>

            {{-- Insights + Overtime --}}
            <aside class="space-y-4">
                <div class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Insights</p>
                    <h3 class="mt-1 text-xl font-bold text-on-surface">Analisis Otomatis</h3>
                    <ul class="mt-4 space-y-3">
                        @foreach ($a['insights'] as $insight)
                            <li class="rounded-xl border border-outline-variant bg-surface px-4 py-3 text-sm text-on-surface-variant">{{ $insight }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Lembur</p>
                    <h3 class="mt-1 text-xl font-bold text-on-surface">Ringkasan Periode</h3>
                    <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                        <div class="rounded-xl bg-surface-container p-3">
                            <p class="text-xs text-on-surface-variant">Total Laporan</p>
                            <p class="font-bold text-on-surface">{{ $a['overtime']['total_requests'] }}</p>
                        </div>
                        <div class="rounded-xl bg-emerald-50 p-3">
                            <p class="text-xs text-emerald-800">Disetujui</p>
                            <p class="font-bold text-emerald-900">{{ $a['overtime']['approved'] }} ({{ $a['overtime']['approved_hours'] }}j)</p>
                        </div>
                        <div class="rounded-xl bg-amber-50 p-3">
                            <p class="text-xs text-amber-800">Menunggu</p>
                            <p class="font-bold text-amber-900">{{ $a['overtime']['submitted'] }}</p>
                        </div>
                        <div class="rounded-xl bg-primary/10 p-3">
                            <p class="text-xs text-primary">Estimasi Biaya</p>
                            <p class="font-bold text-primary">{{ $rp($a['overtime']['approved_cost']) }}</p>
                        </div>
                    </div>
                </div>
            </aside>
        </section>

        {{-- Status distribution --}}
        <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Distribusi Status</p>
            <div class="mt-4 grid gap-4 md:grid-cols-3">
                @php
                    $total = max(1, $a['summary']['total_tasks']);
                    $statuses = [
                        ['label' => 'Selesai', 'value' => $a['status_distribution']['selesai'], 'color' => 'bg-emerald-500', 'text' => 'text-emerald-800'],
                        ['label' => 'Progress', 'value' => $a['status_distribution']['progress'], 'color' => 'bg-amber-500', 'text' => 'text-amber-800'],
                        ['label' => 'Kendala', 'value' => $a['status_distribution']['kendala'], 'color' => 'bg-rose-500', 'text' => 'text-rose-800'],
                    ];
                @endphp
                @foreach ($statuses as $status)
                    <div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="font-semibold {{ $status['text'] }}">{{ $status['label'] }}</span>
                            <span class="text-on-surface-variant">{{ $status['value'] }} ({{ round($status['value'] / $total * 100) }}%)</span>
                        </div>
                        <div class="mt-2 h-2 rounded-full bg-surface-container">
                            <div class="h-2 rounded-full {{ $status['color'] }}" style="width: {{ round($status['value'] / $total * 100) }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Admin team table --}}
        @if ($isAdmin && $teamBreakdown->isNotEmpty())
            <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest shadow-sm overflow-hidden">
                <div class="border-b border-outline-variant px-6 py-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Tim</p>
                    <h3 class="mt-1 text-xl font-bold text-on-surface">Performa per User</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-surface-container text-left text-xs font-semibold uppercase tracking-wider text-on-surface-variant">
                            <tr>
                                <th class="px-4 py-3">User</th>
                                <th class="px-4 py-3">Task</th>
                                <th class="px-4 py-3">Selesai</th>
                                <th class="px-4 py-3">Rate</th>
                                <th class="px-4 py-3">Konsistensi</th>
                                <th class="px-4 py-3">Lembur</th>
                                <th class="px-4 py-3">Biaya Lembur</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant">
                            @foreach ($teamBreakdown as $row)
                                <tr class="hover:bg-surface-container-low">
                                    <td class="px-4 py-3 font-medium">{{ $row['user']->name }}</td>
                                    <td class="px-4 py-3">{{ $row['summary']['total_tasks'] }}</td>
                                    <td class="px-4 py-3 text-emerald-700">{{ $row['summary']['selesai'] }}</td>
                                    <td class="px-4 py-3">{{ $row['summary']['completion_rate'] }}%</td>
                                    <td class="px-4 py-3">{{ $row['logging_rate'] }}%</td>
                                    <td class="px-4 py-3">{{ round($row['overtime_approved_minutes'] / 60, 1) }}j</td>
                                    <td class="px-4 py-3 font-semibold text-primary">{{ $rp($row['overtime_cost']) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        @endif
    </div>
@endsection
