<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<!-- Tailwind Configuration -->
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                "on-secondary-fixed": "#141d23",
                "surface-container": "#ecedf9",
                "surface-bright": "#faf8ff",
                "inverse-surface": "#2d3039",
                "secondary-container": "#d8e1ea",
                "on-surface-variant": "#424655",
                "surface-container-low": "#f2f3ff",
                "on-primary-fixed-variant": "#00419e",
                "on-secondary-fixed-variant": "#3f484f",
                "on-primary-fixed": "#001946",
                "outline-variant": "#c2c6d8",
                "on-surface": "#191b24",
                "on-secondary-container": "#5b646b",
                "surface-container-high": "#e6e7f3",
                "on-tertiary-fixed": "#370e00",
                "tertiary-fixed": "#ffdbce",
                "surface-tint": "#0057ce",
                "on-secondary": "#ffffff",
                "surface": "#faf8ff",
                "on-primary": "#ffffff",
                "on-tertiary-container": "#ffffff",
                "primary": "#0057cd",
                "on-tertiary": "#ffffff",
                "inverse-primary": "#b1c5ff",
                "on-primary-container": "#ffffff",
                "primary-container": "#0d6efd",
                "surface-variant": "#e1e2ee",
                "surface-container-lowest": "#ffffff",
                "outline": "#727787",
                "primary-fixed-dim": "#b1c5ff",
                "tertiary": "#a63b00",
                "on-tertiary-fixed-variant": "#7f2b00",
                "on-error-container": "#93000a",
                "secondary": "#575f67",
                "surface-container-highest": "#e1e2ee",
                "error-container": "#ffdad6",
                "secondary-fixed": "#dbe4ed",
                "primary-fixed": "#dae2ff",
                "secondary-fixed-dim": "#bfc8d0",
                "on-background": "#191b24",
                "surface-dim": "#d8d9e5",
                "inverse-on-surface": "#eff0fc",
                "error": "#ba1a1a",
                "tertiary-fixed-dim": "#ffb599",
                "background": "#faf8ff",
                "on-error": "#ffffff",
                "tertiary-container": "#cf4b00"
            },
            "borderRadius": {
                "DEFAULT": "0.125rem",
                "lg": "0.25rem",
                "xl": "0.5rem",
                "full": "0.75rem"
            },
            "spacing": {
                "stack-md": "16px",
                "container-max": "1280px",
                "gutter": "24px",
                "margin-desktop": "32px",
                "unit": "4px",
                "stack-sm": "8px",
                "margin-mobile": "16px",
                "stack-lg": "24px"
            },
            "fontFamily": {
                "display-lg": ["Inter"],
                "label-sm": ["Inter"],
                "label-md": ["Inter"],
                "body-sm": ["Inter"],
                "headline-md": ["Inter"],
                "body-base": ["Inter"]
            },
            "fontSize": {
                "label-sm": ["12px", {"lineHeight": "16px", "fontWeight": "500"}],
                "label-md": ["14px", {"lineHeight": "20px", "fontWeight": "600"}],
                "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                "headline-md": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
                "display-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                "body-base": ["16px", {"lineHeight": "24px", "fontWeight": "400"}]
            }
          },
        },
      }
    </script>
<style>
        body { font-family: 'Inter', sans-serif; background-color: #F8F9FA; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #dee2e6; border-radius: 10px; }
    </style>
    </head>
    <body class="font-sans antialiased">
        <div x-data="appShell()" class="min-h-screen bg-gray-100">
            <div
                x-cloak
                x-show="loading"
                x-transition.opacity
                class="fixed inset-0 z-[9999] flex items-center justify-center bg-white/85 backdrop-blur-sm"
                aria-live="polite"
                aria-busy="true"
            >
                <div class="flex flex-col items-center gap-3 rounded-2xl border border-outline-variant bg-white px-6 py-5 shadow-lg">
                    <div class="h-10 w-10 animate-spin rounded-full border-4 border-primary/20 border-t-primary"></div>
                    <p class="text-sm font-semibold text-on-surface">Memuat data...</p>
                </div>
            </div>

            <?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php echo $__env->make('partials.topbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php echo $__env->make('partials.mobile-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <main class="lg:pl-64">
                <div class="mx-auto max-w-[1280px] px-4 py-6 pb-24 sm:px-6 sm:pb-24 lg:px-8 lg:pb-6">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </main>

        </div>
    </body>
</html>
<?php /**PATH /Users/rizkihiibrahim/Downloads/folder tanpa judul/projects/weekly-report/resources/views/layouts/app.blade.php ENDPATH**/ ?>