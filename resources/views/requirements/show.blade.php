@extends('layouts.app')

@section('content')
@php
    $r = $requirement;

    $affectedMenuItems = ['Pendaftaran','Rawat Jalan','Rawat Inap','Farmasi','Logistik','Radiologi','Laboratorium','Kasir','Laporan','Lainnya'];
    $dataImpactItems   = ['Stok Barang','Data Pasien','Laporan','Billing','Integrasi BPJS','Integrasi SATUSEHAT','Tidak Ada'];
    $lampiranItems     = ['Screenshot','Mockup','Coretan Manual','Referensi Sistem Lain'];
    $risikoItems       = ['Data','Stok','Laporan','Integrasi Sistem','Proses Operasional'];

    $renderChecklist = function (?string $value, array $items, string $label = 'Keterangan') {
        $value = (string) $value;
        $checked = [];
        foreach ($items as $item) {
            $checked[$item] = str_contains($value, "[x] {$item}");
        }
        $note = '';
        if (preg_match('/' . preg_quote($label, '/') . ':\s*(.*)/s', $value, $m)) {
            $note = trim($m[1]);
        }
        return [$checked, $note];
    };

    [$affectedMenuChecked, $affectedMenuNote] = $renderChecklist($r->affected_menu, $affectedMenuItems);
    [$dataImpactChecked, $dataImpactNote]     = $renderChecklist($r->impact_analysis, $dataImpactItems);
    [$lampiranChecked, $lampiranNote]         = $renderChecklist($r->uiux_notes, $lampiranItems);
    [$risikoChecked, $risikoNote]             = $renderChecklist($r->potential_risk, $risikoItems, 'Catatan');

    $statusColors = [
        'draft' => 'bg-gray-200 text-gray-700',
        'submitted' => 'bg-blue-100 text-blue-700',
        'need_clarification' => 'bg-yellow-100 text-yellow-700',
        'approved' => 'bg-green-100 text-green-700',
        'rejected' => 'bg-red-100 text-red-700',
    ];
@endphp

