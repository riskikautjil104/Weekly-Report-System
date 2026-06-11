@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <section class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-secondary">Arsip</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-on-surface">Weekly Report Archive</h2>
                <p class="mt-2 max-w-2xl text-sm text-on-surface-variant">{{ $pageLead }}</p>
            </div>

            <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-secondary transition hover:bg-surface-container-high">
                <span class="material-symbols-outlined text-[20px]">description</span>
                Current Reports
            </a>
        </section>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <x-stat-card label="Archived" :value="$archives->count()" hint="Jumlah report yang sudah masuk arsip" icon="inventory_2" tone="primary" />
            <x-stat-card label="Scope" :value="$isAdmin ? 'All Users' : 'My Reports'" hint="Siapa yang bisa dilihat di halaman ini" icon="groups" tone="success" />
            <x-stat-card label="Format" :value="'PDF Print'" hint="Buka halaman print lalu simpan sebagai PDF" icon="picture_as_pdf" tone="warning" />
            <x-stat-card label="Status" :value="'AUTO'" hint="Arsip dibuat otomatis dari report yang lewat" icon="schedule" tone="neutral" />
        </section>

        <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
            <form method="GET" action="{{ route('archives.printRange') }}" class="mb-6 grid gap-4 md:grid-cols-3 xl:grid-cols-5">
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-on-surface" for="week_start">Week Start</label>
                    <input id="week_start" name="week_start" type="date" value="{{ request('week_start') }}" class="mt-2 w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" />
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-on-surface" for="week_end">Week End</label>
                    <input id="week_end" name="week_end" type="date" value="{{ request('week_end') }}" class="mt-2 w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" />
                </div>

                <div class="col-span-1 md:col-span-1 xl:col-span-1 flex items-end">
                    <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                        <span class="material-symbols-outlined text-[20px]">picture_as_pdf</span>
                        Print / PDF Range
                    </button>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-0">
                    <thead>
                        <tr class="text-left text-xs uppercase tracking-[0.18em] text-secondary">

                            @if ($isAdmin)
                                <th class="border-b border-outline-variant px-4 py-3">User</th>
                            @endif
                            <th class="border-b border-outline-variant px-4 py-3">Periode</th>
                            <th class="border-b border-outline-variant px-4 py-3">Total</th>
                            <th class="border-b border-outline-variant px-4 py-3">Selesai</th>
                            <th class="border-b border-outline-variant px-4 py-3">Progress</th>
                            <th class="border-b border-outline-variant px-4 py-3">Kendala</th>
                            <th class="border-b border-outline-variant px-4 py-3">Archived At</th>
                            <th class="border-b border-outline-variant px-4 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        @forelse ($archives as $archive)
                            <tr class="align-top hover:bg-surface-container transition-colors">
                                @if ($isAdmin)
                                    <td class="px-4 py-4 text-sm font-medium text-on-surface">{{ $archive->user?->name ?? '-' }}</td>
                                @endif
                                <td class="px-4 py-4 text-sm font-medium text-on-surface">
                                    {{ $archive->week_start?->translatedFormat('d M Y') }} - {{ $archive->week_end?->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $archive->summary_json['total_tasks'] ?? 0 }}</td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $archive->summary_json['selesai'] ?? 0 }}</td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $archive->summary_json['progress'] ?? 0 }}</td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $archive->summary_json['kendala'] ?? 0 }}</td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $archive->archived_at?->translatedFormat('d M Y H:i') }}</td>
                                <td class="px-4 py-4 text-right">
                                    <a href="{{ route('archives.print', $archive) }}" target="_blank" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                                        <span class="material-symbols-outlined text-[20px]">picture_as_pdf</span>
                                        Print / PDF
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $isAdmin ? 8 : 7 }}" class="px-4 py-6 text-sm text-on-surface-variant">
                                    Belum ada arsip weekly report.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
