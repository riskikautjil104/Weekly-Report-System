@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <section class="overflow-hidden rounded-3xl border border-outline-variant bg-gradient-to-br from-surface-container-lowest via-surface-container-low to-surface-container p-6 shadow-sm">
            <div class="relative grid gap-8 lg:grid-cols-[1.15fr_0.85fr]">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-secondary">Admin Overview</p>
                    <h2 class="mt-3 text-4xl font-bold tracking-tight text-on-surface">Monitoring team performance for {{ $weekLabel }}</h2>
                    <p class="mt-4 max-w-2xl text-sm leading-6 text-on-surface-variant">{{ $pageLead }}</p>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('reports.system') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                            <span class="material-symbols-outlined text-[20px]">description</span>
                            Open System Reports
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-secondary transition hover:bg-surface-container-high">
                            <span class="material-symbols-outlined text-[20px]">group</span>
                            Manage Users
                        </a>
                        <a href="{{ route('reports.system.print', request()->query()) }}" target="_blank" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-secondary transition hover:bg-surface-container-high">
                            <span class="material-symbols-outlined text-[20px]">picture_as_pdf</span>
                            PDF Preview
                        </a>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl border border-outline-variant bg-white/80 p-4 shadow-sm backdrop-blur">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Current Week</p>
                        <p class="mt-2 text-lg font-bold text-on-surface">{{ $weekLabel }}</p>
                        <p class="mt-2 text-sm text-on-surface-variant">Snapshot data real-time dari semua user yang submit aktivitas.</p>
                    </div>
                    <div class="rounded-2xl border border-outline-variant bg-white/80 p-4 shadow-sm backdrop-blur">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Focus</p>
                        <p class="mt-2 text-lg font-bold text-on-surface">Weekly Control Center</p>
                        <p class="mt-2 text-sm text-on-surface-variant">Kelola report, user, dan blocker dari satu halaman.</p>
                    </div>
                    <div class="rounded-2xl border border-outline-variant bg-white/80 p-4 shadow-sm backdrop-blur sm:col-span-2">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Key Insight</p>
                        <ul class="mt-3 space-y-2 text-sm text-on-surface-variant">
                            @forelse ($insights as $insight)
                                <li class="rounded-xl border border-outline-variant bg-surface px-4 py-3">{{ $insight }}</li>
                            @empty
                                <li class="rounded-xl border border-outline-variant bg-surface px-4 py-3">Belum ada insight untuk periode ini.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($metrics as $metric)
                <x-stat-card
                    :label="$metric['label']"
                    :value="$metric['value']"
                    :hint="$metric['note']"
                    :icon="$metric['icon']"
                    :tone="$metric['tone']"
                />
            @endforeach
        </section>

        <section class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
            <article class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Weekly Trend</p>
                        <h3 class="mt-1 text-xl font-bold text-on-surface">Aktivitas Harian Minggu Ini</h3>
                    </div>
                    <span class="rounded-full bg-surface-container px-3 py-1 text-xs font-semibold text-primary">Live</span>
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
            </article>

            <aside class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Top Contributors</p>
                        <h3 class="mt-1 text-xl font-bold text-on-surface">User paling aktif</h3>
                    </div>
                    <span class="material-symbols-outlined text-primary">leaderboard</span>
                </div>

                <div class="mt-5 space-y-4">
                    @forelse ($teamPerformance as $team)
                        <div class="rounded-2xl border border-outline-variant bg-surface-container-low p-4">
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary/10 text-sm font-bold text-primary">
                                    {{ $team['initials'] }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate font-semibold text-on-surface">{{ $team['name'] }}</p>
                                    <p class="text-sm text-on-surface-variant">{{ ucfirst($team['role']) }} · {{ $team['total'] }} aktivitas</p>
                                </div>
                                <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-primary ring-1 ring-outline-variant">{{ $team['rate'] }}%</span>
                            </div>

                            <div class="mt-4 grid grid-cols-3 gap-2 text-center text-xs">
                                <div class="rounded-xl border border-outline-variant bg-white px-3 py-2">
                                    <p class="text-secondary">Selesai</p>
                                    <p class="mt-1 font-bold text-on-surface">{{ $team['completed'] }}</p>
                                </div>
                                <div class="rounded-xl border border-outline-variant bg-white px-3 py-2">
                                    <p class="text-secondary">Progress</p>
                                    <p class="mt-1 font-bold text-on-surface">{{ $team['progress'] }}</p>
                                </div>
                                <div class="rounded-xl border border-outline-variant bg-white px-3 py-2">
                                    <p class="text-secondary">Kendala</p>
                                    <p class="mt-1 font-bold text-on-surface">{{ $team['kendala'] }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-outline-variant bg-surface-container-low p-5 text-sm text-on-surface-variant">
                            Belum ada user aktif pada minggu ini.
                        </div>
                    @endforelse
                </div>
            </aside>
        </section>

        <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Latest Admin Activity</p>
                    <h3 class="mt-1 text-xl font-bold text-on-surface">Aktivitas Tim Terkini</h3>
                </div>
                <a href="{{ route('reports.system') }}" class="text-sm font-semibold text-primary hover:underline">Open system reports</a>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-0">
                    <thead>
                        <tr class="text-left text-xs uppercase tracking-[0.18em] text-secondary">
                            <th class="border-b border-outline-variant px-4 py-3">User</th>
                            <th class="border-b border-outline-variant px-4 py-3">Role</th>
                            <th class="border-b border-outline-variant px-4 py-3">Aktivitas</th>
                            <th class="border-b border-outline-variant px-4 py-3">Status</th>
                            <th class="border-b border-outline-variant px-4 py-3">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        @forelse ($recentActivities as $activity)
                            <tr class="align-top hover:bg-surface-container transition-colors">
                                <td class="px-4 py-4 text-sm font-medium text-on-surface">{{ $activity['user'] }}</td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant">{{ ucfirst($activity['role']) }}</td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $activity['aktivitas'] }}</td>
                                <td class="px-4 py-4"><x-status-badge :status="$activity['status']" /></td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $activity['tanggal']->translatedFormat('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-sm text-on-surface-variant">Belum ada aktivitas tercatat untuk minggu ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
