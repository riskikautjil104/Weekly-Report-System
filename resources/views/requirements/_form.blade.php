@php
    /** @var \App\Models\Requirement|null $requirement */
    $r = $requirement ?? null;
    $val = fn (string $field, $default = '') => old($field, $r?->{$field} ?? $default);

    $affectedMenuItems = ['Pendaftaran','Rawat Jalan','Rawat Inap','Farmasi','Logistik','Radiologi','Laboratorium','Kasir','Laporan','Lainnya'];
    $dataImpactItems   = ['Stok Barang','Data Pasien','Laporan','Billing','Integrasi BPJS','Integrasi SATUSEHAT','Tidak Ada'];
    $lampiranItems     = ['Screenshot','Mockup','Coretan Manual','Referensi Sistem Lain'];
    $risikoItems       = ['Data','Stok','Laporan','Integrasi Sistem','Proses Operasional'];
    $priorityOptions   = ['Tinggi (Urgent)','Sedang','Rendah'];

    $parseChecklist = function (?string $value, array $items, string $label = 'Keterangan') {
        $value = (string) $value;
        $checked = [];
        foreach ($items as $item) {
            if (str_contains($value, "[x] {$item}")) {
                $checked[] = $item;
            }
        }
        $note = '';
        if (preg_match('/' . preg_quote($label, '/') . ':\s*(.*)/s', $value, $m)) {
            $note = trim($m[1]);
        }
        return [$checked, $note];
    };

    $checklistState = function (string $itemsField, string $noteField, ?string $rawValue, array $items, string $label = 'Keterangan') use ($parseChecklist) {
        if (old($itemsField) !== null || old($noteField) !== null) {
            return [old($itemsField, []), old($noteField, '')];
        }
        return $parseChecklist($rawValue, $items, $label);
    };

    [$affectedMenuChecked, $affectedMenuNote] = $checklistState('affected_menu_items', 'affected_menu_keterangan', $r?->affected_menu, $affectedMenuItems);
    [$dataImpactChecked, $dataImpactNote]     = $checklistState('impact_analysis_items', 'impact_analysis_keterangan', $r?->impact_analysis, $dataImpactItems);
    [$lampiranChecked, $lampiranNote]         = $checklistState('uiux_notes_items', 'uiux_notes_keterangan', $r?->uiux_notes, $lampiranItems);
    [$risikoChecked, $risikoNote]             = $checklistState('potential_risk_items', 'potential_risk_keterangan', $r?->potential_risk, $risikoItems, 'Catatan');
@endphp

