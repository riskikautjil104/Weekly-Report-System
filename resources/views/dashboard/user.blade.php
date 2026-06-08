@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        {{-- User Dashboard - Template parity --}}
        <section class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-secondary">User Dashboard</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-on-surface">Welcome back, {{ $userName }}</h2>
                <p class="mt-2 max-w-2xl text-sm text-on-surface-variant">{{ $pageLead }}</p>
            </div>

            <a href="{{ route('activities.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                <span class="material-symbols-outlined text-[20px]">add</span>
                Input Activity Today
            </a>
        </section>

        {{-- Bento Summary Cards (4) --}}
        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <x-stat-card label="Total Tasks" :value="$summary['total_tasks']" hint="Semua aktivitas dalam periode ini" icon="task" tone="primary" />
            <x-stat-card label="Selesai" :value="$summary['selesai']" hint="Task yang sudah ditutup" icon="check_circle" tone="success" />
            <x-stat-card label="Progress" :value="$summary['progress']" hint="Task yang masih dikerjakan" icon="sync" tone="warning" />
            <x-stat-card label="Kendala" :value="$summary['kendala']" hint="Task yang butuh follow-up" icon="warning" tone="danger" />
        </section>

        {{-- Trend + Quick Tips / Matches template structure --}}
        <section class="grid gap-6 xl:grid-cols-[1.25fr_0.75fr]">
            <article class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Weekly Trend</p>
                        <h3 class="mt-1 text-xl font-bold text-on-surface">{{ $weekLabel }}</h3>
                    </div>
                    <span class="rounded-full bg-surface-container px-3 py-1 text-xs font-semibold text-primary">
                        Completion Rate: {{ $summary['completion_rate'] }}%
                    </span>
                </div>

                <div class="mt-6 flex items-end gap-3 overflow-x-auto pb-2">
                    @foreach ($trend as $bar)
                        <div class="flex min-w-[72px] flex-1 flex-col items-center gap-3">
                            <div class="flex h-56 w-full items-end justify-center rounded-2xl bg-surface-container-low px-3 pt-3">
                                <div class="w-full rounded-t-2xl bg-gradient-to-t from-primary to-primary-container shadow-sm" style="height: {{ max(24, $bar['value'] * 28) }}px"></div>
                            </div>
                            <span class="text-xs font-semibold uppercase tracking-[0.2em] text-secondary">{{ $bar['label'] }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 flex items-center justify-between gap-3 border-t border-outline-variant pt-4">
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold uppercase tracking-[0.18em] text-secondary">Report Progress</span>
                            <span class="text-xs font-semibold text-primary">{{ $summary['completion_rate'] }}%</span>
                        </div>
                        <div class="mt-3 w-full rounded-full bg-surface-container">
                            <div class="h-2 rounded-full bg-gradient-to-r from-primary to-primary-container" style="width: {{ $summary['completion_rate'] }}%"></div>
                        </div>
                    </div>
                </div>
            </article>

            <aside class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Quick Tips</p>
                        <h3 class="mt-1 text-xl font-bold text-on-surface">Weekly Habits</h3>
                    </div>
                    <span class="material-symbols-outlined text-primary">tips_and_updates</span>
                </div>

                <ul class="mt-5 space-y-3">
                    @forelse ($reminders as $reminder)
                        <li class="rounded-xl border border-outline-variant bg-surface px-4 py-3 text-sm text-on-surface-variant">
                            {{ $reminder }}
                        </li>
                    @empty
                        <li class="rounded-xl border border-outline-variant bg-surface px-4 py-3 text-sm text-on-surface-variant">
                            Tidak ada reminder untuk minggu ini.
                        </li>
                    @endforelse
                </ul>

                <div class="mt-6 rounded-2xl border border-outline-variant bg-surface-container-low p-4">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-secondary">Reminder Channel</p>
                            <h4 class="mt-1 text-base font-bold text-on-surface">WhatsApp</h4>
                        </div>
                        <span class="material-symbols-outlined text-primary">chat</span>
                    </div>

                    <p class="mt-3 text-sm text-on-surface-variant">
                        @if ($whatsappNumber)
                            Aktif di {{ $whatsappNumber }} untuk follow-up cepat dan reminder harian.
                        @else
                            Nomor WhatsApp belum diisi. Tambahkan di profile supaya reminder bisa dikirim ke chat.
                        @endif
                    </p>

                    <div class="mt-4 flex flex-col gap-3">
                        @if ($whatsappLink)
                            <a href="{{ $whatsappLink }}" target="_blank" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#25D366] px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                                <span class="material-symbols-outlined text-[20px]">send</span>
                                Open WhatsApp
                            </a>
                        @else
                            <a href="{{ route('profile.edit') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                                <span class="material-symbols-outlined text-[20px]">settings</span>
                                Set WhatsApp Number
                            </a>
                        @endif
                    </div>
                </div>
            </aside>
        </section>

        {{-- Recent Activity table + Weekly Report preview block --}}
        <section class="grid gap-6 lg:grid-cols-[1.3fr_0.9fr]">
            <article class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Recent Daily Activity</p>
                        <h3 class="mt-1 text-xl font-bold text-on-surface">Recent Daily Activity</h3>
                    </div>
                    <a href="{{ route('reports.index') }}" class="text-sm font-semibold text-primary hover:underline">View All History</a>
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
                            @forelse ($recentActivities as $activity)
                                <tr class="align-top hover:bg-surface-container transition-colors">
                                    <td class="px-4 py-4 text-sm font-medium text-on-surface">{{ $activity->tanggal?->translatedFormat('d M Y') }}</td>
                                    <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $activity->aktivitas }}</td>
                                    <td class="px-4 py-4"><x-status-badge :status="$activity->status" /></td>
                                    <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $activity->keterangan ?: '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-sm text-on-surface-variant">
                                        Belum ada aktivitas yang tercatat minggu ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>

            <aside class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-secondary">Weekly Report</p>
                    <h3 class="mt-2 text-xl font-bold text-on-surface">Generate your report</h3>
                    <p class="mt-2 text-sm text-on-surface-variant">Ringkasan minggu {{ $weekLabel }} berdasarkan data aktual yang sudah masuk.</p>
                </div>

                <div class="mt-5 flex flex-col gap-3">
                    <div class="rounded-xl border border-dashed border-outline-variant bg-surface-container-lowest p-5">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-on-surface">{{ $weekLabel }}</p>
                            <span class="rounded-full bg-surface-container px-3 py-1 text-xs font-semibold text-primary">Live</span>
                        </div>
                        <div class="mt-3 grid gap-3 md:grid-cols-3">
                            <div class="rounded-lg border border-outline-variant bg-surface-container-low px-4 py-3">
                                <p class="text-xs uppercase tracking-[0.18em] text-secondary">Total</p>
                                <p class="mt-1 text-lg font-bold text-on-surface">{{ $summary['total_tasks'] }}</p>
                            </div>
                            <div class="rounded-lg border border-outline-variant bg-surface-container-low px-4 py-3">
                                <p class="text-xs uppercase tracking-[0.18em] text-secondary">Completion</p>
                                <p class="mt-1 text-lg font-bold text-on-surface">{{ $summary['completion_rate'] }}%</p>
                            </div>
                            <div class="rounded-lg border border-outline-variant bg-surface-container-low px-4 py-3">
                                <p class="text-xs uppercase tracking-[0.18em] text-secondary">Blockers</p>
                                <p class="mt-1 text-lg font-bold text-on-surface">{{ $summary['kendala'] }}</p>
                            </div>
                        </div>
                        <div class="mt-3 text-xs uppercase tracking-[0.18em] text-secondary">Status: Live summary</div>
                    </div>

                    <div class="grid grid-cols-1 gap-3">
                        <a href="{{ route('reports.index') }}" class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                            <span class="material-symbols-outlined">picture_as_pdf</span>
                            Open Reports
                        </a>
                        <a href="{{ route('activities.create') }}" class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-secondary transition hover:bg-surface-container transition-all">
                            <span class="material-symbols-outlined">add</span>
                            Add Activity
                        </a>
                    </div>
                </div>
            </aside>
        </section>
    </div>
@endsection
