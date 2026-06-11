<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Requirement Gathering — <?php echo e($requirement->title); ?></title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --accent: #0057cd;
            --accent-light: #eaf1ff;
            --accent-dark: #003b91;
            --ink: #1a1a1a;
            --muted: #6b7280;
            --line: #d8dde6;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: var(--ink);
            background: #fff;
            padding: 16mm 16mm 22mm;
            line-height: 1.55;
        }

        /* ── Header ── */
        .doc-header {
            display: grid;
            grid-template-columns: 64px 1fr 110px;
            align-items: center;
            gap: 14px;
            padding-bottom: 12px;
            margin-bottom: 4px;
            border-bottom: 3px solid var(--accent);
        }
        .doc-header-logo {
            width: 64px;
            height: 64px;
            border-radius: 10px;
            background: var(--accent-light);
            border: 1px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .doc-header-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .doc-header-center {
            text-align: center;
        }
        .doc-header-site {
            font-size: 21px;
            font-weight: 800;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--accent-dark);
        }
        .doc-header-title {
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: #374151;
            margin-top: 3px;
        }
        .doc-header-sub {
            font-size: 9px;
            color: var(--muted);
            margin-top: 3px;
            letter-spacing: 0.02em;
        }
        .doc-header-meta {
            font-size: 9px;
            text-align: right;
            color: var(--muted);
        }
        .doc-header-meta .meta-label {
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #9ca3af;
        }
        .doc-header-meta .meta-value {
            font-size: 11px;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 6px;
        }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            border: 1px solid;
        }
        .badge-approved   { background:#f0fdf4; color:#15803d; border-color:#bbf7d0; }
        .badge-rejected   { background:#fff1f2; color:#be123c; border-color:#fecdd3; }
        .badge-submitted  { background:#eff6ff; color:#1d4ed8; border-color:#bfdbfe; }
        .badge-need_clarification { background:#fefce8; color:#a16207; border-color:#fde68a; }
        .badge-draft      { background:#f9fafb; color:#6b7280; border-color:#e5e7eb; }

        /* ── Info grid ── */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0;
            border: 1px solid var(--line);
            border-radius: 8px;
            overflow: hidden;
            margin: 14px 0 16px;
            background: #fcfdff;
        }
        .info-cell {
            padding: 8px 12px;
            border-right: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
        }
        .info-cell:nth-child(3n) { border-right: none; }
        .info-cell:nth-last-child(-n+3) { border-bottom: none; }
        .info-label {
            font-size: 8.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--accent);
            margin-bottom: 3px;
        }
        .info-value {
            font-weight: 600;
            font-size: 11px;
            color: var(--ink);
        }

        /* ── Section ── */
        .section {
            margin-bottom: 12px;
            page-break-inside: avoid;
        }
        .section-header {
            background: var(--accent);
            border: 1px solid var(--accent);
            padding: 7px 12px;
            border-radius: 7px 7px 0 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .section-num {
            background: rgba(255,255,255,0.18);
            color: #fff;
            font-size: 9.5px;
            font-weight: 700;
            width: 19px;
            height: 19px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid rgba(255,255,255,0.5);
        }
        .section-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: #fff;
        }
        .section-body {
            border: 1px solid var(--line);
            border-top: none;
            border-radius: 0 0 7px 7px;
            padding: 10px 12px;
            min-height: 32px;
            white-space: pre-wrap;
            font-size: 11px;
            line-height: 1.65;
            background: #fff;
        }
        .section-empty {
            color: #b0b6c0;
            font-style: italic;
        }

        /* ── Two-col grid ── */
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 12px;
        }
        .grid-2 .section { margin-bottom: 0; }

        /* ── Checklist row ── */
        .checklist-row {
            display: flex;
            flex-wrap: wrap;
            gap: 7px 18px;
            margin-bottom: 8px;
            padding-bottom: 8px;
            border-bottom: 1px dashed var(--line);
        }
        .checklist-note {
            color: #374151;
        }
        .checklist-note .note-label {
            color: #9ca3af;
            font-size: 8.5px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: block;
            margin-bottom: 3px;
        }

        /* ── Diskusi ── */
        .comment {
            border: 1px solid #e5e7eb;
            border-left: 3px solid var(--accent);
            border-radius: 6px;
            padding: 8px 10px;
            margin-bottom: 8px;
            page-break-inside: avoid;
            background: #fafbfd;
        }
        .comment-meta {
            display: flex;
            justify-content: space-between;
            font-size: 9.5px;
            margin-bottom: 4px;
        }
        .comment-author { font-weight: 700; color: var(--accent-dark); }
        .comment-date   { color: #9ca3af; }
        .comment-body   { white-space: pre-wrap; font-size: 10.5px; line-height: 1.5; }

        /* ── Signature block ── */
        .sig-section {
            margin-top: 22px;
            page-break-inside: avoid;
        }
        .sig-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #fff;
            background: var(--accent);
            padding: 7px 12px;
            border-radius: 7px 7px 0 0;
        }
        .sig-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0;
            border: 1px solid var(--line);
            border-top: none;
            border-radius: 0 0 7px 7px;
            overflow: hidden;
        }
        .sig-col {
            padding: 12px;
            border-right: 1px solid var(--line);
        }
        .sig-col:last-child { border-right: none; }
        .sig-col-title {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--accent);
            margin-bottom: 8px;
            padding-bottom: 6px;
            border-bottom: 1px solid var(--line);
        }
        .sig-line-label {
            color: #9ca3af;
            font-size: 9px;
        }
        .sig-box {
            border-bottom: 1px solid #c2c8d2;
            min-height: 34px;
            margin: 3px 0 9px;
            font-weight: 600;
            font-size: 10.5px;
            padding-top: 4px;
        }
        .status-checkbox {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 5px;
            font-size: 10px;
        }
        .checkbox {
            width: 12px;
            height: 12px;
            border: 1.5px solid #9ca3af;
            border-radius: 3px;
            display: inline-block;
            flex-shrink: 0;
            background: #fff;
        }
        .checkbox.checked {
            background: var(--accent);
            border-color: var(--accent);
            position: relative;
        }
        .checkbox.checked::after {
            content: '✓';
            color: white;
            font-size: 9px;
            font-weight: 700;
            position: absolute;
            top: -1.5px;
            left: 1.5px;
        }

        /* ── Footer ── */
        .doc-footer {
            position: fixed;
            bottom: -14mm;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8.5px;
            color: #9ca3af;
            border-top: 1px solid var(--line);
            padding-top: 5px;
        }

        @media print {
            body { padding: 14mm 16mm 18mm; }
            @page { margin: 14mm 16mm 18mm; size: A4; }
        }
    </style>
