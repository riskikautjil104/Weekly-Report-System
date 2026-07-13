@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <section class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-secondary">Management</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-on-surface">Approval Lembur</h2>
                <p class="mt-2 text-sm text-on-surface-variant">Review, filter, dan export laporan lembur seluruh user.</p>
            </div>
        </section>

        @if (session('status'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800">
                {{ session('error') }}
            </div>
        @endif

        @include('partials.overtime-filters', [
            'action' => route('admin.overtime.index'),
            'filters' => $filters,
            'users' => $users,
            'showUserFilter' => true,
            'showExport' => true,
        ])

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
            <div class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Total</p>
                <p class="mt-1 text-2xl font-bold text-on-surface">{{ $stats['total'] }}</p>
            </div>
            <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-amber-800">Menunggu</p>
                <p class="mt-1 text-2xl font-bold text-amber-900">{{ $stats['submitted'] }}</p>
            </div>
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-emerald-800">Disetujui</p>
                <p class="mt-1 text-2xl font-bold text-emerald-900">{{ $stats['approved'] }}</p>
            </div>
            <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-rose-800">Ditolak</p>
                <p class="mt-1 text-2xl font-bold text-rose-900">{{ $stats['rejected'] }}</p>
            </div>
            <div class="rounded-2xl border border-primary/20 bg-primary/5 p-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-primary">Jam Disetujui</p>
                <p class="mt-1 text-2xl font-bold text-primary">{{ intdiv($stats['total_minutes'], 60) }}j {{ $stats['total_minutes'] % 60 }}m</p>
            </div>
        </div>

        <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-surface-container text-left text-xs font-semibold uppercase tracking-wider text-on-surface-variant">
                        <tr>
                            <th class="px-4 py-3">User</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Durasi</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Lokasi</th>
                            <th class="px-4 py-3">Bukti</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        @forelse ($overtimes as $overtime)
                            <tr class="hover:bg-surface-container-low transition">
                                <td class="px-4 py-3 font-medium text-on-surface">{{ $overtime->user->name }}</td>
                                <td class="px-4 py-3 text-on-surface">{{ $overtime->tanggal->format('d M Y') }}</td>
                                <td class="px-4 py-3 text-on-surface">{{ $overtime->formattedDuration() }}</td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusClass = match ($overtime->status) {
                                            'approved' => 'bg-emerald-100 text-emerald-800',
                                            'rejected' => 'bg-rose-100 text-rose-800',
                                            default => 'bg-amber-100 text-amber-800',
                                        };
                                        $statusLabel = match ($overtime->status) {
                                            'approved' => 'Disetujui',
                                            'rejected' => 'Ditolak',
                                            default => 'Menunggu',
                                        };
                                    @endphp
                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-xs text-on-surface-variant">
                                    @if ($overtime->captureMetadata?->hasLocation())
                                        <a href="{{ $overtime->captureMetadata->mapsUrl() }}" target="_blank" class="text-primary hover:underline">
                                            {{ $overtime->captureMetadata->formattedLocation() }}
                                        </a>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if ($overtime->captureMetadata)
                                        <span class="inline-flex items-center gap-1 text-xs text-emerald-700">
                                            <span class="material-symbols-outlined text-[16px]">verified</span>
                                            Ada
                                        </span>
                                    @else
                                        <span class="text-xs text-rose-600">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.overtime.show', $overtime) }}" class="text-sm font-semibold text-primary hover:underline">
                                        Review
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-on-surface-variant">
                                    Tidak ada laporan lembur untuk filter ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($overtimes->hasPages())
                <div class="border-t border-outline-variant px-4 py-3">
                    {{ $overtimes->links() }}
                </div>
            @endif
        </section>
    </div>
@endsection
