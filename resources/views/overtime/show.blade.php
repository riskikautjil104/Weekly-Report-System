@extends('layouts.app')

@section('content')
    @php
        $meta = $overtime->captureMetadata;
        $statusClass = match ($overtime->status) {
            'approved' => 'bg-emerald-100 text-emerald-800',
            'rejected' => 'bg-rose-100 text-rose-800',
            default => 'bg-amber-100 text-amber-800',
        };
        $statusLabel = match ($overtime->status) {
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => 'Menunggu Persetujuan',
        };
    @endphp

    <div class="space-y-6">
        <section class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-secondary">Overtime</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-on-surface">Detail Lembur</h2>
                <p class="mt-2 text-sm text-on-surface-variant">{{ $overtime->tanggal->format('d F Y') }}</p>
            </div>

            <a href="{{ route('overtime.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-on-surface transition hover:bg-surface-container">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                Kembali
            </a>
        </section>

        <div class="grid gap-6 lg:grid-cols-2">
            <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-on-surface">Informasi Lembur</h3>
                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClass }}">{{ $statusLabel }}</span>
                </div>

                @if ($isAdmin)
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">User</p>
                        <p class="mt-1 text-sm text-on-surface">{{ $overtime->user->name }}</p>
                    </div>
                @endif

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Jam Mulai</p>
                        <p class="mt-1 text-sm text-on-surface">{{ \Illuminate\Support\Str::of($overtime->jam_mulai)->substr(0, 5) }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Jam Selesai</p>
                        <p class="mt-1 text-sm text-on-surface">{{ \Illuminate\Support\Str::of($overtime->jam_selesai)->substr(0, 5) }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Durasi</p>
                        <p class="mt-1 text-sm font-semibold text-primary">{{ $overtime->formattedDuration() }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Dikirim</p>
                        <p class="mt-1 text-sm text-on-surface">{{ $overtime->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Alasan</p>
                    <p class="mt-1 text-sm text-on-surface whitespace-pre-line">{{ $overtime->alasan }}</p>
                </div>

                @if ($overtime->status === 'rejected' && $overtime->rejection_reason)
                    <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3">
                        <p class="text-xs font-semibold uppercase tracking-wider text-rose-800">Alasan Penolakan</p>
                        <p class="mt-1 text-sm text-rose-800">{{ $overtime->rejection_reason }}</p>
                    </div>
                @endif

                @if ($overtime->reviewer)
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Direview oleh</p>
                        <p class="mt-1 text-sm text-on-surface">{{ $overtime->reviewer->name }} · {{ $overtime->reviewed_at?->format('d M Y H:i') }}</p>
                    </div>
                @endif
            </section>

            <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm space-y-4">
                <h3 class="text-lg font-semibold text-on-surface">Metadata Bukti Foto</h3>

                @if ($meta)
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-2 text-emerald-700 font-semibold">
                            <span class="material-symbols-outlined text-[18px]">verified</span>
                            Bukti foto terverifikasi (metadata only)
                        </div>

                        <div class="rounded-xl bg-surface-container p-4 space-y-2 font-mono text-xs break-all">
                            <div><span class="text-on-surface-variant">Hash SHA256:</span> {{ $meta->image_hash }}</div>
                            <div><span class="text-on-surface-variant">Resolusi:</span> {{ $meta->image_width }} × {{ $meta->image_height }} px</div>
                            <div><span class="text-on-surface-variant">Ukuran:</span> {{ number_format($meta->file_size_bytes / 1024, 1) }} KB</div>
                            <div><span class="text-on-surface-variant">Kamera:</span> {{ $meta->camera_facing }}</div>
                            <div><span class="text-on-surface-variant">Lokasi:</span>
                                @if ($meta->hasLocation())
                                    <a href="{{ $meta->mapsUrl() }}" target="_blank" class="text-primary hover:underline">{{ $meta->formattedLocation() }}</a>
                                @else
                                    Tidak tersedia
                                @endif
                            </div>
                            <div><span class="text-on-surface-variant">Waktu capture:</span> {{ $meta->captured_at->format('d M Y H:i:s') }}</div>
                            <div><span class="text-on-surface-variant">IP:</span> {{ $meta->ip_address }}</div>
                        </div>

                        <details class="text-xs text-on-surface-variant">
                            <summary class="cursor-pointer font-semibold text-on-surface">Device info</summary>
                            <p class="mt-2 break-all">{{ $meta->device_user_agent }}</p>
                        </details>
                    </div>
                @else
                    <p class="text-sm text-on-surface-variant">Tidak ada metadata bukti.</p>
                @endif
            </section>
        </div>
    </div>
@endsection
