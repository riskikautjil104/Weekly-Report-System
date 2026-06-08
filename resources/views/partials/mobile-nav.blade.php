@php
    $user = auth()->user();
    $role = $user?->role ?? 'user';

    $items = $role === 'admin'
        ? [
            ['route' => 'dashboard.admin', 'label' => 'Admin', 'icon' => 'dashboard'],
            ['route' => 'admin.users.index', 'label' => 'Users', 'icon' => 'group'],
            ['route' => 'reports.system', 'label' => 'Reports', 'icon' => 'analytics'],
            ['route' => 'sheets.show', 'label' => 'Sheets', 'icon' => 'table_view'],
            ['route' => 'profile.edit', 'label' => 'Profile', 'icon' => 'settings'],
        ]
        : [
            ['route' => 'dashboard.user', 'label' => 'Home', 'icon' => 'dashboard'],
            ['route' => 'activities.create', 'label' => 'Input', 'icon' => 'edit_note'],
            ['route' => 'reports.index', 'label' => 'Reports', 'icon' => 'description'],
            ['route' => 'sheets.show', 'label' => 'Sheets', 'icon' => 'table_view'],
            ['route' => 'profile.edit', 'label' => 'Profile', 'icon' => 'settings'],
        ];
@endphp

<nav class="fixed inset-x-0 bottom-0 z-50 border-t border-outline-variant bg-surface-container-lowest/95 backdrop-blur lg:hidden">
    <div class="mx-auto grid max-w-[1280px] grid-cols-5 gap-1 px-2 py-2 sm:px-4">
        @foreach ($items as $item)
            @php($active = request()->routeIs($item['route']))
            <a
                href="{{ route($item['route']) }}"
                class="flex flex-col items-center justify-center gap-1 rounded-2xl px-2 py-2 text-[11px] font-semibold transition {{ $active ? 'bg-secondary-container text-primary shadow-sm' : 'text-secondary hover:bg-surface-container-high' }}"
            >
                <span class="material-symbols-outlined text-[22px] {{ $active ? 'fill-1' : '' }}">{{ $item['icon'] }}</span>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </div>
</nav>
