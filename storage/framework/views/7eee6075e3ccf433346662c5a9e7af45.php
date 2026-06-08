<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'label',
    'value',
    'hint',
    'icon',
    'tone' => 'primary',
]));

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

foreach (array_filter(([
    'label',
    'value',
    'hint',
    'icon',
    'tone' => 'primary',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $toneClasses = match ($tone) {
        'success' => ['badge' => 'bg-emerald-500/10 text-emerald-500', 'value' => 'text-emerald-400'],
        'warning' => ['badge' => 'bg-amber-500/10 text-amber-500', 'value' => 'text-amber-400'],
        'danger' => ['badge' => 'bg-rose-500/10 text-rose-500', 'value' => 'text-rose-400'],
        default => ['badge' => 'bg-primary/10 text-primary', 'value' => 'text-primary'],
    };
?>

<article <?php echo e($attributes->merge(['class' => 'rounded-2xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm'])); ?>>
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-on-surface-variant"><?php echo e($label); ?></p>
            <p class="mt-3 text-2xl font-bold tracking-tight <?php echo e($toneClasses['value']); ?>"><?php echo e($value); ?></p>
        </div>
        <div class="flex h-11 w-11 items-center justify-center rounded-2xl <?php echo e($toneClasses['badge']); ?>">
            <span class="material-symbols-outlined"><?php echo e($icon); ?></span>
        </div>
    </div>
    <p class="mt-4 text-sm text-on-surface-variant"><?php echo e($hint); ?></p>
</article>
<?php /**PATH /Users/rizkihiibrahim/Downloads/folder tanpa judul/projects/weekly-report/resources/views/components/stat-card.blade.php ENDPATH**/ ?>