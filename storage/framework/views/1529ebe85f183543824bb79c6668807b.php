<?php $__env->startSection('content'); ?>
    <div class="space-y-6">
        <section class="rounded-3xl border border-outline-variant bg-gradient-to-br from-surface-container-lowest via-surface-container-low to-surface-container p-6 shadow-sm">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex items-center gap-5">
                    <div class="flex h-20 w-20 items-center justify-center rounded-3xl bg-primary text-2xl font-bold text-white shadow-sm">
                        <?php echo e($initials); ?>

                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-secondary">Profile</p>
                        <h2 class="mt-2 text-3xl font-bold tracking-tight text-on-surface"><?php echo e($user->name); ?></h2>
                        <p class="mt-2 text-sm text-on-surface-variant"><?php echo e(ucfirst($user->role)); ?> · <?php echo e($user->email); ?></p>
                        <?php if($user->whatsapp_number): ?>
                            <p class="mt-1 text-sm text-on-surface-variant">WhatsApp: <?php echo e($user->whatsapp_number); ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="<?php echo e(route('dashboard')); ?>" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                        <span class="material-symbols-outlined text-[20px]">dashboard</span>
                        Back to Dashboard
                    </a>
                    <a href="<?php echo e(route('reports.index')); ?>" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-secondary transition hover:bg-surface-container-high">
                        <span class="material-symbols-outlined text-[20px]">description</span>
                        My Reports
                    </a>
                    <?php if($whatsappLink): ?>
                        <a href="<?php echo e($whatsappLink); ?>" target="_blank" class="inline-flex items-center gap-2 rounded-xl border border-[#25D366]/30 bg-[#25D366]/10 px-4 py-3 text-sm font-semibold text-[#128C7E] transition hover:bg-[#25D366]/15">
                            <span class="material-symbols-outlined text-[20px]">chat</span>
                            Open WhatsApp
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-on-surface-variant">This Week</p>
                        <p class="mt-3 text-xl font-bold tracking-tight text-on-surface"><?php echo e($summary['week_label']); ?></p>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-secondary-container text-primary">
                        <span class="material-symbols-outlined">event</span>
                    </div>
                </div>
                <p class="mt-4 text-sm text-on-surface-variant">Periode aktivitas yang sedang berjalan</p>
            </article>
            <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['label' => 'Total Tasks','value' => $summary['total'],'hint' => 'Semua aktivitas yang kamu input','icon' => 'task_alt','tone' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Total Tasks','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($summary['total']),'hint' => 'Semua aktivitas yang kamu input','icon' => 'task_alt','tone' => 'primary']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['label' => 'Kendala','value' => $summary['kendala'],'hint' => 'Item yang butuh follow-up','icon' => 'warning','tone' => 'warning']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Kendala','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($summary['kendala']),'hint' => 'Item yang butuh follow-up','icon' => 'warning','tone' => 'warning']); ?>
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

        <section class="grid gap-6 xl:grid-cols-[1.05fr_0.95fr]">
            <article class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                <div class="flex items-center gap-2 border-b border-outline-variant pb-4">
                    <span class="material-symbols-outlined text-primary">person</span>
                    <h3 class="text-base font-semibold text-on-surface">Personal Information</h3>
                </div>

                <form method="POST" action="<?php echo e(route('profile.update')); ?>" class="mt-5 space-y-4">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('patch'); ?>

                    <label class="block space-y-2">
                        <span class="text-sm font-semibold text-on-surface">Full Name</span>
                        <input type="text" name="name" value="<?php echo e(old('name', $user->name)); ?>" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-sm text-rose-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>

                    <label class="block space-y-2">
                        <span class="text-sm font-semibold text-on-surface">Email</span>
                        <input type="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" required>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-sm text-rose-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>

                    <label class="block space-y-2">
                        <span class="text-sm font-semibold text-on-surface">WhatsApp Number</span>
                        <input type="text" name="whatsapp_number" value="<?php echo e(old('whatsapp_number', $user->whatsapp_number)); ?>" placeholder="+62..." class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                        <?php $__errorArgs = ['whatsapp_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-sm text-rose-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>

                    <div class="flex items-center gap-4 pt-2">
                        <?php if (isset($component)) { $__componentOriginald411d1792bd6cc877d687758b753742c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald411d1792bd6cc877d687758b753742c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>Save Changes <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $attributes = $__attributesOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__attributesOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $component = $__componentOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__componentOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>

                        <?php if(session('status') === 'profile-updated'): ?>
                            <p class="text-sm font-medium text-emerald-700">Saved.</p>
                        <?php endif; ?>
                    </div>
                </form>
            </article>

            <article class="space-y-6">
                <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                    <div class="flex items-center gap-2 border-b border-outline-variant pb-4">
                        <span class="material-symbols-outlined text-primary">lock</span>
                        <h3 class="text-base font-semibold text-on-surface">Security Preferences</h3>
                    </div>

                    <form method="POST" action="<?php echo e(route('password.update')); ?>" class="mt-5 space-y-4">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('put'); ?>

                        <label class="block space-y-2">
                            <span class="text-sm font-semibold text-on-surface">Current Password</span>
                            <input type="password" name="current_password" autocomplete="current-password" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                            <?php $__errorArgs = ['current_password', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-sm text-rose-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </label>

                        <label class="block space-y-2">
                            <span class="text-sm font-semibold text-on-surface">New Password</span>
                            <input type="password" name="password" autocomplete="new-password" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                            <?php $__errorArgs = ['password', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-sm text-rose-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </label>

                        <label class="block space-y-2">
                            <span class="text-sm font-semibold text-on-surface">Confirm Password</span>
                            <input type="password" name="password_confirmation" autocomplete="new-password" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                            <?php $__errorArgs = ['password_confirmation', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-sm text-rose-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </label>

                        <div class="flex items-center gap-4 pt-2">
                            <?php if (isset($component)) { $__componentOriginald411d1792bd6cc877d687758b753742c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald411d1792bd6cc877d687758b753742c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>Update Password <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $attributes = $__attributesOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__attributesOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $component = $__componentOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__componentOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>

                            <?php if(session('status') === 'password-updated'): ?>
                                <p class="text-sm font-medium text-emerald-700">Saved.</p>
                            <?php endif; ?>
                        </div>
                    </form>
                </section>

                <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                    <div class="flex items-center gap-2 border-b border-outline-variant pb-4">
                        <span class="material-symbols-outlined text-primary">tips_and_updates</span>
                        <h3 class="text-base font-semibold text-on-surface">Quick Actions</h3>
                    </div>

                    <div class="mt-5 grid gap-3 md:grid-cols-2">
                        <a href="<?php echo e(route('activities.create')); ?>" class="rounded-2xl border border-outline-variant bg-surface-container-low p-4 transition hover:bg-surface-container-high">
                            <p class="text-sm font-semibold text-on-surface">Input activity today</p>
                            <p class="mt-2 text-sm text-on-surface-variant">Tambahkan log harian sebelum laporan mingguan ditutup.</p>
                        </a>
                        <a href="<?php echo e(route('reports.index')); ?>" class="rounded-2xl border border-outline-variant bg-surface-container-low p-4 transition hover:bg-surface-container-high">
                            <p class="text-sm font-semibold text-on-surface">Open my reports</p>
                            <p class="mt-2 text-sm text-on-surface-variant">Lihat rekap mingguan dan export yang sudah tersedia.</p>
                        </a>
                        <a href="<?php echo e($whatsappLink ?? route('profile.edit')); ?>" class="rounded-2xl border border-outline-variant bg-surface-container-low p-4 transition hover:bg-surface-container-high md:col-span-2">
                            <p class="text-sm font-semibold text-on-surface">WhatsApp reminder</p>
                            <p class="mt-2 text-sm text-on-surface-variant">
                                <?php if($whatsappNumber): ?>
                                    Tersambung ke <?php echo e($whatsappNumber); ?> untuk reminder harian dan follow-up cepat.
                                <?php else: ?>
                                    Isi nomor WhatsApp di profile supaya reminder bisa diarahkan ke chat.
                                <?php endif; ?>
                            </p>
                        </a>
                    </div>
                </section>
            </article>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/rizkihiibrahim/Downloads/folder tanpa judul/projects/weekly-report/resources/views/profile/edit.blade.php ENDPATH**/ ?>