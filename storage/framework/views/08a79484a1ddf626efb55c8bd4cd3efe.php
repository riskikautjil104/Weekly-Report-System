<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['status']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['status']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $normalized = strtolower(trim((string) $status));

    $label = match ($normalized) {
        'selesai' => 'Selesai',
        'progress' => 'Progress',
        'kendala' => 'Kendala',
        'admin' => 'Admin',
        'user' => 'User',
        'active' => 'Active',
        'pending' => 'Pending',
        'inactive' => 'Inactive',
        default => $status,
    };

    $classes = match ($normalized) {
        'selesai', 'active', 'admin' => 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20',
        'kendala', 'inactive' => 'bg-rose-500/10 text-rose-500 border-rose-500/20',
        'progress', 'pending', 'user' => 'bg-amber-500/10 text-amber-500 border-amber-500/20',
        default => 'bg-slate-500/10 text-slate-500 border-slate-500/20',
    };
?>

<span <?php echo e($attributes->merge(['class' => "inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] {$classes}"])); ?>>
    <?php echo e($label); ?>

</span>
<?php /**PATH /Users/rizkihiibrahim/Downloads/folder tanpa judul/projects/weekly-report/resources/views/components/status-badge.blade.php ENDPATH**/ ?>