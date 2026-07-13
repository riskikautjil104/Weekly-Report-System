@props([
    'action',
    'filters',
    'users' => collect(),
    'showUserFilter' => false,
    'showExport' => false,
])

<section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
    <form method="GET" action="{{ $action }}" id="overtime-filter-form" class="space-y-4">
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <label class="space-y-2">
                <span class="text-sm font-semibold text-on-surface">Periode</span>
                <select name="filter_type" id="filter_type" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                    <option value="day" @selected($filters['filter_type'] === 'day')>Harian</option>
                    <option value="week" @selected($filters['filter_type'] === 'week')>Mingguan</option>
                    <option value="month" @selected($filters['filter_type'] === 'month')>Bulanan</option>
                    <option value="range" @selected($filters['filter_type'] === 'range')>Custom Range</option>
                </select>
            </label>

            <label class="space-y-2 filter-field filter-day {{ $filters['filter_type'] === 'day' ? '' : 'hidden' }}">
                <span class="text-sm font-semibold text-on-surface">Tanggal</span>
                <input type="date" name="tanggal" value="{{ $filters['tanggal'] ?: now()->toDateString() }}" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
            </label>

            <label class="space-y-2 filter-field filter-week {{ $filters['filter_type'] === 'week' ? '' : 'hidden' }}">
                <span class="text-sm font-semibold text-on-surface">Minggu (pilih tanggal)</span>
                <input type="date" name="minggu" value="{{ $filters['minggu'] ?: now()->toDateString() }}" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
            </label>

            <label class="space-y-2 filter-field filter-month {{ $filters['filter_type'] === 'month' ? '' : 'hidden' }}">
                <span class="text-sm font-semibold text-on-surface">Bulan</span>
                <input type="month" name="bulan" value="{{ $filters['bulan'] ?: now()->format('Y-m') }}" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
            </label>

            <label class="space-y-2 filter-field filter-range {{ $filters['filter_type'] === 'range' ? '' : 'hidden' }}">
                <span class="text-sm font-semibold text-on-surface">Dari Tanggal</span>
                <input type="date" name="date_from" value="{{ $filters['date_from'] }}" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
            </label>

            <label class="space-y-2 filter-field filter-range {{ $filters['filter_type'] === 'range' ? '' : 'hidden' }}">
                <span class="text-sm font-semibold text-on-surface">Sampai Tanggal</span>
                <input type="date" name="date_to" value="{{ $filters['date_to'] }}" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
            </label>

            @if ($showUserFilter)
                <label class="space-y-2">
                    <span class="text-sm font-semibold text-on-surface">User</span>
                    <select name="user_id" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                        <option value="">Semua User</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @selected((string) $filters['user_id'] === (string) $user->id)>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </label>
            @endif

            <label class="space-y-2">
                <span class="text-sm font-semibold text-on-surface">Status</span>
                <select name="status" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                    <option value="all" @selected($filters['status'] === 'all')>Semua Status</option>
                    <option value="submitted" @selected($filters['status'] === 'submitted')>Menunggu</option>
                    <option value="approved" @selected($filters['status'] === 'approved')>Disetujui</option>
                    <option value="rejected" @selected($filters['status'] === 'rejected')>Ditolak</option>
                </select>
            </label>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                <span class="material-symbols-outlined text-[20px]">filter_alt</span>
                Terapkan Filter
            </button>
            <a href="{{ $action }}" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-secondary transition hover:bg-surface-container-high">
                Reset
            </a>

            @if ($showExport)
                <a href="{{ route('admin.overtime.export', request()->query()) }}" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-secondary transition hover:bg-surface-container-high">
                    <span class="material-symbols-outlined text-[20px]">file_download</span>
                    Export Excel
                </a>
                <a href="{{ route('admin.overtime.print', request()->query()) }}" target="_blank" class="inline-flex items-center gap-2 rounded-xl bg-secondary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                    <span class="material-symbols-outlined text-[20px]">picture_as_pdf</span>
                    Export PDF
                </a>
            @endif
        </div>
    </form>

    <div class="mt-4 rounded-xl border border-outline-variant bg-surface-container-low p-4">
        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Periode Aktif</p>
        <p class="mt-2 text-sm font-semibold text-on-surface">{{ $filters['period_label'] }}</p>
    </div>
</section>

<script>
    (function () {
        const filterType = document.getElementById('filter_type');
        if (!filterType) return;

        function toggleFields() {
            const type = filterType.value;
            document.querySelectorAll('.filter-field').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.filter-' + type).forEach(el => el.classList.remove('hidden'));
        }

        filterType.addEventListener('change', toggleFields);
        toggleFields();
    })();
</script>
