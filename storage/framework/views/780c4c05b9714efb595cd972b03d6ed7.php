<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'label',
    'value',
    'hint' => null,
    'icon' => null,
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
    'hint' => null,
    'icon' => null,
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
    $toneClasses = [
        'primary' => 'text-primary bg-primary/10',
        'success' => 'text-emerald-700 bg-emerald-100',
        'warning' => 'text-amber-700 bg-amber-100',
        'danger' => 'text-rose-700 bg-rose-100',
        'neutral' => 'text-secondary bg-surface-container',
    ];

    $iconClasses = $toneClasses[$tone] ?? $toneClasses['primary'];
?>

<article class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm">
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-on-surface-variant"><?php echo e($label); ?></p>
            <p class="mt-3 text-3xl font-bold tracking-tight text-on-surface"><?php echo e($value); ?></p>
        </div>

        <?php if($icon): ?>
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl <?php echo e($iconClasses); ?>">
                <span class="material-symbols-outlined"><?php echo e($icon); ?></span>
            </div>
        <?php endif; ?>
    </div>

    <?php if($hint): ?>
        <p class="mt-4 text-sm text-on-surface-variant"><?php echo e($hint); ?></p>
    <?php endif; ?>
</article>
<?php /**PATH /Users/rizkihiibrahim/Downloads/weekly_report/projects/weekly-report/resources/views/components/stat-card.blade.php ENDPATH**/ ?>