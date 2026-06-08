<?php $__env->startSection('content'); ?>
    <?php
        $isEditing = isset($editingActivity) && $editingActivity;
        $formAction = $isEditing ? route('activities.update', $editingActivity) : route('activities.store');
        $formTitle = $isEditing ? 'Edit Aktivitas Harian' : 'Input Aktivitas Harian';
        $submitLabel = $isEditing ? 'Update Aktivitas' : 'Simpan Aktivitas';
        $selectedDate = old('tanggal', $isEditing ? $editingActivity->tanggal?->toDateString() : $defaultDate);
        $selectedStatus = old('status', $isEditing ? $editingActivity->status : 'progress');
        $selectedActivity = old('aktivitas', $isEditing ? $editingActivity->aktivitas : '');
        $selectedKeterangan = old('keterangan', $isEditing ? $editingActivity->keterangan : '');
    ?>

    <div class="space-y-6">
        <section class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-secondary">Daily Input</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-on-surface"><?php echo e($formTitle); ?></h2>
                <p class="mt-2 max-w-2xl text-sm text-on-surface-variant"><?php echo e($pageLead); ?></p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="<?php echo e(route('activities.index')); ?>" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-on-surface transition hover:bg-surface-container">
                    <span class="material-symbols-outlined text-[20px]">list</span>
                    Activity List
                </a>

                <?php if($isEditing): ?>
                    <a href="<?php echo e(route('activities.create')); ?>" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-on-surface transition hover:bg-surface-container">
                        <span class="material-symbols-outlined text-[20px]">add</span>
                        New Entry
                    </a>
                <?php endif; ?>
            </div>
        </section>

        <?php if(session('status')): ?>
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                Please fix the highlighted fields below.
            </div>
        <?php endif; ?>

        <div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
            <section>
                <form action="<?php echo e($formAction); ?>" method="POST" class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                    <?php echo csrf_field(); ?>
                    <?php if($isEditing): ?>
                        <?php echo method_field('PUT'); ?>
                    <?php endif; ?>

                    <div class="grid gap-5 md:grid-cols-2">
                        <label class="space-y-2">
                            <span class="text-sm font-semibold text-on-surface">Tanggal <span class="text-error">*</span></span>
                            <input type="date" name="tanggal" value="<?php echo e($selectedDate); ?>" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" required>
                            <?php $__errorArgs = ['tanggal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-sm text-error"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </label>

                        <label class="space-y-2">
                            <span class="text-sm font-semibold text-on-surface">Status <span class="text-error">*</span></span>
                            <select name="status" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" required>
                                <option value="">Pilih status</option>
                                <option value="selesai" <?php if($selectedStatus === 'selesai'): echo 'selected'; endif; ?>>Selesai</option>
                                <option value="progress" <?php if($selectedStatus === 'progress'): echo 'selected'; endif; ?>>Progress</option>
                                <option value="kendala" <?php if($selectedStatus === 'kendala'): echo 'selected'; endif; ?>>Kendala</option>
                            </select>
                            <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-sm text-error"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </label>

                        <label class="space-y-2 md:col-span-2">
                            <span class="text-sm font-semibold text-on-surface">Aktivitas <span class="text-error">*</span></span>
                            <textarea name="aktivitas" rows="4" placeholder="Jelaskan aktivitas yang dilakukan..." class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" required><?php echo e($selectedActivity); ?></textarea>
                            <?php $__errorArgs = ['aktivitas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-sm text-error"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </label>

                        <label class="space-y-2 md:col-span-2">
                            <span class="text-sm font-semibold text-on-surface">Keterangan (Opsional)</span>
                            <textarea name="keterangan" rows="3" placeholder="Catatan tambahan atau detail kendala..." class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"><?php echo e($selectedKeterangan); ?></textarea>
                            <?php $__errorArgs = ['keterangan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-sm text-error"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </label>
                    </div>

                    <div class="mt-6 flex flex-wrap items-center justify-end gap-3">
                        <?php if($isEditing): ?>
                            <a href="<?php echo e(route('activities.create')); ?>" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant px-4 py-3 text-sm font-semibold text-on-surface transition hover:bg-surface-container">
                                <span class="material-symbols-outlined text-[20px]">close</span>
                                Cancel Edit
                            </a>
                        <?php endif; ?>

                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                            <span class="material-symbols-outlined text-[20px]">save</span>
                            <?php echo e($submitLabel); ?>

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
                        <?php $__empty_1 = true; $__currentLoopData = $drafts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $draft): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="rounded-xl border border-outline-variant bg-surface-container-low p-4">
                                <div class="flex flex-wrap items-center justify-between gap-3">
                                    <p class="text-sm font-semibold text-on-surface"><?php echo e($draft['aktivitas']); ?></p>
                                    <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $draft['status']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($draft['status'])]); ?>
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
                                <p class="mt-2 text-xs uppercase tracking-[0.18em] text-secondary"><?php echo e($draft['time']); ?></p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="rounded-xl border border-outline-variant bg-surface-container-low p-4 text-sm text-on-surface-variant">
                                Belum ada aktivitas dalam draft.
                            </div>
                        <?php endif; ?>
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
                <span class="rounded-full bg-surface-container px-3 py-1 text-xs font-semibold text-primary"><?php echo e(count($activities)); ?> items</span>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-0">
                    <thead>
                        <tr class="text-left text-xs uppercase tracking-[0.18em] text-secondary">
                            <th class="border-b border-outline-variant px-4 py-3">Tanggal</th>
                            <?php if(auth()->user()->role === 'admin'): ?>
                                <th class="border-b border-outline-variant px-4 py-3">User</th>
                            <?php endif; ?>
                            <th class="border-b border-outline-variant px-4 py-3">Aktivitas</th>
                            <th class="border-b border-outline-variant px-4 py-3">Status</th>
                            <th class="border-b border-outline-variant px-4 py-3">Keterangan</th>
                            <th class="border-b border-outline-variant px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        <?php $__empty_1 = true; $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="align-top hover:bg-surface-container transition-colors">
                                <td class="px-4 py-4 text-sm font-medium text-on-surface"><?php echo e($activity->tanggal?->translatedFormat('d M Y')); ?></td>
                                <?php if(auth()->user()->role === 'admin'): ?>
                                    <td class="px-4 py-4 text-sm text-on-surface-variant"><?php echo e($activity->user?->name ?? '-'); ?></td>
                                <?php endif; ?>
                                <td class="px-4 py-4 text-sm text-on-surface-variant"><?php echo e($activity->aktivitas); ?></td>
                                <td class="px-4 py-4"><?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $activity->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($activity->status)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $attributes = $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $component = $__componentOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?></td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant"><?php echo e($activity->keterangan ?: '-'); ?></td>
                                <td class="px-4 py-4 text-right">
                                    <div class="inline-flex items-center justify-end gap-2">
                                        <a href="<?php echo e(route('activities.edit', $activity)); ?>" class="rounded-lg p-1.5 text-outline transition-colors hover:bg-primary-fixed hover:text-primary" aria-label="Edit activity">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </a>

                                        <form method="POST" action="<?php echo e(route('activities.destroy', $activity)); ?>" onsubmit="return confirm('Hapus aktivitas ini?')" class="m-0">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="rounded-lg p-1.5 text-outline transition-colors hover:bg-error-container hover:text-error" aria-label="Delete activity">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="<?php echo e(auth()->user()->role === 'admin' ? 6 : 5); ?>" class="px-4 py-6 text-sm text-on-surface-variant">
                                    Belum ada aktivitas tersimpan.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/rizkihiibrahim/Downloads/weekly_report/projects/weekly-report/resources/views/activities/create.blade.php ENDPATH**/ ?>