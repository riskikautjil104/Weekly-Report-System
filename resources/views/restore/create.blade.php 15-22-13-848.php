@extends('layouts.app')

@section('content')
    @php
        $isEditing = isset($editingActivity) && $editingActivity;
        $formAction = $isEditing ? route('activities.update', $editingActivity) : route('activities.store');
        $formTitle = $isEditing ? 'Edit Aktivitas Harian' : 'Input Aktivitas Harian';
        $submitLabel = $isEditing ? 'Update Aktivitas' : 'Simpan Aktivitas';
        $selectedDate = old('tanggal', $isEditing ? $editingActivity->tanggal?->toDateString() : $defaultDate);
        $selectedStatus = old('status', $isEditing ? $editingActivity->status : 'progress');
        $selectedActivity = old('aktivitas', $isEditing ? $editingActivity->aktivitas : '');
        $selectedKeterangan = old('keterangan', $isEditing ? $editingActivity->keterangan : '');
    @endphp

    <div class="space-y-6">
        <section class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-secondary">Daily Input</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-on-surface">{{ $formTitle }}</h2>
                <p class="mt-2 max-w-2xl text-sm text-on-surface-variant">{{ $pageLead }}</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('activities.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-on-surface transition hover:bg-surface-container">
                    <span class="material-symbols-outlined text-[20px]">list</span>
                    Activity List
                </a>

                @if ($isEditing)
                    <a href="{{ route('activities.create') }}" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-on-surface transition hover:bg-surface-container">
                        <span class="material-symbols-outlined text-[20px]">add</span>
                        New Entry
                    </a>
                @endif
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

        @if ($errors->any())
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                Please fix the highlighted fields below.
            </div>
        @endif

        <div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
            <section>
                <form action="{{ $formAction }}" method="POST" class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                    @csrf
                    @if ($isEditing)
                        @method('PUT')
                    @endif

                    <div class="grid gap-5 md:grid-cols-2">
                        <label class="space-y-2">
                            <span class="text-sm font-semibold text-on-surface">Tanggal <span class="text-error">*</span></span>
                            <input type="date" name="tanggal" value="{{ $selectedDate }}" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" required>
                            @error('tanggal')
                                <p class="text-sm text-error">{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="space-y-2">
                            <span class="text-sm font-semibold text-on-surface">Status <span class="text-error">*</span></span>
                            <select name="status" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" required>
                                <option value="">Pilih status</option>
                                <option value="selesai" @selected($selectedStatus === 'selesai')>Selesai</option>
                                <option value="progress" @selected($selectedStatus === 'progress')>Progress</option>
                                <option value="kendala" @selected($selectedStatus === 'kendala')>Kendala</option>
                            </select>
                            @error('status')
                                <p class="text-sm text-error">{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="space-y-2 md:col-span-2">
                            <span class="text-sm font-semibold text-on-surface">Aktivitas <span class="text-error">*</span></span>
                            <textarea name="aktivitas" rows="4" placeholder="Jelaskan aktivitas yang dilakukan..." class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" required>{{ $selectedActivity }}</textarea>
                            @error('aktivitas')
                                <p class="text-sm text-error">{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="space-y-2 md:col-span-2">
                            <span class="text-sm font-semibold text-on-surface">Keterangan (Opsional)</span>
                            <textarea name="keterangan" rows="3" placeholder="Catatan tambahan atau detail kendala..." class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">{{ $selectedKeterangan }}</textarea>
                            @error('keterangan')
                                <p class="text-sm text-error">{{ $message }}</p>
                            @enderror
                        </label>
                    </div>

                    <div class="mt-6 flex flex-wrap items-center justify-end gap-3">
                        @if ($isEditing)
                            <a href="{{ route('activities.create') }}" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant px-4 py-3 text-sm font-semibold text-on-surface transition hover:bg-surface-container">
                                <span class="material-symbols-outlined text-[20px]">close</span>
                                Cancel Edit
                            </a>
                        @endif

                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                            <span class="material-symbols-outlined text-[20px]">save</span>
                            {{ $submitLabel }}
                        </button>
                    </div>
                </form>
            </section>

            <aside class="space-y-6">
                <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Draft Preview</p>
                            <h3 class="mt-1 text-xl font-bold text-on-surface">Aktivitas Tersimpan Sementara</h3>
                        </div>
                        <span class="material-symbols-outlined text-primary">draft</span>
                    </div>

                    <div class="mt-5 space-y-3">
                        @forelse ($drafts as $draft)
                            <div class="rounded-xl border border-outline-variant bg-surface-container-low p-4">
                                <div class="flex flex-wrap items-center justify-between gap-3">
                                    <p class="text-sm font-semibold text-on-surface">{{ $draft['aktivitas'] }}</p>
                                    <x-status-badge :status="$draft['status']" />
                                </div>
                                <p class="mt-2 text-xs uppercase tracking-[0.18em] text-secondary">{{ $draft['time'] }}</p>
                            </div>
                        @empty
                            <div class="rounded-xl border border-outline-variant bg-surface-container-low p-4 text-sm text-on-surface-variant">
                                Belum ada aktivitas dalam draft.
                            </div>
                        @endforelse
                    </div>
                </section>

                <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Input Rules</p>
                    <ul class="mt-4 space-y-3 text-sm text-on-surface-variant">
                        <li class="rounded-xl border border-outline-variant bg-surface-container-low px-4 py-3">Tanggal, aktivitas, dan status wajib diisi.</li>
                        <li class="rounded-xl border border-outline-variant bg-surface-container-low px-4 py-3">Satu user bisa kirim banyak aktivitas dalam satu hari.</li>
                        <li class="rounded-xl border border-outline-variant bg-surface-container-low px-4 py-3">Status hanya boleh: selesai, progress, atau kendala.</li>
                    </ul>
                </section>
            </aside>
        </div>

        <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">My Activities</p>
                    <h3 class="mt-1 text-xl font-bold text-on-surface">Daftar Aktivitas</h3>
                </div>
                <span class="rounded-full bg-surface-container px-3 py-1 text-xs font-semibold text-primary">{{ count($activities) }} items</span>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-0">
                    <thead>
                        <tr class="text-left text-xs uppercase tracking-[0.18em] text-secondary">
                            <th class="border-b border-outline-variant px-4 py-3">Tanggal</th>
                            @if (auth()->user()->role === 'admin')
                                <th class="border-b border-outline-variant px-4 py-3">User</th>
                            @endif
                            <th class="border-b border-outline-variant px-4 py-3">Aktivitas</th>
                            <th class="border-b border-outline-variant px-4 py-3">Status</th>
                            <th class="border-b border-outline-variant px-4 py-3">Keterangan</th>
                            <th class="border-b border-outline-variant px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        @forelse ($activities as $activity)
                            <tr class="align-top hover:bg-surface-container transition-colors">
                                <td class="px-4 py-4 text-sm font-medium text-on-surface">{{ $activity->tanggal?->translatedFormat('d M Y') }}</td>
                                @if (auth()->user()->role === 'admin')
                                    <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $activity->user?->name ?? '-' }}</td>
                                @endif
                                <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $activity->aktivitas }}</td>
                                <td class="px-4 py-4"><x-status-badge :status="$activity->status" /></td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $activity->keterangan ?: '-' }}</td>
                                <td class="px-4 py-4 text-right">
                                    <div class="inline-flex items-center justify-end gap-2">
                                        <a href="{{ route('activities.edit', $activity) }}" class="rounded-lg p-1.5 text-outline transition-colors hover:bg-primary-fixed hover:text-primary" aria-label="Edit activity">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </a>

                                        <form method="POST" action="{{ route('activities.destroy', $activity) }}" onsubmit="return confirm('Hapus aktivitas ini?')" class="m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg p-1.5 text-outline transition-colors hover:bg-error-container hover:text-error" aria-label="Delete activity">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->role === 'admin' ? 6 : 5 }}" class="px-4 py-6 text-sm text-on-surface-variant">
                                    Belum ada aktivitas tersimpan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
