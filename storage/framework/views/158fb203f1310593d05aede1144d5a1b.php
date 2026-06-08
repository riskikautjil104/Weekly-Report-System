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
    $key = strtolower((string) $status);

    $map = [
        'selesai' => ['Selesai', 'bg-emerald-100 text-emerald-800 ring-1 ring-emerald-200'],
        'progress' => ['Progress', 'bg-amber-100 text-amber-800 ring-1 ring-amber-200'],
        'kendala' => ['Kendala', 'bg-rose-100 text-rose-800 ring-1 ring-rose-200'],
        'active' => ['ACTIVE', 'bg-emerald-100 text-emerald-800 ring-1 ring-emerald-200'],
        'pending' => ['PENDING', 'bg-surface-container-high text-on-surface-variant ring-1 ring-outline-variant'],
    ];

    [$label, $classes] = $map[$key] ?? [strtoupper($key ?: 'unknown'), 'bg-surface-container-high text-on-surface-variant ring-1 ring-outline-variant'];
?>

<span <?php echo e($attributes->merge(['class' => 'inline-flex items-center rounded-lg px-3 py-1 text-xs font-semibold tracking-wide ' . $classes])); ?>>
    <?php echo e($label); ?>

</span>
<?php /**PATH /Users/rizkihiibrahim/Downloads/weekly_report/projects/weekly-report/resources/views/components/status-badge.blade.php ENDPATH**/ ?>