{{-- ============================================================ --}}
{{-- INFORMASI REQUEST --}}
{{-- ============================================================ --}}
<div class="rounded-2xl border border-outline-variant bg-white p-6">
    <h2 class="text-lg font-bold mb-4">Informasi Request</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <p>Nomor Request (opsional)</p>
            <x-input-label value="Nomor Request (opsional)" />
            <input name="request_number" value="{{ $val('request_number') }}" class="mt-2 w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 text-sm outline-none focus:border-primary" />
        </div>

        <div>
            <p>Tanggal Request</p>
            <x-input-label value="Tanggal Request" />
            <input type="date" name="request_date" value="{{ old('request_date', optional($r?->request_date)->format('Y-m-d')) }}" class="mt-2 w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 text-sm outline-none focus:border-primary" />
        </div>

        <div>
            <p>Nama Unit/Bagian</p>
            <x-input-label value="Nama Unit/Bagian" />
            <input name="department" value="{{ $val('department') }}" class="mt-2 w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 text-sm outline-none focus:border-primary" />
        </div>

        <div>
            <p>Nama Pengusul</p>
            <x-input-label value="Nama Pengusul" />
            <input value="{{ auth()->user()?->name }}" disabled class="mt-2 w-full cursor-not-allowed rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 text-sm outline-none" />
        </div>

        <div>
            <p>Jabatan</p>
            <x-input-label value="Jabatan" />
            <input name="requester_title" value="{{ $val('requester_title') }}" class="mt-2 w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 text-sm outline-none focus:border-primary" />
        </div>

        <div>
            <p>Nomor Kontrak</p>
            <x-input-label value="Nomor Kontak" />
            <input name="contact_number" value="{{ $val('contact_number') }}" class="mt-2 w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 text-sm outline-none focus:border-primary" />
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- 1. NAMA FITUR / PERUBAHAN --}}
{{-- ============================================================ --}}
<div class="mt-6 rounded-2xl border border-outline-variant bg-white p-6">
    <div class="flex items-center gap-2 mb-4">
        <span class="material-symbols-outlined text-[20px]">looks_one</span>
        <h2 class="text-lg font-bold">1. Nama Fitur / Perubahan</h2>
    </div>
    <p class="text-sm text-on-surface-variant mb-4">
        Tuliskan nama fitur atau perubahan yang diinginkan.<br>
        Contoh: <em>Tambah Input Manual Order Barang</em>
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <p>Nama Fitur</p>
            <x-input-label value="Nama Fitur" />
            <input name="title" value="{{ $val('title') }}" class="mt-2 w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 text-sm outline-none focus:border-primary" required />
            @error('title')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
        </div>

        <div>
            <p>Kategori (internal)</p>
            <x-input-label value="Kategori (internal)" />
            <select name="category" class="mt-2 w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 text-sm outline-none focus:border-primary" required>
                <option value="">-- Pilih --</option>
                @foreach ($categories as $c)
                    <option value="{{ $c }}" @selected($val('category') === $c)>{{ ucfirst(str_replace('_',' ',$c)) }}</option>
                @endforeach
            </select>
            @error('category')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- 2. LATAR BELAKANG PERMASALAHAN --}}
{{-- ============================================================ --}}
<div class="mt-6 rounded-2xl border border-outline-variant bg-white p-6">
    <div class="flex items-center gap-2 mb-4">
        <span class="material-symbols-outlined text-[20px]">looks_two</span>
        <h2 class="text-lg font-bold">2. Latar Belakang Permasalahan</h2>
    </div>
    <p class="text-sm text-on-surface-variant mb-4">Mengapa fitur ini dibutuhkan? Jelaskan masalah yang terjadi saat ini.</p>

    <textarea name="body" rows="6" class="w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 text-sm outline-none focus:border-primary">{{ $val('body') }}</textarea>
    @error('body')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
</div>

{{-- ============================================================ --}}
{{-- 3. ALUR SISTEM SAAT INI --}}
{{-- ============================================================ --}}
<div class="mt-6 rounded-2xl border border-outline-variant bg-white p-6">
    <div class="flex items-center gap-2 mb-4">
        <span class="material-symbols-outlined text-[20px]">looks_3</span>
        <h2 class="text-lg font-bold">3. Alur Sistem Saat Ini</h2>
    </div>
    <p class="text-sm text-on-surface-variant mb-4">Jelaskan bagaimana proses berjalan saat ini.</p>

    <textarea name="current_workflow" rows="5" class="w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 text-sm outline-none focus:border-primary">{{ $val('current_workflow') }}</textarea>
</div>

