<?php $__env->startSection('content'); ?>
    <div class="space-y-6">
        <section class="overflow-hidden rounded-3xl border border-outline-variant bg-gradient-to-br from-surface-container-lowest via-surface-container-low to-surface-container p-6 shadow-sm">
            <div class="relative grid gap-8 lg:grid-cols-[1.15fr_0.85fr]">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-secondary">Admin Overview</p>
                    <h2 class="mt-3 text-4xl font-bold tracking-tight text-on-surface">Monitoring team performance for <?php echo e($weekLabel); ?></h2>
                    <p class="mt-4 max-w-2xl text-sm leading-6 text-on-surface-variant"><?php echo e($pageLead); ?></p>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="<?php echo e(route('reports.system')); ?>" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                            <span class="material-symbols-outlined text-[20px]">description</span>
                            Open System Reports
                        </a>
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-secondary transition hover:bg-surface-container-high">
                            <span class="material-symbols-outlined text-[20px]">group</span>
                            Manage Users
                        </a>
                        <a href="<?php echo e(route('reports.system.print', request()->query())); ?>" target="_blank" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-secondary transition hover:bg-surface-container-high">
                            <span class="material-symbols-outlined text-[20px]">picture_as_pdf</span>
                            PDF Preview
                        </a>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl border border-outline-variant bg-white/80 p-4 shadow-sm backdrop-blur">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Current Week</p>
                        <p class="mt-2 text-lg font-bold text-on-surface"><?php echo e($weekLabel); ?></p>
                        <p class="mt-2 text-sm text-on-surface-variant">Snapshot data real-time dari semua user yang submit aktivitas.</p>
                    </div>
                    <div class="rounded-2xl border border-outline-variant bg-white/80 p-4 shadow-sm backdrop-blur">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Focus</p>
                        <p class="mt-2 text-lg font-bold text-on-surface">Weekly Control Center</p>
                        <p class="mt-2 text-sm text-on-surface-variant">Kelola report, user, dan blocker dari satu halaman.</p>
                    </div>
                    <div class="rounded-2xl border border-outline-variant bg-white/80 p-4 shadow-sm backdrop-blur sm:col-span-2">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Key Insight</p>
                        <ul class="mt-3 space-y-2 text-sm text-on-surface-variant">
                            <?php $__empty_1 = true; $__currentLoopData = $insights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $insight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <li class="rounded-xl border border-outline-variant bg-surface px-4 py-3"><?php echo e($insight); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <li class="rounded-xl border border-outline-variant bg-surface px-4 py-3">Belum ada insight untuk periode ini.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <?php $__currentLoopData = $metrics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $metric): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['label' => $metric['label'],'value' => $metric['value'],'hint' => $metric['note'],'icon' => $metric['icon'],'tone' => $metric['tone']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($metric['label']),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($metric['value']),'hint' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($metric['note']),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($metric['icon']),'tone' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($metric['tone'])]); ?>
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
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </section>

        <section class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
            <article class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Weekly Trend</p>
                        <h3 class="mt-1 text-xl font-bold text-on-surface">Aktivitas Harian Minggu Ini</h3>
                    </div>
                    <span class="rounded-full bg-surface-container px-3 py-1 text-xs font-semibold text-primary">Live</span>
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
            </article>

            <aside class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Top Contributors</p>
                        <h3 class="mt-1 text-xl font-bold text-on-surface">User paling aktif</h3>
                    </div>
                    <span class="material-symbols-outlined text-primary">leaderboard</span>
                </div>

                <div class="mt-5 space-y-4">
                    <?php $__empty_1 = true; $__currentLoopData = $teamPerformance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="rounded-2xl border border-outline-variant bg-surface-container-low p-4">
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary/10 text-sm font-bold text-primary">
                                    <?php echo e($team['initials']); ?>

                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate font-semibold text-on-surface"><?php echo e($team['name']); ?></p>
                                    <p class="text-sm text-on-surface-variant"><?php echo e(ucfirst($team['role'])); ?> · <?php echo e($team['total']); ?> aktivitas</p>
                                </div>
                                <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-primary ring-1 ring-outline-variant"><?php echo e($team['rate']); ?>%</span>
                            </div>

                            <div class="mt-4 grid grid-cols-3 gap-2 text-center text-xs">
                                <div class="rounded-xl border border-outline-variant bg-white px-3 py-2">
                                    <p class="text-secondary">Selesai</p>
                                    <p class="mt-1 font-bold text-on-surface"><?php echo e($team['completed']); ?></p>
                                </div>
                                <div class="rounded-xl border border-outline-variant bg-white px-3 py-2">
                                    <p class="text-secondary">Progress</p>
                                    <p class="mt-1 font-bold text-on-surface"><?php echo e($team['progress']); ?></p>
                                </div>
                                <div class="rounded-xl border border-outline-variant bg-white px-3 py-2">
                                    <p class="text-secondary">Kendala</p>
                                    <p class="mt-1 font-bold text-on-surface"><?php echo e($team['kendala']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="rounded-2xl border border-dashed border-outline-variant bg-surface-container-low p-5 text-sm text-on-surface-variant">
                            Belum ada user aktif pada minggu ini.
                        </div>
                    <?php endif; ?>
                </div>
            </aside>
        </section>

        <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Latest Admin Activity</p>
                    <h3 class="mt-1 text-xl font-bold text-on-surface">Aktivitas Tim Terkini</h3>
                </div>
                <a href="<?php echo e(route('reports.system')); ?>" class="text-sm font-semibold text-primary hover:underline">Open system reports</a>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-0">
                    <thead>
                        <tr class="text-left text-xs uppercase tracking-[0.18em] text-secondary">
                            <th class="border-b border-outline-variant px-4 py-3">User</th>
                            <th class="border-b border-outline-variant px-4 py-3">Role</th>
                            <th class="border-b border-outline-variant px-4 py-3">Aktivitas</th>
                            <th class="border-b border-outline-variant px-4 py-3">Status</th>
                            <th class="border-b border-outline-variant px-4 py-3">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        <?php $__empty_1 = true; $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="align-top hover:bg-surface-container transition-colors">
                                <td class="px-4 py-4 text-sm font-medium text-on-surface"><?php echo e($activity['user']); ?></td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant"><?php echo e(ucfirst($activity['role'])); ?></td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant"><?php echo e($activity['aktivitas']); ?></td>
                                <td class="px-4 py-4"><?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $activity['status']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($activity['status'])]); ?>
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
                                <td class="px-4 py-4 text-sm text-on-surface-variant"><?php echo e($activity['tanggal']->translatedFormat('d M Y')); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-sm text-on-surface-variant">Belum ada aktivitas tercatat untuk minggu ini.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/rizkihiibrahim/Downloads/weekly_report/projects/weekly-report/resources/views/dashboard/admin.blade.php ENDPATH**/ ?>