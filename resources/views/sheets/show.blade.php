@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <section class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-secondary">Monthly Sheets</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-on-surface">Live Spreadsheet View</h2>
                <p class="mt-2 max-w-2xl text-sm text-on-surface-variant">{{ $pageLead }}</p>
            </div>

            @if ($activeSheet)
                <span class="rounded-full bg-surface-container px-3 py-2 text-xs font-semibold text-primary">
                    {{ $activeSheet->month?->translatedFormat('F Y') }}
                </span>
            @endif
        </section>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <x-stat-card label="Rows" :value="$sheetData['row_count']" hint="Baris data yang terbaca" icon="table_rows" tone="primary" />
            <x-stat-card label="Columns" :value="$sheetData['column_count']" hint="Kolom dari header spreadsheet" icon="view_column" tone="success" />
            <x-stat-card label="Status" :value="$sheetData['ok'] ? 'LIVE' : 'ERROR'" hint="Status pembacaan source aktif" icon="cloud" tone="warning" />
            <x-stat-card label="Updated" :value="$sheetData['fetched_at'] ? $sheetData['fetched_at']->diffForHumans() : '-'" hint="Waktu terakhir data dibaca" icon="schedule" tone="neutral" />
        </section>

        @if ($sheetData['error'])
            <section class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800 shadow-sm">
                {{ $sheetData['error'] }}
            </section>
        @endif

        <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Spreadsheet Preview</p>
                    <h3 class="mt-1 text-xl font-bold text-on-surface">{{ $activeSheet?->title ?? 'No active sheet' }}</h3>
                </div>
                @if ($activeSheet)
                    <a href="{{ $activeSheet->sheet_url }}" target="_blank" class="text-sm font-semibold text-primary hover:underline">Open original</a>
                @endif
            </div>

            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-0">
                    <thead>
                        <tr class="text-left text-xs uppercase tracking-[0.18em] text-secondary">
                            @forelse ($sheetData['headers'] as $header)
                                <th class="border-b border-outline-variant px-4 py-3">{{ $header }}</th>
                            @empty
                                <th class="border-b border-outline-variant px-4 py-3">No data</th>
                            @endforelse
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        @forelse ($sheetData['rows'] as $row)
                            <tr class="align-top hover:bg-surface-container transition-colors">
                                @foreach ($sheetData['headers'] as $header)
                                    <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $row[$header] ?? '-' }}</td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ max(1, count($sheetData['headers'])) }}" class="px-4 py-6 text-sm text-on-surface-variant">
                                    Belum ada data aktif untuk ditampilkan.
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
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Archive</p>
                    <h3 class="mt-1 text-xl font-bold text-on-surface">Sheet Bulanan</h3>
                </div>
                <span class="rounded-full bg-surface-container px-3 py-1 text-xs font-semibold text-primary">{{ $archive->count() }} saved</span>
            </div>

            <div class="mt-5 grid gap-3 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($archive as $sheet)
                    <div class="rounded-2xl border border-outline-variant bg-surface-container-low p-4">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="font-semibold text-on-surface">{{ $sheet->title }}</p>
                                <p class="mt-1 text-sm text-on-surface-variant">{{ $sheet->month?->translatedFormat('F Y') }}</p>
                            </div>
                            <x-status-badge :status="$sheet->is_active ? 'active' : 'pending'" />
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-outline-variant bg-surface-container-low p-5 text-sm text-on-surface-variant">
                        Belum ada arsip sheet yang tersimpan.
                    </div>
                @endforelse
            </div>
        </section>
    </div>
@endsection
