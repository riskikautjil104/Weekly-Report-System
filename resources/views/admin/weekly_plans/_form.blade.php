@csrf

<div class="p-4">
    <div class="grid grid-cols-1 gap-4">
        <div>
            <label class="block text-sm font-medium text-on-surface-variant">Week Start</label>
            <input type="date" name="week_start" value="{{ old('week_start', optional(optional($plan)->week_start)->toDateString() ?? '') }}" required class="w-full rounded-xl border border-outline px-3 py-2" />
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-sm text-on-surface-variant">Day</label>
                <input type="text" name="day" value="{{ old('day', optional($plan)->day ?? '') }}" class="w-full rounded-xl border border-outline px-3 py-2" />
            </div>
            <div>
                <label class="block text-sm text-on-surface-variant">Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', optional(optional($plan)->tanggal)->toDateString() ?? '') }}" class="w-full rounded-xl border border-outline px-3 py-2" />
            </div>
            <div>
                <label class="block text-sm text-on-surface-variant">Waktu</label>
                <input type="time" name="waktu" value="{{ old('waktu', optional($plan)->waktu ? substr(optional($plan)->waktu, 0, 5) : '') }}" class="w-full rounded-xl border border-outline px-3 py-2" />
            </div>
        </div>

        <div>
            <label class="block text-sm text-on-surface-variant">Title</label>
            <input type="text" name="title" value="{{ old('title', optional($plan)->title ?? '') }}" class="w-full rounded-xl border border-outline px-3 py-2" />
        </div>

        <div>
            <label class="block text-sm text-on-surface-variant">Description</label>
            <textarea name="description" class="w-full rounded-xl border border-outline px-3 py-2" rows="4">{{ old('description', optional($plan)->description ?? '') }}</textarea>
        </div>

        <div class="bg-blue-50 border-l-4 border-blue-400 p-3 rounded">
            <p class="text-sm text-blue-800">
                ✓ Weekly plan akan otomatis dikirim ke grup WhatsApp saat dibuat.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm">Simpan & Kirim ke WhatsApp</button>
            <a href="{{ route('admin.weekly-plans.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-2 text-sm font-semibold text-secondary">Batal</a>
        </div>
    </div>
</div>