</head>
<body>

    
    <div class="doc-header">
        <div class="doc-header-logo">
            <img src="<?php echo e(asset('assets/img/logosite.png')); ?>" alt="Logo">
        </div>

        <div class="doc-header-center">
            <div class="doc-header-site">SITE TERNATE</div>
            <div class="doc-header-title">Requirement Gathering Form</div>
            <div class="doc-header-sub">RSUD Chasan Boesoirie &mdash; Sistem Informasi Rumah Sakit</div>
        </div>

        <div class="doc-header-meta">
            <div class="meta-label">No. Request</div>
            <div class="meta-value"><?php echo e($requirement->request_number ?? '—'); ?></div>
            <span class="badge badge-<?php echo e($requirement->status); ?>"><?php echo e(str_replace('_',' ', $requirement->status)); ?></span>
            <div style="margin-top:8px; font-size:8px;">
                Dicetak: <?php echo e(now()->isoFormat('D MMM Y, HH:mm')); ?>

            </div>
        </div>
    </div>

    
    <div class="info-grid">
        <div class="info-cell">
            <div class="info-label">Tanggal Request</div>
            <div class="info-value"><?php echo e($requirement->request_date ? \Carbon\Carbon::parse($requirement->request_date)->isoFormat('D MMMM Y') : '—'); ?></div>
        </div>
        <div class="info-cell">
            <div class="info-label">Nama Pengusul</div>
            <div class="info-value"><?php echo e($requirement->user?->name ?? '—'); ?></div>
        </div>
        <div class="info-cell">
            <div class="info-label">Unit / Bagian</div>
            <div class="info-value"><?php echo e($requirement->department ?? '—'); ?></div>
        </div>
        <div class="info-cell">
            <div class="info-label">Jabatan</div>
            <div class="info-value"><?php echo e($requirement->requester_title ?? '—'); ?></div>
        </div>
        <div class="info-cell">
            <div class="info-label">Nomor Kontak</div>
            <div class="info-value"><?php echo e($requirement->contact_number ?? '—'); ?></div>
        </div>
        <div class="info-cell">
            <div class="info-label">Prioritas</div>
            <div class="info-value"><?php echo e($requirement->priority ? ucfirst($requirement->priority) : '—'); ?></div>
        </div>
    </div>

    
    <div class="section">
        <div class="section-header">
            <span class="section-num">1</span>
            <span class="section-title">Nama Fitur / Perubahan</span>
        </div>
        <div class="section-body" style="font-size:13px; font-weight:700; color: var(--accent-dark);">
            <?php echo e($requirement->title); ?>

        </div>
    </div>

    
    <div class="section">
        <div class="section-header">
            <span class="section-num">2</span>
            <span class="section-title">Latar Belakang Permasalahan</span>
        </div>
        <div class="section-body">
            <?php if($requirement->body): ?>
                <?php echo e($requirement->body); ?>

            <?php else: ?>
                <span class="section-empty">Belum diisi.</span>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="grid-2">
        <div class="section">
            <div class="section-header">
                <span class="section-num">3</span>
                <span class="section-title">Alur Sistem Saat Ini</span>
            </div>
            <div class="section-body" style="min-height:60px;">
                <?php if($requirement->current_workflow): ?>
                    <?php echo e($requirement->current_workflow); ?>

                <?php else: ?>
                    <span class="section-empty">Belum diisi.</span>
                <?php endif; ?>
            </div>
        </div>
        <div class="section">
            <div class="section-header">
                <span class="section-num">4</span>
                <span class="section-title">Alur Sistem Yang Diinginkan</span>
            </div>
            <div class="section-body" style="min-height:60px;">
                <?php if($requirement->expected_workflow): ?>
                    <?php echo e($requirement->expected_workflow); ?>

                <?php else: ?>
                    <span class="section-empty">Belum diisi.</span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="section">
        <div class="section-header">
            <span class="section-num">5</span>
            <span class="section-title">Halaman / Menu Yang Terdampak</span>
        </div>
        <div class="section-body">
            <?php
                $menuList = ['Pendaftaran','Rawat Jalan','Rawat Inap','Farmasi','Logistik','Radiologi','Laboratorium','Kasir','Laporan','Lainnya'];
                $affectedRaw = strtolower($requirement->affected_menu ?? '');
            ?>
            <div class="checklist-row">
                <?php $__currentLoopData = $menuList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $checked = str_contains($affectedRaw, '[x] '.strtolower($menu)) || str_contains($affectedRaw, strtolower($menu)); ?>
                    <span class="status-checkbox">
                        <span class="checkbox <?php echo e($checked ? 'checked' : ''); ?>"></span>
                        <?php echo e($menu); ?>

                    </span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php if($requirement->affected_menu): ?>
                <div class="checklist-note">
                    <span class="note-label">Keterangan</span>
                    <?php echo e($requirement->affected_menu); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="section">
        <div class="section-header">
            <span class="section-num">6</span>
            <span class="section-title">Detail Perubahan Yang Diinginkan</span>
        </div>
        <div class="section-body">
            <?php if($requirement->field_changes): ?>
                <?php echo e($requirement->field_changes); ?>

            <?php else: ?>
                <span class="section-empty">Belum diisi.</span>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="grid-2">
        <div class="section">
            <div class="section-header">
                <span class="section-num">7</span>
                <span class="section-title">Dampak Terhadap Data</span>
            </div>
            <div class="section-body" style="min-height:50px;">
                <?php if($requirement->impact_analysis): ?>
                    <?php echo e($requirement->impact_analysis); ?>

                <?php else: ?>
                    <span class="section-empty">Belum diisi.</span>
                <?php endif; ?>
            </div>
        </div>
        <div class="section">
            <div class="section-header">
                <span class="section-num">8</span>
                <span class="section-title">Aturan Bisnis (Business Rules)</span>
            </div>
            <div class="section-body" style="min-height:50px;">
                <?php if($requirement->business_rules): ?>
                    <?php echo e($requirement->business_rules); ?>

                <?php else: ?>
                    <span class="section-empty">Belum diisi.</span>
                <?php endif; ?>

                <?php if($requirement->validation_rules): ?>
                    <div style="margin-top:8px; padding-top:8px; border-top:1px dashed var(--line);">
                        <span class="note-label" style="display:block; color:#9ca3af; font-size:8.5px; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:3px;">Validasi Tambahan</span>
                        <?php echo e($requirement->validation_rules); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="grid-2">
        <div class="section">
            <div class="section-header">
                <span class="section-num">9</span>
                <span class="section-title">Contoh Tampilan / UI-UX Notes</span>
            </div>
            <div class="section-body" style="min-height:50px;">
                <?php if($requirement->uiux_notes): ?>
                    <?php echo e($requirement->uiux_notes); ?>

                <?php else: ?>
                    <span class="section-empty">Belum diisi.</span>
                <?php endif; ?>
            </div>
        </div>
        <div class="section">
            <div class="section-header">
                <span class="section-num">10</span>
                <span class="section-title">Risiko Yang Dipahami Pengguna</span>
            </div>
            <div class="section-body" style="min-height:50px;">
                <?php if($requirement->potential_risk): ?>
                    <?php echo e($requirement->potential_risk); ?>

                <?php else: ?>
                    <span class="section-empty">Belum diisi.</span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="section">
        <div class="section-header">
            <span class="section-num">11</span>
            <span class="section-title">Prioritas Pengerjaan</span>
        </div>
        <div class="section-body" style="display:flex; gap:24px; align-items:flex-start;">
            <div style="flex-shrink:0; min-width:140px;">
                <?php $__currentLoopData = ['tinggi' => 'Tinggi (Urgent)', 'sedang' => 'Sedang', 'rendah' => 'Rendah']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="status-checkbox" style="margin-bottom:7px;">
                        <span class="checkbox <?php echo e(strtolower($requirement->priority ?? '') === $val ? 'checked' : ''); ?>"></span>
                        <?php echo e($label); ?>

                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div style="flex:1; border-left:1px solid var(--line); padding-left:14px;">
                <div style="font-size:8.5px; color:#9ca3af; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:4px;">Alasan</div>
                <?php if($requirement->priority_reason): ?>
                    <?php echo e($requirement->priority_reason); ?>

                <?php else: ?>
                    <span class="section-empty">Belum diisi.</span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <?php if($requirement->comments->isNotEmpty()): ?>
    <div class="section" style="margin-top:4px;">
        <div class="section-header">
            <span class="section-num">💬</span>
            <span class="section-title">Riwayat Diskusi</span>
        </div>
        <div style="border:1px solid var(--line); border-top:none; border-radius:0 0 7px 7px; padding:10px; background:#fff;">
            <?php $__currentLoopData = $requirement->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="comment">
                <div class="comment-meta">
                    <span class="comment-author"><?php echo e($c->user?->name ?? '—'); ?></span>
                    <span class="comment-date"><?php echo e($c->created_at?->isoFormat('D MMM Y, HH:mm')); ?></span>
                </div>
                <div class="comment-body"><?php echo e($c->body); ?></div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>

    
    <div class="sig-section">
        <div class="sig-title">Persetujuan &amp; Verifikasi</div>
        <div class="sig-grid">

            <div class="sig-col">
                <div class="sig-col-title">Pengusul</div>
                <div class="sig-line-label">Nama</div>
                <div class="sig-box"><?php echo e($requirement->user?->name ?? ''); ?></div>
                <div class="sig-line-label">Tanda Tangan</div>
                <div class="sig-box"></div>
                <div class="sig-line-label">Tanggal</div>
                <div class="sig-box"><?php echo e($requirement->request_date ? \Carbon\Carbon::parse($requirement->request_date)->isoFormat('D MMMM Y') : ''); ?></div>
            </div>

            <div class="sig-col">
                <div class="sig-col-title">Diverifikasi Oleh (Operator/Analis)</div>
                <div class="sig-line-label">Nama</div>
                <div class="sig-box"></div>
                <div class="sig-line-label">Tanda Tangan</div>
                <div class="sig-box"></div>
                <div class="sig-line-label">Tanggal</div>
                <div class="sig-box"></div>
            </div>

            <div class="sig-col">
                <div class="sig-col-title">Analisis Programmer</div>
                <?php $__currentLoopData = ['approved' => 'Disetujui', 'need_clarification' => 'Perlu Klarifikasi', 'rejected' => 'Ditolak']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="status-checkbox" style="margin-bottom:6px;">
                        <span class="checkbox <?php echo e($requirement->status === $val ? 'checked' : ''); ?>"></span>
                        <?php echo e($label); ?>

                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div class="sig-line-label" style="margin-top:8px;">Nama Programmer</div>
                <div class="sig-box"></div>
                <div class="sig-line-label">Tanggal</div>
                <div class="sig-box"></div>
            </div>

        </div>
    </div>

    <div class="doc-footer">
        SITE Ternate &middot; Requirement Gathering Form &middot; Dokumen ini dihasilkan otomatis oleh sistem
    </div>

    <script>
        window.addEventListener('load', function() {
            window.print();
        });
    </script>
</body>
</html><?php /**PATH /Users/rizkihiibrahim/Downloads/folder tanpa judul/projects/weekly-report/resources/views/requirements/print.blade.php ENDPATH**/ ?>