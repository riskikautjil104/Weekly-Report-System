<?php $__env->startSection('content'); ?>
    <div class="space-y-6">
        <section class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-secondary">Admin Tools</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-on-surface">Sheet Manager</h2>
                <p class="mt-2 max-w-2xl text-sm text-on-surface-variant"><?php echo e($pageLead); ?></p>
            </div>

            <a href="<?php echo e(route('sheets.show')); ?>" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-secondary transition hover:bg-surface-container-high">
                <span class="material-symbols-outlined text-[20px]">visibility</span>
                View as User
            </a>
        </section>

        <?php if(session('success')): ?>
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                Please fix the highlighted fields below.
            </div>
        <?php endif; ?>

        <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
            <form method="POST" action="<?php echo e(route('admin.sheets.store')); ?>" class="grid gap-5 lg:grid-cols-2">
                <?php echo csrf_field(); ?>

                <label class="space-y-2">
                    <span class="text-sm font-semibold text-on-surface">Month</span>
                    <input type="month" name="month" value="<?php echo e(old('month', now()->format('Y-m'))); ?>" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" required>
                    <?php $__errorArgs = ['month'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </label>

                <label class="space-y-2">
                    <span class="text-sm font-semibold text-on-surface">Sheet Title</span>
                    <input type="text" name="title" value="<?php echo e(old('title')); ?>" placeholder="Weekly Report June 2026" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" required>
                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </label>

                <label class="space-y-2 lg:col-span-2">
                    <span class="text-sm font-semibold text-on-surface">Google Sheet URL</span>
                    <input type="url" name="sheet_url" value="<?php echo e(old('sheet_url')); ?>" placeholder="https://docs.google.com/spreadsheets/d/.../edit?gid=..." class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" required>
                    <?php $__errorArgs = ['sheet_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </label>

                <label class="space-y-2">
                    <span class="text-sm font-semibold text-on-surface">GID <span class="text-xs text-secondary">(optional)</span></span>
                    <input type="text" name="sheet_gid" value="<?php echo e(old('sheet_gid')); ?>" placeholder="16849638" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                    <?php $__errorArgs = ['sheet_gid'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </label>

                <label class="space-y-2">
                    <span class="text-sm font-semibold text-on-surface">Notes <span class="text-xs text-secondary">(optional)</span></span>
                    <input type="text" name="notes" value="<?php echo e(old('notes')); ?>" placeholder="Link untuk bulan berjalan" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                    <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </label>

                <label class="inline-flex items-center gap-3 lg:col-span-2">
                    <input type="checkbox" name="is_active" value="1" class="h-4 w-4 rounded border-outline-variant text-primary focus:ring-primary/20" <?php if(old('is_active', true)): echo 'checked'; endif; ?>>
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
                    <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $activeSheet ? 'active' : 'pending']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($activeSheet ? 'active' : 'pending')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $attributes = $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $component = $__componentOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
                </div>

                <?php if($activeSheet): ?>
                    <div class="mt-5 space-y-3 rounded-2xl border border-outline-variant bg-surface-container-low p-4 text-sm text-on-surface-variant">
                        <div><span class="font-semibold text-on-surface">Month:</span> <?php echo e($activeSheet->month?->translatedFormat('F Y')); ?></div>
                        <div><span class="font-semibold text-on-surface">Title:</span> <?php echo e($activeSheet->title); ?></div>
                        <div><span class="font-semibold text-on-surface">URL:</span> <a href="<?php echo e($activeSheet->sheet_url); ?>" target="_blank" class="text-primary hover:underline">Open sheet</a></div>
                        <?php if($activeSheet->notes): ?>
                            <div><span class="font-semibold text-on-surface">Notes:</span> <?php echo e($activeSheet->notes); ?></div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="mt-5 rounded-2xl border border-dashed border-outline-variant bg-surface-container-low p-5 text-sm text-on-surface-variant">
                        Belum ada sheet aktif. Tambahkan link bulan baru di form atas.
                    </div>
                <?php endif; ?>

                <div class="mt-6 rounded-2xl border border-outline-variant bg-surface-container-low p-4">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Spreadsheet Preview</p>
                            <h4 class="mt-1 text-base font-bold text-on-surface">Active sheet data</h4>
                        </div>
                        <span class="rounded-full bg-surface-container px-3 py-1 text-xs font-semibold text-primary"><?php echo e($sheetData['ok'] ? 'LIVE' : 'ERROR'); ?></span>
                    </div>

                    <?php if($sheetData['error']): ?>
                        <p class="mt-3 text-sm text-rose-700"><?php echo e($sheetData['error']); ?></p>
                    <?php else: ?>
                        <div class="mt-4 overflow-x-auto">
                            <table class="min-w-full border-separate border-spacing-0">
                                <thead>
                                    <tr class="text-left text-xs uppercase tracking-[0.18em] text-secondary">
                                        <?php $__empty_1 = true; $__currentLoopData = $sheetData['headers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $header): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <th class="border-b border-outline-variant px-3 py-2"><?php echo e($header); ?></th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <th class="border-b border-outline-variant px-3 py-2">No data</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-outline-variant">
                                    <?php $__empty_1 = true; $__currentLoopData = $sheetData['rows']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <?php $__currentLoopData = $sheetData['headers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $header): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <td class="px-3 py-2 text-sm text-on-surface-variant"><?php echo e($row[$header] ?? '-'); ?></td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="<?php echo e(max(1, count($sheetData['headers']))); ?>" class="px-3 py-4 text-sm text-on-surface-variant">
                                                Tidak ada baris data untuk ditampilkan.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </article>

            <article class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Saved Sheets</p>
                        <h3 class="mt-1 text-xl font-bold text-on-surface">Riwayat link bulanan</h3>
                    </div>
                    <span class="rounded-full bg-surface-container px-3 py-1 text-xs font-semibold text-primary"><?php echo e($sheets->count()); ?> items</span>
                </div>

                <div class="mt-5 space-y-3">
                    <?php $__empty_1 = true; $__currentLoopData = $sheets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sheet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="rounded-2xl border border-outline-variant bg-surface-container-low p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="font-semibold text-on-surface"><?php echo e($sheet->title); ?></p>
                                    <p class="mt-1 text-sm text-on-surface-variant"><?php echo e($sheet->month?->translatedFormat('F Y')); ?></p>
                                </div>
                                <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $sheet->is_active ? 'active' : 'pending']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sheet->is_active ? 'active' : 'pending')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $attributes = $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $component = $__componentOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
                            </div>

                            <div class="mt-3 flex flex-wrap gap-2">
                                <?php if (! ($sheet->is_active)): ?>
                                    <form method="POST" action="<?php echo e(route('admin.sheets.activate', $sheet)); ?>" class="m-0">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-primary px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:opacity-90">
                                            <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                            Set Active
                                        </button>
                                    </form>
                                <?php endif; ?>

                                <form method="POST" action="<?php echo e(route('admin.sheets.destroy', $sheet)); ?>" onsubmit="return confirm('Hapus sheet ini?')" class="m-0">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="inline-flex items-center gap-2 rounded-xl border border-rose-200 bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-100">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="rounded-2xl border border-dashed border-outline-variant bg-surface-container-low p-5 text-sm text-on-surface-variant">
                            Belum ada sheet yang tersimpan.
                        </div>
                    <?php endif; ?>
                </div>
            </article>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/rizkihiibrahim/Downloads/folder tanpa judul/projects/weekly-report/resources/views/admin/sheets/index.blade.php ENDPATH**/ ?>