{{-- ============================================================ --}}
{{-- 4. ALUR SISTEM YANG DIINGINKAN --}}
{{-- ============================================================ --}}
<div class="mt-6 rounded-2xl border border-outline-variant bg-white p-6">
    <div class="flex items-center gap-2 mb-4">
        <span class="material-symbols-outlined text-[20px]">looks_4</span>
        <h2 class="text-lg font-bold">4. Alur Sistem Yang Diinginkan</h2>
    </div>
    <p class="text-sm text-on-surface-variant mb-4">Jelaskan proses yang diinginkan setelah fitur dibuat.</p>

    <div class="grid grid-cols-1 gap-6">
        <div>
            <p>Alur yang diigninkan</p>
            <x-input-label value="Alur yang diinginkan" />
            <textarea name="expected_workflow" rows="5" class="mt-2 w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 text-sm outline-none focus:border-primary">{{ $val('expected_workflow') }}</textarea>
        </div>

        <div>
            <p>Tujuan Bisnis Opsional</p>
            <x-input-label value="Tujuan Bisnis (opsional)" />
            <textarea name="business_goal" rows="3" class="mt-2 w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 text-sm outline-none focus:border-primary">{{ $val('business_goal') }}</textarea>
        </div>

        <div>
            <p>Manfaat yang Diharapkan (opsional)</p>
            <x-input-label value="Manfaat yang Diharapkan (opsional)" />
            <textarea name="expected_benefits" rows="3" class="mt-2 w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 text-sm outline-none focus:border-primary">{{ $val('expected_benefits') }}</textarea>
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- 5. HALAMAN/MENU YANG TERDAMPAK --}}
{{-- ============================================================ --}}
<div class="mt-6 rounded-2xl border border-outline-variant bg-white p-6">
    <div class="flex items-center gap-2 mb-4">
        <span class="material-symbols-outlined text-[20px]">looks_5</span>
        <h2 class="text-lg font-bold">5. Halaman/Menu Yang Terdampak</h2>
    </div>
    <p class="text-sm text-on-surface-variant mb-4">Centang menu yang akan berubah.</p>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
        @foreach ($affectedMenuItems as $item)
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="affected_menu_items[]" value="{{ $item }}" @checked(in_array($item, $affectedMenuChecked)) class="rounded border-outline-variant text-primary focus:ring-primary">
                {{ $item }}
            </label>
        @endforeach
    </div>

    <div class="mt-4">
        <p>Keterangan</p>
        <x-input-label value="Keterangan" />
        <textarea name="affected_menu_keterangan" rows="2" class="mt-2 w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 text-sm outline-none focus:border-primary">{{ $affectedMenuNote }}</textarea>
    </div>
</div>

{{-- ============================================================ --}}
{{-- 6. DETAIL PERUBAHAN YANG DIINGINKAN --}}
{{-- ============================================================ --}}
<div class="mt-6 rounded-2xl border border-outline-variant bg-white p-6">
    <div class="flex items-center gap-2 mb-4">
        <span class="material-symbols-outlined text-[20px]">looks_6</span>
        <h2 class="text-lg font-bold">6. Detail Perubahan Yang Diinginkan</h2>
    </div>
    <p class="text-sm text-on-surface-variant mb-4">
        Jelaskan secara rinci. Contoh:<br>
        • Tambahkan textbox input manual.<br>
        • Dropdown tetap tersedia.<br>
        • Jika memilih "Lainnya" maka textbox muncul.
    </p>

    <textarea name="field_changes" rows="6" class="w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 text-sm outline-none focus:border-primary">{{ $val('field_changes') }}</textarea>
</div>

{{-- ============================================================ --}}
{{-- 7. DAMPAK TERHADAP DATA --}}
{{-- ============================================================ --}}
<div class="mt-6 rounded-2xl border border-outline-variant bg-white p-6">
    <div class="flex items-center gap-2 mb-4">
        <span class="material-symbols-outlined text-[20px]">filter_7</span>
        <h2 class="text-lg font-bold">7. Dampak Terhadap Data</h2>
    </div>
    <p class="text-sm text-on-surface-variant mb-4">Apakah perubahan ini mempengaruhi:</p>

    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
        @foreach ($dataImpactItems as $item)
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="impact_analysis_items[]" value="{{ $item }}" @checked(in_array($item, $dataImpactChecked)) class="rounded border-outline-variant text-primary focus:ring-primary">
                {{ $item }}
            </label>
        @endforeach
    </div>

    <div class="mt-4">
        <p>Keterangan</p>
        <x-input-label value="Keterangan" />
        <textarea name="impact_analysis_keterangan" rows="3" class="mt-2 w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 text-sm outline-none focus:border-primary">{{ $dataImpactNote }}</textarea>
    </div>
</div>

