<?php $__env->startSection('content'); ?>
    <div class="space-y-6">
        <section class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-secondary">My Reports</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-on-surface">Weekly Report Summary</h2>
                <p class="mt-2 max-w-2xl text-sm text-on-surface-variant"><?php echo e($pageLead); ?></p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="<?php echo e(route('reports.export', request()->query())); ?>" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-secondary transition hover:bg-surface-container-high">
                    <span class="material-symbols-outlined text-[20px]">file_download</span>
                    Export Excel
                </a>
                <a href="<?php echo e(route('reports.print', request()->query())); ?>" target="_blank" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                    <span class="material-symbols-outlined text-[20px]">picture_as_pdf</span>
                    Export PDF
                </a>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['label' => 'Total Task','value' => $summary['total_tasks'],'hint' => 'Semua aktivitas pada periode terpilih','icon' => 'assignment','tone' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Total Task','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($summary['total_tasks']),'hint' => 'Semua aktivitas pada periode terpilih','icon' => 'assignment','tone' => 'primary']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['label' => 'Selesai','value' => $summary['selesai'],'hint' => 'Task yang sudah final','icon' => 'check_circle','tone' => 'success']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Selesai','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($summary['selesai']),'hint' => 'Task yang sudah final','icon' => 'check_circle','tone' => 'success']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['label' => 'Progress','value' => $summary['progress'],'hint' => 'Task yang masih berjalan','icon' => 'hourglass_top','tone' => 'warning']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Progress','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($summary['progress']),'hint' => 'Task yang masih berjalan','icon' => 'hourglass_top','tone' => 'warning']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['label' => 'Kendala','value' => $summary['kendala'],'hint' => 'Task yang butuh bantuan','icon' => 'report','tone' => 'danger']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Kendala','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($summary['kendala']),'hint' => 'Task yang butuh bantuan','icon' => 'report','tone' => 'danger']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
        </section>

        <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
            <form method="GET" action="<?php echo e(route('reports.index')); ?>" class="grid gap-4 md:grid-cols-4">
                <label class="space-y-2">
                    <span class="text-sm font-semibold text-on-surface">From Date</span>
                    <input type="date" name="date_from" value="<?php echo e($filters['date_from']); ?>" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                </label>

                <label class="space-y-2">
                    <span class="text-sm font-semibold text-on-surface">To Date</span>
                    <input type="date" name="date_to" value="<?php echo e($filters['date_to']); ?>" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                </label>

                <label class="space-y-2">
                    <span class="text-sm font-semibold text-on-surface">Status</span>
                    <select name="status" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                        <option value="all" <?php if(($filters['status'] ?? 'all') === 'all'): echo 'selected'; endif; ?>>All Status</option>
                        <option value="selesai" <?php if(($filters['status'] ?? '') === 'selesai'): echo 'selected'; endif; ?>>Selesai</option>
                        <option value="progress" <?php if(($filters['status'] ?? '') === 'progress'): echo 'selected'; endif; ?>>Progress</option>
                        <option value="kendala" <?php if(($filters['status'] ?? '') === 'kendala'): echo 'selected'; endif; ?>>Kendala</option>
                    </select>
                </label>

                <div class="flex items-end gap-3">
                    <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                        <span class="material-symbols-outlined text-[20px]">filter_alt</span>
                        Apply Filters
                    </button>
                    <a href="<?php echo e(route('reports.index')); ?>" class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-secondary transition hover:bg-surface-container-high">
                        Reset
                    </a>
                </div>
            </form>

            <div class="mt-4 grid gap-4 md:grid-cols-3">
                <div class="rounded-xl border border-outline-variant bg-surface-container-low p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Date Range</p>
                    <p class="mt-2 text-sm font-semibold text-on-surface"><?php echo e($filters['dateRange']); ?></p>
                </div>
                <div class="rounded-xl border border-outline-variant bg-surface-container-low p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Scope</p>
                    <p class="mt-2 text-sm font-semibold text-on-surface">My Activity Logs</p>
                </div>
                <div class="rounded-xl border border-outline-variant bg-surface-container-low p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Report Status</p>
                    <p class="mt-2 text-sm font-semibold text-on-surface"><?php echo e(ucfirst($filters['status'] ?: 'all')); ?></p>
                </div>
            </div>
        </section>

        <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Weekly Recap</p>
                    <h3 class="mt-1 text-xl font-bold text-on-surface">Rekap Mingguan</h3>
                </div>
                <span class="rounded-full bg-surface-container px-3 py-1 text-xs font-semibold text-primary"><?php echo e($weekLabel); ?></span>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-0">
                    <thead>
                        <tr class="text-left text-xs uppercase tracking-[0.18em] text-secondary">
                            <th class="border-b border-outline-variant px-4 py-3">Periode</th>
                            <th class="border-b border-outline-variant px-4 py-3">Total Task</th>
                            <th class="border-b border-outline-variant px-4 py-3">Selesai</th>
                            <th class="border-b border-outline-variant px-4 py-3">Progress</th>
                            <th class="border-b border-outline-variant px-4 py-3">Kendala</th>
                            <th class="border-b border-outline-variant px-4 py-3">Completion</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        <?php $__empty_1 = true; $__currentLoopData = $weeklyReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="align-top hover:bg-surface-container transition-colors">
                                <td class="px-4 py-4 text-sm font-medium text-on-surface"><?php echo e($report['periode']); ?></td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant"><?php echo e($report['total']); ?></td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant"><?php echo e($report['selesai']); ?></td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant"><?php echo e($report['progress']); ?></td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant"><?php echo e($report['kendala']); ?></td>
                                <td class="px-4 py-4">
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800"><?php echo e($report['rate']); ?></span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-sm text-on-surface-variant">
                                    Tidak ada data untuk rentang yang dipilih.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Activity Log</p>
                    <h3 class="mt-1 text-xl font-bold text-on-surface">Detail Aktivitas</h3>
                </div>
                <span class="rounded-full bg-surface-container px-3 py-1 text-xs font-semibold text-primary"><?php echo e(count($activities)); ?> activities</span>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-0">
                    <thead>
                        <tr class="text-left text-xs uppercase tracking-[0.18em] text-secondary">
                            <th class="border-b border-outline-variant px-4 py-3">Tanggal</th>
                            <th class="border-b border-outline-variant px-4 py-3">Aktivitas</th>
                            <th class="border-b border-outline-variant px-4 py-3">Status</th>
                            <th class="border-b border-outline-variant px-4 py-3">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        <?php $__empty_1 = true; $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="align-top hover:bg-surface-container transition-colors">
                                <td class="px-4 py-4 text-sm font-medium text-on-surface"><?php echo e($activity->tanggal?->translatedFormat('d M Y')); ?></td>
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
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-sm text-on-surface-variant">
                                    Belum ada aktivitas pada filter ini.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/rizkihiibrahim/Downloads/weekly_report/projects/weekly-report/resources/views/reports/index.blade.php ENDPATH**/ ?>