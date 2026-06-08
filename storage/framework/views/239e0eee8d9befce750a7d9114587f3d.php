<?php $__env->startSection('content'); ?>
    <div class="space-y-6">
        
        <section class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-secondary">User Management</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-on-surface">Manage Access & Roles</h2>
                <p class="mt-2 max-w-2xl text-sm text-on-surface-variant"><?php echo e($pageLead); ?></p>
            </div>

            <a href="<?php echo e(route('admin.users.create')); ?>" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                <span class="material-symbols-outlined text-[20px]">person_add</span>
                Add New User
            </a>
        </section>

        <?php if(session('success')): ?>
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        
        <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
            <div class="grid gap-4 md:grid-cols-3">
                <label class="space-y-2">
                    <span class="text-sm font-semibold text-on-surface">Search User</span>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                        <input type="text" placeholder="Search by name or email..." class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 pl-10 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                    </div>
                </label>

                <label class="space-y-2">
                    <span class="text-sm font-semibold text-on-surface">Role</span>
                    <select class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                        <?php $__currentLoopData = $filters['roles']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option><?php echo e($role); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </label>

                <label class="space-y-2">
                    <span class="text-sm font-semibold text-on-surface">Department</span>
                    <select class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                        <?php $__currentLoopData = $filters['departments']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option><?php echo e($department); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </label>
            </div>
        </section>

        <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Users Table</p>
                    <h3 class="mt-1 text-xl font-bold text-on-surface">Daftar Anggota</h3>
                </div>
                <span class="rounded-full bg-surface-container px-3 py-1 text-xs font-semibold text-primary"><?php echo e(count($users)); ?> users</span>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-0">
                    <thead>
                        <tr class="text-left text-xs uppercase tracking-[0.18em] text-secondary">
                            <th class="border-b border-outline-variant px-4 py-3">Name</th>
                            <th class="border-b border-outline-variant px-4 py-3">Email</th>
                            <th class="border-b border-outline-variant px-4 py-3">Role</th>
                            <th class="border-b border-outline-variant px-4 py-3">WhatsApp</th>
                            <th class="border-b border-outline-variant px-4 py-3">Status</th>
                            <th class="border-b border-outline-variant px-4 py-3">Last Seen</th>
                            <th class="border-b border-outline-variant px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="align-top hover:bg-surface-container transition-colors">
                                <td class="px-4 py-4 text-sm font-medium text-on-surface"><?php echo e($user['name']); ?></td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant"><?php echo e($user['email']); ?></td>
                                <td class="px-4 py-4"><?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $user['role']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($user['role'])]); ?>
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
                                <td class="px-4 py-4 text-sm text-on-surface-variant"><?php echo e($user['whatsapp_number']); ?></td>
                                <td class="px-4 py-4"><?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $user['status']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($user['status'])]); ?>
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
                                <td class="px-4 py-4 text-sm text-on-surface-variant"><?php echo e($user['last_seen']); ?></td>
                                <td class="px-4 py-4 text-right">
                                    <div class="inline-flex items-center justify-end gap-2">
                                        <a href="<?php echo e(route('admin.users.edit', $user['id'])); ?>" class="p-1.5 rounded-lg hover:bg-primary-fixed hover:text-primary transition-colors text-outline" aria-label="Edit user">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </a>

                                        <form method="POST" action="<?php echo e(route('admin.users.destroy', $user['id'])); ?>" onsubmit="return confirm('Hapus user ini?')" class="m-0">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="p-1.5 rounded-lg hover:bg-error-container hover:text-error transition-colors text-outline" aria-label="Delete user">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/rizkihiibrahim/Downloads/weekly_report/projects/weekly-report/resources/views/admin/users/index.blade.php ENDPATH**/ ?>