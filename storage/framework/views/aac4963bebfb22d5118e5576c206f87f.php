<aside class="fixed inset-y-0 left-0 z-40 hidden w-64 flex-col border-r border-outline-variant bg-surface lg:flex">
    <div class="flex h-full flex-col px-4 py-6">
        <div class="mb-6 rounded-2xl border border-outline-variant bg-surface-container-lowest p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <img src="<?php echo e(asset('logo.png')); ?>" alt="Weekly Report Logo" class="h-12 w-12 rounded-xl object-contain bg-white p-1">
                <div>
                    <p class="text-sm font-semibold tracking-[0.14em] text-primary uppercase">WeeklyReport</p>
                    <p class="text-xs text-on-surface-variant">Corporate Portal</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 space-y-1 custom-scrollbar overflow-y-auto pr-1">
            <?php
                $role = auth()->user()->role ?? 'user';

                $navigation = [
                    [
                        'label' => null,
                        'items' => [
                            ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard'],
                            ['route' => 'activities.create', 'label' => 'Activity Input', 'icon' => 'edit_note'],
                            ['route' => 'reports.index', 'label' => 'My Reports', 'icon' => 'description'],
                        ],
                    ],
                ];

                // Safety: hanya admin yang boleh lihat menu Management
                if ($role !== 'admin') {
                    // do nothing
                } else {
                    $navigation[] = [
                        'label' => 'Management',
                        'items' => [
                            ['route' => 'dashboard.admin', 'label' => 'Admin Dashboard', 'icon' => 'admin_panel_settings'],
                            ['route' => 'admin.users.index', 'label' => 'User Management', 'icon' => 'group'],
                            ['route' => 'reports.system', 'label' => 'System Reports', 'icon' => 'analytics'],
                        ],
                    ];
                }
            ?>


            <?php $__currentLoopData = $navigation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($section['label']): ?>
                    <div class="px-3 pt-5 pb-2 text-[11px] font-semibold uppercase tracking-[0.24em] text-secondary">
                        <?php echo e($section['label']); ?>

                    </div>
                <?php endif; ?>

                <?php $__currentLoopData = $section['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php ($active = request()->routeIs($item['route'])); ?>
                    <a href="<?php echo e(route($item['route'])); ?>" class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition <?php echo e($active ? 'bg-secondary-container text-primary shadow-sm' : 'text-secondary hover:bg-surface-container-high'); ?>">
                        <span class="material-symbols-outlined <?php echo e($active ? 'fill-1' : ''); ?>"><?php echo e($item['icon']); ?></span>
                        <span><?php echo e($item['label']); ?></span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </nav>

        <div class="mt-4 space-y-2 border-t border-outline-variant pt-4">
            <a href="<?php echo e(route('activities.create')); ?>" class="flex items-center justify-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                <span class="material-symbols-outlined text-[20px]">add</span>
                New Report
            </a>

            <a href="<?php echo e(route('profile.edit')); ?>" class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium text-secondary transition hover:bg-surface-container-high">
                <span class="material-symbols-outlined">settings</span>
                <span>Settings</span>
            </a>


            <form method="POST" action="<?php echo e(route('logout')); ?>" class="m-0">
                <?php echo csrf_field(); ?>
                <button type="submit" class="w-full text-left flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium text-secondary transition hover:bg-surface-container-high">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Logout</span>
                </button>
            </form>

        </div>
    </div>
</aside>
<?php /**PATH /Users/rizkihiibrahim/Downloads/weekly_report/projects/weekly-report/resources/views/partials/sidebar.blade.php ENDPATH**/ ?>