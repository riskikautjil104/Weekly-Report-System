<?php $__env->startSection('content'); ?>
<?php
    $statusColors = [
        'draft' => 'bg-gray-100 text-gray-700 border-gray-200',
        'submitted' => 'bg-blue-50 text-blue-700 border-blue-200',
        'need_clarification' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
        'approved' => 'bg-green-50 text-green-700 border-green-200',
        'rejected' => 'bg-red-50 text-red-700 border-red-200',
    ];
?>

<div class="flex flex-col gap-4">
    <div>
        <h1 class="text-2xl font-bold">Requirement Gathering</h1>
        <p class="text-sm text-on-surface-variant mt-1">Kelola requirement, diskusi, dan download PDF untuk setiap request.</p>
    </div>

    <?php if(session('success')): ?>
        <div class="p-3 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="flex items-center justify-between gap-3">
        <a href="<?php echo e(route('requirements.create')); ?>" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
            <span class="material-symbols-outlined">add</span>
            Buat Requirement
        </a>
    </div>

    <div class="rounded-2xl border border-outline-variant bg-white overflow-hidden">
        <div class="p-4 border-b border-outline-variant bg-surface-container-lowest">
            <div class="text-sm font-semibold text-secondary">Daftar Requirement</div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-left">
                <thead>
                    <tr class="text-xs uppercase tracking-wide text-on-surface-variant bg-surface-container-lowest">
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Judul</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Pengusul</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $requirements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-t border-outline-variant hover:bg-surface-container-lowest/60 transition">
                        <td class="px-4 py-3 text-sm text-on-surface-variant"><?php echo e($requirements->firstItem() + $i); ?></td>
                        <td class="px-4 py-3 text-sm">
                            <a class="text-primary font-semibold hover:underline" href="<?php echo e(route('requirements.show', $r)); ?>"><?php echo e($r->title); ?></a>
                        </td>
                        <td class="px-4 py-3 text-sm text-on-surface-variant"><?php echo e(ucfirst(str_replace('_',' ', $r->category))); ?></td>
                        <td class="px-4 py-3 text-sm">
                            <span class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold border <?php echo e($statusColors[$r->status] ?? 'bg-gray-100 text-gray-700 border-gray-200'); ?>">
                                <?php echo e(ucfirst(str_replace('_',' ', $r->status))); ?>

                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-on-surface-variant"><?php echo e($r->user?->name ?? '-'); ?></td>
                        <td class="px-4 py-3 text-sm text-on-surface-variant"><?php echo e($r->created_at->format('d M Y')); ?></td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex items-center gap-2">
                                <a class="inline-flex items-center gap-1.5 rounded-xl border border-outline-variant bg-white px-3 py-2 font-semibold text-secondary transition hover:bg-surface-container-high" href="<?php echo e(route('requirements.edit', $r)); ?>">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                    Edit
                                </a>
                                <a class="inline-flex items-center gap-1.5 rounded-xl border border-outline-variant bg-white px-3 py-2 font-semibold text-secondary transition hover:bg-surface-container-high" target="_blank" href="<?php echo e(route('requirements.print', $r)); ?>">
                                    <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                                    Print
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-sm text-on-surface-variant">
                            Belum ada requirement. Klik <span class="font-semibold">Buat Requirement</span> untuk mulai.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="p-4">
            <?php echo e($requirements->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/rizkihiibrahim/Downloads/folder tanpa judul/projects/weekly-report/resources/views/requirements/index.blade.php ENDPATH**/ ?>