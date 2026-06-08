@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <section class="rounded-3xl border border-outline-variant bg-gradient-to-br from-surface-container-lowest via-surface-container-low to-surface-container p-6 shadow-sm">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex items-center gap-5">
                    <div class="flex h-20 w-20 items-center justify-center rounded-3xl bg-primary text-2xl font-bold text-white shadow-sm">
                        {{ $initials }}
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-secondary">Profile</p>
                        <h2 class="mt-2 text-3xl font-bold tracking-tight text-on-surface">{{ $user->name }}</h2>
                        <p class="mt-2 text-sm text-on-surface-variant">{{ ucfirst($user->role) }} · {{ $user->email }}</p>
                        @if ($user->whatsapp_number)
                            <p class="mt-1 text-sm text-on-surface-variant">WhatsApp: {{ $user->whatsapp_number }}</p>
                        @endif
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                        <span class="material-symbols-outlined text-[20px]">dashboard</span>
                        Back to Dashboard
                    </a>
                    <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-secondary transition hover:bg-surface-container-high">
                        <span class="material-symbols-outlined text-[20px]">description</span>
                        My Reports
                    </a>
                    @if ($whatsappLink)
                        <a href="{{ $whatsappLink }}" target="_blank" class="inline-flex items-center gap-2 rounded-xl border border-[#25D366]/30 bg-[#25D366]/10 px-4 py-3 text-sm font-semibold text-[#128C7E] transition hover:bg-[#25D366]/15">
                            <span class="material-symbols-outlined text-[20px]">chat</span>
                            Open WhatsApp
                        </a>
                    @endif
                </div>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-on-surface-variant">This Week</p>
                        <p class="mt-3 text-xl font-bold tracking-tight text-on-surface">{{ $summary['week_label'] }}</p>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-secondary-container text-primary">
                        <span class="material-symbols-outlined">event</span>
                    </div>
                </div>
                <p class="mt-4 text-sm text-on-surface-variant">Periode aktivitas yang sedang berjalan</p>
            </article>
            <x-stat-card label="Total Tasks" :value="$summary['total']" hint="Semua aktivitas yang kamu input" icon="task_alt" tone="primary" />
            <x-stat-card label="Selesai" :value="$summary['selesai']" hint="Task yang sudah ditutup" icon="check_circle" tone="success" />
            <x-stat-card label="Kendala" :value="$summary['kendala']" hint="Item yang butuh follow-up" icon="warning" tone="warning" />
        </section>

        <section class="grid gap-6 xl:grid-cols-[1.05fr_0.95fr]">
            <article class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                <div class="flex items-center gap-2 border-b border-outline-variant pb-4">
                    <span class="material-symbols-outlined text-primary">person</span>
                    <h3 class="text-base font-semibold text-on-surface">Personal Information</h3>
                </div>

                <form method="POST" action="{{ route('profile.update') }}" class="mt-5 space-y-4">
                    @csrf
                    @method('patch')

                    <label class="block space-y-2">
                        <span class="text-sm font-semibold text-on-surface">Full Name</span>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" required>
                        @error('name')
                            <p class="text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="block space-y-2">
                        <span class="text-sm font-semibold text-on-surface">Email</span>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" required>
                        @error('email')
                            <p class="text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="block space-y-2">
                        <span class="text-sm font-semibold text-on-surface">WhatsApp Number</span>
                        <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $user->whatsapp_number) }}" placeholder="+62..." class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                        @error('whatsapp_number')
                            <p class="text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </label>

                    <div class="flex items-center gap-4 pt-2">
                        <x-primary-button>Save Changes</x-primary-button>

                        @if (session('status') === 'profile-updated')
                            <p class="text-sm font-medium text-emerald-700">Saved.</p>
                        @endif
                    </div>
                </form>
            </article>

            <article class="space-y-6">
                <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                    <div class="flex items-center gap-2 border-b border-outline-variant pb-4">
                        <span class="material-symbols-outlined text-primary">lock</span>
                        <h3 class="text-base font-semibold text-on-surface">Security Preferences</h3>
                    </div>

                    <form method="POST" action="{{ route('password.update') }}" class="mt-5 space-y-4">
                        @csrf
                        @method('put')

                        <label class="block space-y-2">
                            <span class="text-sm font-semibold text-on-surface">Current Password</span>
                            <input type="password" name="current_password" autocomplete="current-password" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                            @error('current_password', 'updatePassword')
                                <p class="text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="block space-y-2">
                            <span class="text-sm font-semibold text-on-surface">New Password</span>
                            <input type="password" name="password" autocomplete="new-password" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                            @error('password', 'updatePassword')
                                <p class="text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="block space-y-2">
                            <span class="text-sm font-semibold text-on-surface">Confirm Password</span>
                            <input type="password" name="password_confirmation" autocomplete="new-password" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                            @error('password_confirmation', 'updatePassword')
                                <p class="text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </label>

                        <div class="flex items-center gap-4 pt-2">
                            <x-primary-button>Update Password</x-primary-button>

                            @if (session('status') === 'password-updated')
                                <p class="text-sm font-medium text-emerald-700">Saved.</p>
                            @endif
                        </div>
                    </form>
                </section>

                <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                    <div class="flex items-center gap-2 border-b border-outline-variant pb-4">
                        <span class="material-symbols-outlined text-primary">tips_and_updates</span>
                        <h3 class="text-base font-semibold text-on-surface">Quick Actions</h3>
                    </div>

                    <div class="mt-5 grid gap-3 md:grid-cols-2">
                        <a href="{{ route('activities.create') }}" class="rounded-2xl border border-outline-variant bg-surface-container-low p-4 transition hover:bg-surface-container-high">
                            <p class="text-sm font-semibold text-on-surface">Input activity today</p>
                            <p class="mt-2 text-sm text-on-surface-variant">Tambahkan log harian sebelum laporan mingguan ditutup.</p>
                        </a>
                        <a href="{{ route('reports.index') }}" class="rounded-2xl border border-outline-variant bg-surface-container-low p-4 transition hover:bg-surface-container-high">
                            <p class="text-sm font-semibold text-on-surface">Open my reports</p>
                            <p class="mt-2 text-sm text-on-surface-variant">Lihat rekap mingguan dan export yang sudah tersedia.</p>
                        </a>
                        <a href="{{ $whatsappLink ?? route('profile.edit') }}" class="rounded-2xl border border-outline-variant bg-surface-container-low p-4 transition hover:bg-surface-container-high md:col-span-2">
                            <p class="text-sm font-semibold text-on-surface">WhatsApp reminder</p>
                            <p class="mt-2 text-sm text-on-surface-variant">
                                @if ($whatsappNumber)
                                    Tersambung ke {{ $whatsappNumber }} untuk reminder harian dan follow-up cepat.
                                @else
                                    Isi nomor WhatsApp di profile supaya reminder bisa diarahkan ke chat.
                                @endif
                            </p>
                        </a>
                    </div>
                </section>
            </article>
        </section>
    </div>
@endsection
