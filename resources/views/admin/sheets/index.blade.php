@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <section class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-secondary">Admin Tools</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-on-surface">Sheet Manager</h2>
                <p class="mt-2 max-w-2xl text-sm text-on-surface-variant">{{ $pageLead }}</p>
            </div>

            <a href="{{ route('sheets.show') }}" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-secondary transition hover:bg-surface-container-high">
                <span class="material-symbols-outlined text-[20px]">visibility</span>
                View as User
            </a>
        </section>

        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                Please fix the highlighted fields below.
            </div>
        @endif

        <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
            <form method="POST" action="{{ route('admin.sheets.store') }}" class="grid gap-5 lg:grid-cols-2">
                @csrf

                <label class="space-y-2">
                    <span class="text-sm font-semibold text-on-surface">Month</span>
                    <input type="month" name="month" value="{{ old('month', now()->format('Y-m')) }}" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" required>
                    @error('month')<p class="text-sm text-error">{{ $message }}</p>@enderror
                </label>

                <label class="space-y-2">
                    <span class="text-sm font-semibold text-on-surface">Sheet Title</span>
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="Weekly Report June 2026" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" required>
                    @error('title')<p class="text-sm text-error">{{ $message }}</p>@enderror
                </label>

                <label class="space-y-2 lg:col-span-2">
                    <span class="text-sm font-semibold text-on-surface">Google Sheet URL</span>
                    <input type="url" name="sheet_url" value="{{ old('sheet_url') }}" placeholder="https://docs.google.com/spreadsheets/d/.../edit?gid=..." class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" required>
                    @error('sheet_url')<p class="text-sm text-error">{{ $message }}</p>@enderror
                </label>

                <label class="space-y-2">
                    <span class="text-sm font-semibold text-on-surface">GID <span class="text-xs text-secondary">(optional)</span></span>
                    <input type="text" name="sheet_gid" value="{{ old('sheet_gid') }}" placeholder="16849638" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                    @error('sheet_gid')<p class="text-sm text-error">{{ $message }}</p>@enderror
                </label>

                <label class="space-y-2">
                    <span class="text-sm font-semibold text-on-surface">Notes <span class="text-xs text-secondary">(optional)</span></span>
                    <input type="text" name="notes" value="{{ old('notes') }}" placeholder="Link untuk bulan berjalan" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                    @error('notes')<p class="text-sm text-error">{{ $message }}</p>@enderror
                </label>

                <label class="inline-flex items-center gap-3 lg:col-span-2">
                    <input type="checkbox" name="is_active" value="1" class="h-4 w-4 rounded border-outline-variant text-primary focus:ring-primary/20" @checked(old('is_active', true))>
                    <span class="text-sm font-semibold text-on-surface">Set as active sheet</span>
                </label>

                <div class="lg:col-span-2 flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                        <span class="material-symbols-outlined text-[20px]">save</span>
                        Save Sheet Link
                    </button>
                </div>
            </form>
        </section>

        <section class="grid gap-6 xl:grid-cols-[0.95fr_1.05fr]">
            <article class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Active Sheet</p>
                        <h3 class="mt-1 text-xl font-bold text-on-surface">Current source</h3>
                    </div>
                    <x-status-badge :status="$activeSheet ? 'active' : 'pending'" />
                </div>

                @if ($activeSheet)
                    <div class="mt-5 space-y-3 rounded-2xl border border-outline-variant bg-surface-container-low p-4 text-sm text-on-surface-variant">
                        <div><span class="font-semibold text-on-surface">Month:</span> {{ $activeSheet->month?->translatedFormat('F Y') }}</div>
                        <div><span class="font-semibold text-on-surface">Title:</span> {{ $activeSheet->title }}</div>
                        <div><span class="font-semibold text-on-surface">URL:</span> <a href="{{ $activeSheet->sheet_url }}" target="_blank" class="text-primary hover:underline">Open sheet</a></div>
                        @if ($activeSheet->notes)
                            <div><span class="font-semibold text-on-surface">Notes:</span> {{ $activeSheet->notes }}</div>
                        @endif
                    </div>
                @else
                    <div class="mt-5 rounded-2xl border border-dashed border-outline-variant bg-surface-container-low p-5 text-sm text-on-surface-variant">
                        Belum ada sheet aktif. Tambahkan link bulan baru di form atas.
                    </div>
                @endif

                <div class="mt-6 rounded-2xl border border-outline-variant bg-surface-container-low p-4">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Spreadsheet Preview</p>
                            <h4 class="mt-1 text-base font-bold text-on-surface">Active sheet data</h4>
                        </div>
                        <span class="rounded-full bg-surface-container px-3 py-1 text-xs font-semibold text-primary">{{ $sheetData['ok'] ? 'LIVE' : 'ERROR' }}</span>
                    </div>

                    @if ($sheetData['error'])
                        <p class="mt-3 text-sm text-rose-700">{{ $sheetData['error'] }}</p>
                    @else
                        <div class="mt-4 overflow-x-auto">
                            <table class="min-w-full border-separate border-spacing-0">
                                <thead>
                                    <tr class="text-left text-xs uppercase tracking-[0.18em] text-secondary">
                                        @forelse ($sheetData['headers'] as $header)
                                            <th class="border-b border-outline-variant px-3 py-2">{{ $header }}</th>
                                        @empty
                                            <th class="border-b border-outline-variant px-3 py-2">No data</th>
                                        @endforelse
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-outline-variant">
                                    @forelse ($sheetData['rows'] as $row)
                                        <tr>
                                            @foreach ($sheetData['headers'] as $header)
                                                <td class="px-3 py-2 text-sm text-on-surface-variant">{{ $row[$header] ?? '-' }}</td>
                                            @endforeach
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="{{ max(1, count($sheetData['headers'])) }}" class="px-3 py-4 text-sm text-on-surface-variant">
                                                Tidak ada baris data untuk ditampilkan.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </article>

            <article class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Saved Sheets</p>
                        <h3 class="mt-1 text-xl font-bold text-on-surface">Riwayat link bulanan</h3>
                    </div>
                    <span class="rounded-full bg-surface-container px-3 py-1 text-xs font-semibold text-primary">{{ $sheets->count() }} items</span>
                </div>

                <div class="mt-5 space-y-3">
                    @forelse ($sheets as $sheet)
                        <div class="rounded-2xl border border-outline-variant bg-surface-container-low p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="font-semibold text-on-surface">{{ $sheet->title }}</p>
                                    <p class="mt-1 text-sm text-on-surface-variant">{{ $sheet->month?->translatedFormat('F Y') }}</p>
                                </div>
                                <x-status-badge :status="$sheet->is_active ? 'active' : 'pending'" />
                            </div>

                            <div class="mt-3 flex flex-wrap gap-2">
                                @unless ($sheet->is_active)
                                    <form method="POST" action="{{ route('admin.sheets.activate', $sheet) }}" class="m-0">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-primary px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:opacity-90">
                                            <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                            Set Active
                                        </button>
                                    </form>
                                @endunless

                                <form method="POST" action="{{ route('admin.sheets.destroy', $sheet) }}" onsubmit="return confirm('Hapus sheet ini?')" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-2 rounded-xl border border-rose-200 bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-100">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-outline-variant bg-surface-container-low p-5 text-sm text-on-surface-variant">
                            Belum ada sheet yang tersimpan.
                        </div>
                    @endforelse
                </div>
            </article>
        </section>
    </div>
@endsection
