<?php $__env->startSection('content'); ?>
<?php
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
?>

<div class="flex flex-col gap-4">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold"><?php echo e($r->title); ?></h1>
            <p class="text-sm text-on-surface-variant mt-1">
                Diajukan oleh <?php echo e($r->user?->name ?? '-'); ?> &middot; <?php echo e($r->created_at->format('d M Y H:i')); ?>

            </p>
        </div>

        <div class="flex items-center gap-2">
            <span class="px-3 py-1 rounded-full text-xs font-semibold <?php echo e($statusColors[$r->status] ?? 'bg-gray-100 text-gray-700'); ?>">
                <?php echo e(ucfirst(str_replace('_',' ', $r->status))); ?>

            </span>

            <a href="<?php echo e(route('requirements.edit', $r)); ?>" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                <span class="material-symbols-outlined text-[18px]">edit</span>
                Edit
            </a>

            <a href="<?php echo e(route('requirements.print', $r)); ?>" target="_blank" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-2 text-sm font-semibold text-secondary shadow-sm transition hover:bg-surface-container-high">
                <span class="material-symbols-outlined text-[18px]">print</span>
                Print
            </a>

            <a href="<?php echo e(route('requirements.index')); ?>" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-2 text-sm font-semibold text-secondary shadow-sm transition hover:bg-surface-container-high">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Kembali
            </a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    
    <div class="rounded-2xl border border-outline-variant bg-white p-6">
        <h2 class="text-lg font-bold mb-4">Informasi Request</h2>
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div><dt class="text-on-surface-variant">Nomor Request</dt><dd class="font-medium"><?php echo e($r->request_number ?: '-'); ?></dd></div>
            <div><dt class="text-on-surface-variant">Tanggal Request</dt><dd class="font-medium"><?php echo e(optional($r->request_date)->format('d M Y') ?: '-'); ?></dd></div>
            <div><dt class="text-on-surface-variant">Nama Unit/Bagian</dt><dd class="font-medium"><?php echo e($r->department ?: '-'); ?></dd></div>
            <div><dt class="text-on-surface-variant">Nama Pengusul</dt><dd class="font-medium"><?php echo e($r->user?->name ?? '-'); ?></dd></div>
            <div><dt class="text-on-surface-variant">Jabatan</dt><dd class="font-medium"><?php echo e($r->requester_title ?: '-'); ?></dd></div>
            <div><dt class="text-on-surface-variant">Nomor Kontak</dt><dd class="font-medium"><?php echo e($r->contact_number ?: '-'); ?></dd></div>
        </dl>
    </div>

    
    <div class="rounded-2xl border border-outline-variant bg-white p-6">
        <h2 class="text-lg font-bold mb-2">1. Nama Fitur / Perubahan</h2>
        <p class="text-sm"><span class="text-on-surface-variant">Kategori:</span> <?php echo e(ucfirst(str_replace('_',' ',$r->category))); ?></p>
    </div>

    
    <div class="rounded-2xl border border-outline-variant bg-white p-6">
        <h2 class="text-lg font-bold mb-2">2. Latar Belakang Permasalahan</h2>
        <p class="text-sm whitespace-pre-line"><?php echo e($r->body ?: '-'); ?></p>
    </div>

    
    <div class="rounded-2xl border border-outline-variant bg-white p-6">
        <h2 class="text-lg font-bold mb-2">3. Alur Sistem Saat Ini</h2>
        <p class="text-sm whitespace-pre-line"><?php echo e($r->current_workflow ?: '-'); ?></p>
    </div>

    
    <div class="rounded-2xl border border-outline-variant bg-white p-6">
        <h2 class="text-lg font-bold mb-2">4. Alur Sistem Yang Diinginkan</h2>
        <p class="text-sm whitespace-pre-line mb-3"><?php echo e($r->expected_workflow ?: '-'); ?></p>

        <?php if($r->business_goal): ?>
            <p class="text-sm font-semibold mt-2">Tujuan Bisnis</p>
            <p class="text-sm whitespace-pre-line"><?php echo e($r->business_goal); ?></p>
        <?php endif; ?>

        <?php if($r->expected_benefits): ?>
            <p class="text-sm font-semibold mt-2">Manfaat yang Diharapkan</p>
            <p class="text-sm whitespace-pre-line"><?php echo e($r->expected_benefits); ?></p>
        <?php endif; ?>
    </div>

    
    <div class="rounded-2xl border border-outline-variant bg-white p-6">
        <h2 class="text-lg font-bold mb-3">5. Halaman/Menu Yang Terdampak</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2 text-sm">
            <?php $__currentLoopData = $affectedMenuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] <?php echo e($affectedMenuChecked[$item] ? 'text-primary' : 'text-outline-variant'); ?>">
                        <?php echo e($affectedMenuChecked[$item] ? 'check_box' : 'check_box_outline_blank'); ?>

                    </span>
                    <?php echo e($item); ?>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php if($affectedMenuNote): ?>
            <p class="text-sm mt-3 whitespace-pre-line"><span class="text-on-surface-variant">Keterangan:</span> <?php echo e($affectedMenuNote); ?></p>
        <?php endif; ?>
    </div>

    
    <div class="rounded-2xl border border-outline-variant bg-white p-6">
        <h2 class="text-lg font-bold mb-2">6. Detail Perubahan Yang Diinginkan</h2>
        <p class="text-sm whitespace-pre-line"><?php echo e($r->field_changes ?: '-'); ?></p>
    </div>

    
    <div class="rounded-2xl border border-outline-variant bg-white p-6">
        <h2 class="text-lg font-bold mb-3">7. Dampak Terhadap Data</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 text-sm">
            <?php $__currentLoopData = $dataImpactItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] <?php echo e($dataImpactChecked[$item] ? 'text-primary' : 'text-outline-variant'); ?>">
                        <?php echo e($dataImpactChecked[$item] ? 'check_box' : 'check_box_outline_blank'); ?>

                    </span>
                    <?php echo e($item); ?>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php if($dataImpactNote): ?>
            <p class="text-sm mt-3 whitespace-pre-line"><span class="text-on-surface-variant">Keterangan:</span> <?php echo e($dataImpactNote); ?></p>
        <?php endif; ?>
    </div>

    
    <div class="rounded-2xl border border-outline-variant bg-white p-6">
        <h2 class="text-lg font-bold mb-2">8. Aturan Bisnis (Business Rules)</h2>
        <p class="text-sm whitespace-pre-line"><?php echo e($r->business_rules ?: '-'); ?></p>

        <?php if($r->validation_rules): ?>
            <p class="text-sm font-semibold mt-3">Validasi Tambahan</p>
            <p class="text-sm whitespace-pre-line"><?php echo e($r->validation_rules); ?></p>
        <?php endif; ?>
    </div>

    
    <div class="rounded-2xl border border-outline-variant bg-white p-6">
        <h2 class="text-lg font-bold mb-3">9. Contoh Tampilan Yang Diinginkan</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-sm">
            <?php $__currentLoopData = $lampiranItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] <?php echo e($lampiranChecked[$item] ? 'text-primary' : 'text-outline-variant'); ?>">
                        <?php echo e($lampiranChecked[$item] ? 'check_box' : 'check_box_outline_blank'); ?>

                    </span>
                    <?php echo e($item); ?>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php if($lampiranNote): ?>
            <p class="text-sm mt-3 whitespace-pre-line"><span class="text-on-surface-variant">Keterangan:</span> <?php echo e($lampiranNote); ?></p>
        <?php endif; ?>
    </div>

    
    <div class="rounded-2xl border border-outline-variant bg-white p-6">
        <h2 class="text-lg font-bold mb-3">10. Risiko Yang Dipahami Oleh Pengguna</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 text-sm">
            <?php $__currentLoopData = $risikoItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] <?php echo e($risikoChecked[$item] ? 'text-primary' : 'text-outline-variant'); ?>">
                        <?php echo e($risikoChecked[$item] ? 'check_box' : 'check_box_outline_blank'); ?>

                    </span>
                    <?php echo e($item); ?>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php if($risikoNote): ?>
            <p class="text-sm mt-3 whitespace-pre-line"><span class="text-on-surface-variant">Catatan:</span> <?php echo e($risikoNote); ?></p>
        <?php endif; ?>
    </div>

    
    <div class="rounded-2xl border border-outline-variant bg-white p-6">
        <h2 class="text-lg font-bold mb-2">11. Prioritas Pengerjaan</h2>
        <p class="text-sm"><span class="font-semibold"><?php echo e($r->priority ?: '-'); ?></span></p>
        <?php if($r->priority_reason): ?>
            <p class="text-sm mt-2 whitespace-pre-line"><span class="text-on-surface-variant">Alasan:</span> <?php echo e($r->priority_reason); ?></p>
        <?php endif; ?>
    </div>

    
    <div class="rounded-2xl border border-outline-variant bg-white p-6">
        <h2 class="text-lg font-bold mb-4">Diskusi</h2>

        <div class="flex flex-col gap-3 mb-4">
            <?php $__empty_1 = true; $__currentLoopData = $r->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="rounded-xl bg-surface-container-lowest border border-outline-variant p-3">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-semibold"><?php echo e($comment->user?->name ?? 'Unknown'); ?></span>
                        <span class="text-xs text-on-surface-variant"><?php echo e($comment->created_at->format('d M Y H:i')); ?></span>
                    </div>
                    <p class="text-sm whitespace-pre-line"><?php echo e($comment->body); ?></p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-sm text-on-surface-variant">Belum ada komentar.</p>
            <?php endif; ?>
        </div>

        <form method="POST" action="<?php echo e(route('requirements.comments.store', $r)); ?>">
            <?php echo csrf_field(); ?>
            <textarea name="body" rows="3" placeholder="Tulis komentar..." class="w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 text-sm outline-none focus:border-primary" required></textarea>
            <?php $__errorArgs = ['body'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-600 text-sm mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <button type="submit" class="mt-3 inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                <span class="material-symbols-outlined text-[18px]">send</span>
                Kirim Komentar
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/rizkihiibrahim/Downloads/folder tanpa judul/projects/weekly-report/resources/views/requirements/show.blade.php ENDPATH**/ ?>