{{-- ============================================================ --}}
{{-- 8. ATURAN BISNIS (BUSINESS RULES) --}}
{{-- ============================================================ --}}
<div class="mt-6 rounded-2xl border border-outline-variant bg-white p-6">
    <div class="flex items-center gap-2 mb-4">
        <span class="material-symbols-outlined text-[20px]">filter_8</span>
        <h2 class="text-lg font-bold">8. Aturan Bisnis (Business Rules)</h2>
    </div>
    <p class="text-sm text-on-surface-variant mb-4">
        Contoh:<br>
        • Nama barang manual maksimal 100 karakter.<br>
        • Tidak mengurangi stok otomatis.<br>
        • Wajib diisi jika memilih "Lainnya".
    </p>

    <textarea name="business_rules" rows="5" class="w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 text-sm outline-none focus:border-primary">{{ $val('business_rules') }}</textarea>

    <div class="mt-4">
        <p>Validasi Tambahan (opsional)</p>
        <x-input-label value="Validasi Tambahan (opsional)" />
        <textarea name="validation_rules" rows="3" class="mt-2 w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 text-sm outline-none focus:border-primary">{{ $val('validation_rules') }}</textarea>
    </div>
</div>

{{-- ============================================================ --}}
{{-- 9. CONTOH TAMPILAN YANG DIINGINKAN --}}
{{-- ============================================================ --}}
<div class="mt-6 rounded-2xl border border-outline-variant bg-white p-6">
    <div class="flex items-center gap-2 mb-4">
        <span class="material-symbols-outlined text-[20px]">filter_9</span>
        <h2 class="text-lg font-bold">9. Contoh Tampilan Yang Diinginkan</h2>
    </div>
    <p class="text-sm text-on-surface-variant mb-4">Lampirkan referensi (centang yang sesuai):</p>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        @foreach ($lampiranItems as $item)
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="uiux_notes_items[]" value="{{ $item }}" @checked(in_array($item, $lampiranChecked)) class="rounded border-outline-variant text-primary focus:ring-primary">
                {{ $item }}
            </label>
        @endforeach
    </div>

    <div class="mt-4">
        <p>Keterangan</p>
        <x-input-label value="Keterangan" />
        <textarea name="uiux_notes_keterangan" rows="3" class="mt-2 w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 text-sm outline-none focus:border-primary">{{ $lampiranNote }}</textarea>
    </div>
</div>

{{-- ============================================================ --}}
{{-- 10. RISIKO YANG DIPAHAMI OLEH PENGGUNA --}}
{{-- ============================================================ --}}
<div class="mt-6 rounded-2xl border border-outline-variant bg-white p-6">
    <div class="flex items-center gap-2 mb-4">
        <span class="material-symbols-outlined text-[20px]">filter_9_plus</span>
        <h2 class="text-lg font-bold">10. Risiko Yang Dipahami Oleh Pengguna</h2>
    </div>
    <p class="text-sm text-on-surface-variant mb-4">Pengguna memahami bahwa perubahan ini dapat berdampak pada:</p>

    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
        @foreach ($risikoItems as $item)
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="potential_risk_items[]" value="{{ $item }}" @checked(in_array($item, $risikoChecked)) class="rounded border-outline-variant text-primary focus:ring-primary">
                {{ $item }}
            </label>
        @endforeach
    </div>

    <div class="mt-4">
        <p>Catatan</p>
        <x-input-label value="Catatan" />
        <textarea name="potential_risk_keterangan" rows="3" class="mt-2 w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 text-sm outline-none focus:border-primary">{{ $risikoNote }}</textarea>
    </div>
</div>

{{-- ============================================================ --}}
{{-- 11. PRIORITAS PENGERJAAN --}}
{{-- ============================================================ --}}
<div class="mt-6 rounded-2xl border border-outline-variant bg-white p-6">
    <div class="flex items-center gap-2 mb-4">
        <span class="material-symbols-outlined text-[20px]">priority_high</span>
        <h2 class="text-lg font-bold">11. Prioritas Pengerjaan</h2>
    </div>

    <div class="flex flex-wrap gap-6 mb-4">
        @foreach ($priorityOptions as $p)
            <label class="flex items-center gap-2 text-sm">
                <input type="radio" name="priority" value="{{ $p }}" @checked($val('priority') === $p) class="border-outline-variant text-primary focus:ring-primary">
                {{ $p }}
            </label>
        @endforeach
    </div>
<p>Alasan</p>
    <x-input-label value="Alasan" />
    <textarea name="priority_reason" rows="3" class="mt-2 w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 text-sm outline-none focus:border-primary">{{ $val('priority_reason') }}</textarea>
</div>