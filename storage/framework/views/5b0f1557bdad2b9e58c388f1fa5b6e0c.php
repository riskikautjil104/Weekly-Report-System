<?php $__env->startSection('content'); ?>
    <div class="space-y-6">
        
        <section class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-secondary">User Dashboard</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-on-surface">Welcome back, <?php echo e($userName); ?></h2>
                <p class="mt-2 max-w-2xl text-sm text-on-surface-variant"><?php echo e($pageLead); ?></p>
            </div>

            <a href="<?php echo e(route('activities.create')); ?>" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                <span class="material-symbols-outlined text-[20px]">add</span>
                Input Activity Today
            </a>
        </section>

        
        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['label' => 'Total Tasks','value' => $summary['total_tasks'],'hint' => 'Semua aktivitas dalam periode ini','icon' => 'task','tone' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Total Tasks','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($summary['total_tasks']),'hint' => 'Semua aktivitas dalam periode ini','icon' => 'task','tone' => 'primary']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['label' => 'Selesai','value' => $summary['selesai'],'hint' => 'Task yang sudah ditutup','icon' => 'check_circle','tone' => 'success']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Selesai','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($summary['selesai']),'hint' => 'Task yang sudah ditutup','icon' => 'check_circle','tone' => 'success']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['label' => 'Progress','value' => $summary['progress'],'hint' => 'Task yang masih dikerjakan','icon' => 'sync','tone' => 'warning']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Progress','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($summary['progress']),'hint' => 'Task yang masih dikerjakan','icon' => 'sync','tone' => 'warning']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['label' => 'Kendala','value' => $summary['kendala'],'hint' => 'Task yang butuh follow-up','icon' => 'warning','tone' => 'danger']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Kendala','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($summary['kendala']),'hint' => 'Task yang butuh follow-up','icon' => 'warning','tone' => 'danger']); ?>
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

        
        <section class="grid gap-6 xl:grid-cols-[1.25fr_0.75fr]">
            <article class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Weekly Trend</p>
                        <h3 class="mt-1 text-xl font-bold text-on-surface"><?php echo e($weekLabel); ?></h3>
                    </div>
                    <span class="rounded-full bg-surface-container px-3 py-1 text-xs font-semibold text-primary">
                        Completion Rate: <?php echo e($summary['completion_rate']); ?>%
                    </span>
                </div>

                <div class="mt-6 flex items-end gap-3 overflow-x-auto pb-2">
                    <?php $__currentLoopData = $trend; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex min-w-[72px] flex-1 flex-col items-center gap-3">
                            <div class="flex h-56 w-full items-end justify-center rounded-2xl bg-surface-container-low px-3 pt-3">
                                <div class="w-full rounded-t-2xl bg-gradient-to-t from-primary to-primary-container shadow-sm" style="height: <?php echo e(max(24, $bar['value'] * 28)); ?>px"></div>
                            </div>
                            <span class="text-xs font-semibold uppercase tracking-[0.2em] text-secondary"><?php echo e($bar['label']); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="mt-6 flex items-center justify-between gap-3 border-t border-outline-variant pt-4">
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold uppercase tracking-[0.18em] text-secondary">Report Progress</span>
                            <span class="text-xs font-semibold text-primary"><?php echo e($summary['completion_rate']); ?>%</span>
                        </div>
                        <div class="mt-3 w-full rounded-full bg-surface-container">
                            <div class="h-2 rounded-full bg-gradient-to-r from-primary to-primary-container" style="width: <?php echo e($summary['completion_rate']); ?>%"></div>
                        </div>
                    </div>
                </div>
            </article>

            <aside class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Quick Tips</p>
                        <h3 class="mt-1 text-xl font-bold text-on-surface">Weekly Habits</h3>
                    </div>
                    <span class="material-symbols-outlined text-primary">tips_and_updates</span>
                </div>

                <ul class="mt-5 space-y-3">
                    <?php $__empty_1 = true; $__currentLoopData = $reminders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reminder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li class="rounded-xl border border-outline-variant bg-surface px-4 py-3 text-sm text-on-surface-variant">
                            <?php echo e($reminder); ?>

                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li class="rounded-xl border border-outline-variant bg-surface px-4 py-3 text-sm text-on-surface-variant">
                            Tidak ada reminder untuk minggu ini.
                        </li>
                    <?php endif; ?>
                </ul>

                <div class="mt-6 rounded-2xl border border-outline-variant bg-surface-container-low p-4">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-secondary">Reminder Channel</p>
                            <h4 class="mt-1 text-base font-bold text-on-surface">WhatsApp</h4>
                        </div>
                        <span class="material-symbols-outlined text-primary">chat</span>
                    </div>

                    <p class="mt-3 text-sm text-on-surface-variant">
                        <?php if($whatsappNumber): ?>
                            Aktif di <?php echo e($whatsappNumber); ?> untuk follow-up cepat dan reminder harian.
                        <?php else: ?>
                            Nomor WhatsApp belum diisi. Tambahkan di profile supaya reminder bisa dikirim ke chat.
                        <?php endif; ?>
                    </p>

                    <div class="mt-4 flex flex-col gap-3">
                        <?php if($whatsappLink): ?>
                            <a href="<?php echo e($whatsappLink); ?>" target="_blank" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#25D366] px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                                <span class="material-symbols-outlined text-[20px]">send</span>
                                Open WhatsApp
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('profile.edit')); ?>" class="inline-flex items-center justify-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                                <span class="material-symbols-outlined text-[20px]">settings</span>
                                Set WhatsApp Number
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </aside>
        </section>

        
        <section class="grid gap-6 lg:grid-cols-[1.3fr_0.9fr]">
            <article class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Recent Daily Activity</p>
                        <h3 class="mt-1 text-xl font-bold text-on-surface">Recent Daily Activity</h3>
                    </div>
                    <a href="<?php echo e(route('reports.index')); ?>" class="text-sm font-semibold text-primary hover:underline">View All History</a>
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
                            <?php $__empty_1 = true; $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
                                        Belum ada aktivitas yang tercatat minggu ini.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </article>

            <aside class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-secondary">Weekly Report</p>
                    <h3 class="mt-2 text-xl font-bold text-on-surface">Generate your report</h3>
                    <p class="mt-2 text-sm text-on-surface-variant">Ringkasan minggu <?php echo e($weekLabel); ?> berdasarkan data aktual yang sudah masuk.</p>
                </div>

                <div class="mt-5 flex flex-col gap-3">
                    <div class="rounded-xl border border-dashed border-outline-variant bg-surface-container-lowest p-5">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-on-surface"><?php echo e($weekLabel); ?></p>
                            <span class="rounded-full bg-surface-container px-3 py-1 text-xs font-semibold text-primary">Live</span>
                        </div>
                        <div class="mt-3 grid gap-3 md:grid-cols-3">
                            <div class="rounded-lg border border-outline-variant bg-surface-container-low px-4 py-3">
                                <p class="text-xs uppercase tracking-[0.18em] text-secondary">Total</p>
                                <p class="mt-1 text-lg font-bold text-on-surface"><?php echo e($summary['total_tasks']); ?></p>
                            </div>
                            <div class="rounded-lg border border-outline-variant bg-surface-container-low px-4 py-3">
                                <p class="text-xs uppercase tracking-[0.18em] text-secondary">Completion</p>
                                <p class="mt-1 text-lg font-bold text-on-surface"><?php echo e($summary['completion_rate']); ?>%</p>
                            </div>
                            <div class="rounded-lg border border-outline-variant bg-surface-container-low px-4 py-3">
                                <p class="text-xs uppercase tracking-[0.18em] text-secondary">Blockers</p>
                                <p class="mt-1 text-lg font-bold text-on-surface"><?php echo e($summary['kendala']); ?></p>
                            </div>
                        </div>
                        <div class="mt-3 text-xs uppercase tracking-[0.18em] text-secondary">Status: Live summary</div>
                    </div>

                    <div class="grid grid-cols-1 gap-3">
                        <a href="<?php echo e(route('reports.index')); ?>" class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                            <span class="material-symbols-outlined">picture_as_pdf</span>
                            Open Reports
                        </a>
                        <a href="<?php echo e(route('activities.create')); ?>" class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-secondary transition hover:bg-surface-container transition-all">
                            <span class="material-symbols-outlined">add</span>
                            Add Activity
                        </a>
                    </div>
                </div>
            </aside>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/rizkihiibrahim/Downloads/folder tanpa judul/projects/weekly-report/resources/views/dashboard/user.blade.php ENDPATH**/ ?>