<header class="sticky top-0 z-30 border-b border-outline-variant bg-surface-container-lowest/95 backdrop-blur lg:pl-64">
    <div class="mx-auto flex max-w-[1280px] items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl border border-outline-variant bg-white shadow-sm lg:hidden">
                <img src="<?php echo e(asset('logo.png')); ?>" alt="Weekly Report" class="h-8 w-8 object-contain">
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-secondary">Weekly Report System</p>
                <h1 class="text-xl font-bold tracking-tight text-on-surface"><?php echo e($pageTitle ?? 'Dashboard'); ?></h1>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <label class="relative hidden md:flex items-center">
                <span class="material-symbols-outlined absolute left-3 text-on-surface-variant">search</span>
                <input type="text" placeholder="Search activities..." class="w-64 rounded-full border border-outline-variant bg-surface px-10 py-2 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
            </label>

            <button type="button" class="rounded-full p-2 text-primary transition hover:bg-surface-container">
                <span class="material-symbols-outlined">notifications</span>
            </button>

            <?php
                $user = auth()->user();
                $name = $user?->name ?? 'Guest User';
                $parts = preg_split('/\s+/', trim($name)) ?: [];
                $initials = strtoupper(implode('', array_map(fn ($part) => mb_substr($part, 0, 1), array_slice($parts, 0, 2)))) ?: 'GU';
            ?>

            <div class="flex items-center gap-3 rounded-full border border-outline-variant bg-white px-3 py-2 shadow-sm">
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-primary text-sm font-bold text-white">
                    <?php echo e($initials); ?>

                </div>
                <div class="hidden sm:block">
                    <p class="text-sm font-semibold text-on-surface"><?php echo e($name); ?></p>
                    <p class="text-[11px] uppercase tracking-[0.18em] text-secondary"><?php echo e(ucfirst($user?->role ?? 'user')); ?></p>
                </div>
            </div>
        </div>
    </div>
</header>
<?php /**PATH /Users/rizkihiibrahim/Downloads/folder tanpa judul/projects/weekly-report/resources/views/partials/topbar.blade.php ENDPATH**/ ?>