<div class="flex flex-col gap-4">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">{{ $r->title }}</h1>
            <p class="text-sm text-on-surface-variant mt-1">
                Diajukan oleh {{ $r->user?->name ?? '-' }} &middot; {{ $r->created_at->format('d M Y H:i') }}
            </p>
        </div>

        <div class="flex items-center gap-2">
            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$r->status] ?? 'bg-gray-100 text-gray-700' }}">
                {{ ucfirst(str_replace('_',' ', $r->status)) }}
            </span>

            <a href="{{ route('requirements.edit', $r) }}" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                <span class="material-symbols-outlined text-[18px]">edit</span>
                Edit
            </a>

            <a href="{{ route('requirements.print', $r) }}" target="_blank" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-2 text-sm font-semibold text-secondary shadow-sm transition hover:bg-surface-container-high">
                <span class="material-symbols-outlined text-[18px]">print</span>
                Print
            </a>

            <a href="{{ route('requirements.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-2 text-sm font-semibold text-secondary shadow-sm transition hover:bg-surface-container-high">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    {{-- Informasi Request --}}
    <div class="rounded-2xl border border-outline-variant bg-white p-6">
        <h2 class="text-lg font-bold mb-4">Informasi Request</h2>
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div><dt class="text-on-surface-variant">Nomor Request</dt><dd class="font-medium">{{ $r->request_number ?: '-' }}</dd></div>
            <div><dt class="text-on-surface-variant">Tanggal Request</dt><dd class="font-medium">{{ optional($r->request_date)->format('d M Y') ?: '-' }}</dd></div>
            <div><dt class="text-on-surface-variant">Nama Unit/Bagian</dt><dd class="font-medium">{{ $r->department ?: '-' }}</dd></div>
            <div><dt class="text-on-surface-variant">Nama Pengusul</dt><dd class="font-medium">{{ $r->user?->name ?? '-' }}</dd></div>
            <div><dt class="text-on-surface-variant">Jabatan</dt><dd class="font-medium">{{ $r->requester_title ?: '-' }}</dd></div>
            <div><dt class="text-on-surface-variant">Nomor Kontak</dt><dd class="font-medium">{{ $r->contact_number ?: '-' }}</dd></div>
        </dl>
    </div>

    {{-- 1. Nama Fitur --}}
    <div class="rounded-2xl border border-outline-variant bg-white p-6">
        <h2 class="text-lg font-bold mb-2">1. Nama Fitur / Perubahan</h2>
        <p class="text-sm"><span class="text-on-surface-variant">Kategori:</span> {{ ucfirst(str_replace('_',' ',$r->category)) }}</p>
    </div>

    {{-- 2. Latar Belakang --}}
    <div class="rounded-2xl border border-outline-variant bg-white p-6">
        <h2 class="text-lg font-bold mb-2">2. Latar Belakang Permasalahan</h2>
        <p class="text-sm whitespace-pre-line">{{ $r->body ?: '-' }}</p>
    </div>

    {{-- 3. Alur Saat Ini --}}
    <div class="rounded-2xl border border-outline-variant bg-white p-6">
        <h2 class="text-lg font-bold mb-2">3. Alur Sistem Saat Ini</h2>
        <p class="text-sm whitespace-pre-line">{{ $r->current_workflow ?: '-' }}</p>
    </div>

    {{-- 4. Alur Diinginkan --}}
    <div class="rounded-2xl border border-outline-variant bg-white p-6">
        <h2 class="text-lg font-bold mb-2">4. Alur Sistem Yang Diinginkan</h2>
        <p class="text-sm whitespace-pre-line mb-3">{{ $r->expected_workflow ?: '-' }}</p>

        @if($r->business_goal)
            <p class="text-sm font-semibold mt-2">Tujuan Bisnis</p>
            <p class="text-sm whitespace-pre-line">{{ $r->business_goal }}</p>
        @endif

        @if($r->expected_benefits)
            <p class="text-sm font-semibold mt-2">Manfaat yang Diharapkan</p>
            <p class="text-sm whitespace-pre-line">{{ $r->expected_benefits }}</p>
        @endif
    </div>

    {{-- 5. Halaman/Menu Terdampak --}}
    <div class="rounded-2xl border border-outline-variant bg-white p-6">
        <h2 class="text-lg font-bold mb-3">5. Halaman/Menu Yang Terdampak</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2 text-sm">
            @foreach($affectedMenuItems as $item)
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] {{ $affectedMenuChecked[$item] ? 'text-primary' : 'text-outline-variant' }}">
                        {{ $affectedMenuChecked[$item] ? 'check_box' : 'check_box_outline_blank' }}
                    </span>
                    {{ $item }}
                </div>
            @endforeach
        </div>
        @if($affectedMenuNote)
            <p class="text-sm mt-3 whitespace-pre-line"><span class="text-on-surface-variant">Keterangan:</span> {{ $affectedMenuNote }}</p>
        @endif
    </div>

    {{-- 6. Detail Perubahan --}}
    <div class="rounded-2xl border border-outline-variant bg-white p-6">
        <h2 class="text-lg font-bold mb-2">6. Detail Perubahan Yang Diinginkan</h2>
        <p class="text-sm whitespace-pre-line">{{ $r->field_changes ?: '-' }}</p>
    </div>

    {{-- 7. Dampak Terhadap Data --}}
    <div class="rounded-2xl border border-outline-variant bg-white p-6">
        <h2 class="text-lg font-bold mb-3">7. Dampak Terhadap Data</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 text-sm">
            @foreach($dataImpactItems as $item)
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] {{ $dataImpactChecked[$item] ? 'text-primary' : 'text-outline-variant' }}">
                        {{ $dataImpactChecked[$item] ? 'check_box' : 'check_box_outline_blank' }}
                    </span>
                    {{ $item }}
                </div>
            @endforeach
        </div>
        @if($dataImpactNote)
            <p class="text-sm mt-3 whitespace-pre-line"><span class="text-on-surface-variant">Keterangan:</span> {{ $dataImpactNote }}</p>
        @endif
    </div>

    {{-- 8. Aturan Bisnis --}}
    <div class="rounded-2xl border border-outline-variant bg-white p-6">
        <h2 class="text-lg font-bold mb-2">8. Aturan Bisnis (Business Rules)</h2>
        <p class="text-sm whitespace-pre-line">{{ $r->business_rules ?: '-' }}</p>

        @if($r->validation_rules)
            <p class="text-sm font-semibold mt-3">Validasi Tambahan</p>
            <p class="text-sm whitespace-pre-line">{{ $r->validation_rules }}</p>
        @endif
    </div>

    {{-- 9. Contoh Tampilan --}}
    <div class="rounded-2xl border border-outline-variant bg-white p-6">
        <h2 class="text-lg font-bold mb-3">9. Contoh Tampilan Yang Diinginkan</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-sm">
            @foreach($lampiranItems as $item)
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] {{ $lampiranChecked[$item] ? 'text-primary' : 'text-outline-variant' }}">
                        {{ $lampiranChecked[$item] ? 'check_box' : 'check_box_outline_blank' }}
                    </span>
                    {{ $item }}
                </div>
            @endforeach
        </div>
        @if($lampiranNote)
            <p class="text-sm mt-3 whitespace-pre-line"><span class="text-on-surface-variant">Keterangan:</span> {{ $lampiranNote }}</p>
        @endif
    </div>

    {{-- 10. Risiko --}}
    <div class="rounded-2xl border border-outline-variant bg-white p-6">
        <h2 class="text-lg font-bold mb-3">10. Risiko Yang Dipahami Oleh Pengguna</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 text-sm">
            @foreach($risikoItems as $item)
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] {{ $risikoChecked[$item] ? 'text-primary' : 'text-outline-variant' }}">
                        {{ $risikoChecked[$item] ? 'check_box' : 'check_box_outline_blank' }}
                    </span>
                    {{ $item }}
                </div>
            @endforeach
        </div>
        @if($risikoNote)
            <p class="text-sm mt-3 whitespace-pre-line"><span class="text-on-surface-variant">Catatan:</span> {{ $risikoNote }}</p>
        @endif
    </div>

    {{-- 11. Prioritas --}}
    <div class="rounded-2xl border border-outline-variant bg-white p-6">
        <h2 class="text-lg font-bold mb-2">11. Prioritas Pengerjaan</h2>
        <p class="text-sm"><span class="font-semibold">{{ $r->priority ?: '-' }}</span></p>
        @if($r->priority_reason)
            <p class="text-sm mt-2 whitespace-pre-line"><span class="text-on-surface-variant">Alasan:</span> {{ $r->priority_reason }}</p>
        @endif
    </div>

    {{-- Diskusi / Komentar --}}
    <div class="rounded-2xl border border-outline-variant bg-white p-6">
        <h2 class="text-lg font-bold mb-4">Diskusi</h2>

        <div class="flex flex-col gap-3 mb-4">
            @forelse($r->comments as $comment)
                <div class="rounded-xl bg-surface-container-lowest border border-outline-variant p-3">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-semibold">{{ $comment->user?->name ?? 'Unknown' }}</span>
                        <span class="text-xs text-on-surface-variant">{{ $comment->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <p class="text-sm whitespace-pre-line">{{ $comment->body }}</p>
                </div>
            @empty
                <p class="text-sm text-on-surface-variant">Belum ada komentar.</p>
            @endforelse
        </div>

        <form method="POST" action="{{ route('requirements.comments.store', $r) }}">
            @csrf
            <textarea name="body" rows="3" placeholder="Tulis komentar..." class="w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 text-sm outline-none focus:border-primary" required></textarea>
            @error('body')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
            <button type="submit" class="mt-3 inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                <span class="material-symbols-outlined text-[18px]">send</span>
                Kirim Komentar
            </button>
        </form>
    </div>
</div>
@endsection