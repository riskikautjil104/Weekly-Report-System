<aside class="fixed inset-y-0 left-0 z-40 hidden w-64 flex-col border-r border-outline-variant bg-surface lg:flex">
    <div class="flex h-full flex-col px-4 py-6">
        <div class="mb-6 rounded-2xl border border-outline-variant bg-surface-container-lowest p-4 shadow-sm">
            <div class="flex items-center gap-3">
                 <img src="{{ asset('assets/img/logosite.png') }}" alt="Logo" class="h-14 w-14 rounded-xl object-contain bg-white p-1">
                {{-- <img src="{{ asset('logo.png') }}" alt="Weekly Report Logo" class="h-12 w-12 rounded-xl object-contain bg-white p-1"> --}}
                <div>
                    <p class="text-sm font-semibold tracking-[0.14em] text-primary uppercase">WeeklyReport</p>
                    <p class="text-xs text-on-surface-variant">Corporate Portal</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 space-y-1 custom-scrollbar overflow-y-auto pr-1">
            @php
                $role = auth()->user()->role ?? 'user';

                $navigation = [
                    [
                        'label' => null,
                        'items' => [
                            ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard'],
                            ['route' => 'activities.create', 'label' => 'Activity Input', 'icon' => 'edit_note'],
                             ['route' => 'reports.system', 'label' => 'System Reports', 'icon' => 'analytics'],
                            ['route' => 'reports.index', 'label' => 'My Reports', 'icon' => 'description'],
                            ['route' => 'archives.index', 'label' => 'Arsip', 'icon' => 'inventory_2'],
                            ['route' => 'sheets.show', 'label' => 'Sheets', 'icon' => 'table_view'],
                            ['route' => 'requirements.index', 'label' => 'Requirement Gathering', 'icon' => 'fact_check'],
                            ['route' => 'overtime.index', 'routePattern' => 'overtime.*', 'label' => 'Lembur', 'icon' => 'schedule'],
                            ['route' => 'analytics.index', 'routePattern' => 'analytics.*', 'label' => 'Analisis', 'icon' => 'analytics'],
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
                            // ['route' => 'reports.system', 'label' => 'System Reports', 'icon' => 'analytics'],
                            ['route' => 'admin.weekly-plans.index', 'label' => 'Weekly Plans', 'icon' => 'calendar_month'],
                            ['route' => 'admin.sheets.index', 'label' => 'Sheet Manager', 'icon' => 'dataset'],
                            ['route' => 'admin.overtime.index', 'routePattern' => 'admin.overtime.*', 'label' => 'Approval Lembur', 'icon' => 'fact_check'],
                            ['route' => 'admin.analytics.index', 'routePattern' => 'admin.analytics.*', 'label' => 'Analisis Tim', 'icon' => 'insights'],
                            ['route' => 'archives.index', 'label' => 'Archive', 'icon' => 'inventory_2'],
                        ],
                    ];
                }
            @endphp


            @foreach ($navigation as $section)
                @if ($section['label'])
                    <div class="px-3 pt-5 pb-2 text-[11px] font-semibold uppercase tracking-[0.24em] text-secondary">
                        {{ $section['label'] }}
                    </div>
                @endif

                @foreach ($section['items'] as $item)
                    @php($active = isset($item['routePattern']) ? request()->routeIs($item['routePattern']) : request()->routeIs($item['route']))
                    <a href="{{ route($item['route']) }}" class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition {{ $active ? 'bg-secondary-container text-primary shadow-sm' : 'text-secondary hover:bg-surface-container-high' }}">
                        <span class="material-symbols-outlined {{ $active ? 'fill-1' : '' }}">{{ $item['icon'] }}</span>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            @endforeach
        </nav>

        <div class="mt-4 space-y-2 border-t border-outline-variant pt-4">
            <a href="{{ route('activities.create') }}" class="flex items-center justify-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                <span class="material-symbols-outlined text-[20px]">add</span>
                New Report
            </a>

            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium text-secondary transition hover:bg-surface-container-high">
                <span class="material-symbols-outlined">settings</span>
                <span>Settings</span>
            </a>


            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="w-full text-left flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium text-secondary transition hover:bg-surface-container-high">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Logout</span>
                </button>
            </form>

        </div>
    </div>
</aside>
