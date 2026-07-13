@extends('layouts.app')

@section('content')
    @php
        $meta = $overtime->captureMetadata;
    @endphp

    <div class="space-y-6">
        <section class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-secondary">Management</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-on-surface">Review Lembur</h2>
                <p class="mt-2 text-sm text-on-surface-variant">{{ $overtime->user->name }} · {{ $overtime->tanggal->format('d F Y') }}</p>
            </div>

            <a href="{{ route('admin.overtime.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-on-surface transition hover:bg-surface-container">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                Kembali
            </a>
        </section>

        @if (session('error'))
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
            <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm space-y-4">
                <h3 class="text-lg font-semibold text-on-surface">Detail Lembur</h3>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">User</p>
                        <p class="mt-1 text-sm text-on-surface">{{ $overtime->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Email</p>
                        <p class="mt-1 text-sm text-on-surface">{{ $overtime->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Jam</p>
                        <p class="mt-1 text-sm text-on-surface">
                            {{ \Illuminate\Support\Str::of($overtime->jam_mulai)->substr(0, 5) }}
                            –
                            {{ \Illuminate\Support\Str::of($overtime->jam_selesai)->substr(0, 5) }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Durasi</p>
                        <p class="mt-1 text-sm font-semibold text-primary">{{ $overtime->formattedDuration() }}</p>
                    </div>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Alasan</p>
                    <p class="mt-1 text-sm text-on-surface whitespace-pre-line">{{ $overtime->alasan }}</p>
                </div>
            </section>

            <section class="space-y-4">
                <div class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm space-y-3">
                    <h3 class="text-lg font-semibold text-on-surface">Metadata Bukti</h3>

                    @if ($meta)
                        <div class="rounded-xl bg-surface-container p-4 space-y-2 font-mono text-xs break-all">
                            <div><span class="text-on-surface-variant">Hash:</span> {{ $meta->image_hash }}</div>
                            <div><span class="text-on-surface-variant">Resolusi:</span> {{ $meta->image_width }}×{{ $meta->image_height }}</div>
                            <div><span class="text-on-surface-variant">Ukuran:</span> {{ number_format($meta->file_size_bytes / 1024, 1) }} KB</div>
                            <div><span class="text-on-surface-variant">Kamera:</span> {{ $meta->camera_facing }}</div>
                            <div><span class="text-on-surface-variant">Lokasi:</span>
                                @if ($meta->hasLocation())
                                    <a href="{{ $meta->mapsUrl() }}" target="_blank" class="text-primary hover:underline">{{ $meta->formattedLocation() }}</a>
                                @else
                                    Tidak tersedia
                                @endif
                            </div>
                            <div><span class="text-on-surface-variant">Capture:</span> {{ $meta->captured_at->format('d M Y H:i:s') }}</div>
                            <div><span class="text-on-surface-variant">IP:</span> {{ $meta->ip_address }}</div>
                        </div>
                    @else
                        <p class="text-sm text-rose-600">Metadata bukti tidak tersedia.</p>
                    @endif
                </div>

                @if ($overtime->status === 'submitted')
                    <div class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm space-y-4">
                        <h3 class="text-lg font-semibold text-on-surface">Aksi Review</h3>

                        <form action="{{ route('admin.overtime.approve', $overtime) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white transition hover:opacity-90">
                                <span class="material-symbols-outlined text-[20px]">check_circle</span>
                                Setujui Lembur
                            </button>
                        </form>

                        <form action="{{ route('admin.overtime.reject', $overtime) }}" method="POST" class="space-y-3">
                            @csrf
                            @method('PATCH')
                            <label class="block space-y-2">
                                <span class="text-sm font-semibold text-on-surface">Alasan Penolakan</span>
                                <textarea name="rejection_reason" rows="3" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" placeholder="Jelaskan alasan penolakan..." required></textarea>
                            </label>
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-rose-600 px-4 py-3 text-sm font-semibold text-white transition hover:opacity-90">
                                <span class="material-symbols-outlined text-[20px]">cancel</span>
                                Tolak Lembur
                            </button>
                        </form>
                    </div>
                @else
                    <div class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                        @php
                            $statusClass = match ($overtime->status) {
                                'approved' => 'bg-emerald-100 text-emerald-800',
                                default => 'bg-rose-100 text-rose-800',
                            };
                            $statusLabel = $overtime->status === 'approved' ? 'Sudah Disetujui' : 'Sudah Ditolak';
                        @endphp
                        <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ $statusClass }}">{{ $statusLabel }}</span>
                        @if ($overtime->rejection_reason)
                            <p class="mt-3 text-sm text-rose-800">{{ $overtime->rejection_reason }}</p>
                        @endif
                        @if ($overtime->reviewer)
                            <p class="mt-2 text-xs text-on-surface-variant">Oleh {{ $overtime->reviewer->name }} · {{ $overtime->reviewed_at?->format('d M Y H:i') }}</p>
                        @endif
                    </div>
                @endif
            </section>
        </div>
    </div>
@endsection
