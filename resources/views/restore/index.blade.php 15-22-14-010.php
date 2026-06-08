@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <section class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-secondary">User Profile</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-on-surface">Settings & Profile</h2>
                <p class="mt-2 max-w-2xl text-sm text-on-surface-variant">{{ $pageLead }}</p>
            </div>

            <button type="button" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                <span class="material-symbols-outlined text-[20px]">upload</span>
                Change Photo
            </button>
        </section>

        <section class="grid gap-6 lg:grid-cols-[0.95fr_1.05fr]">
            <article class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                <div class="flex flex-col items-center gap-4 text-center">
                    <div class="flex h-28 w-28 items-center justify-center rounded-full border-4 border-surface-container-highest bg-primary text-3xl font-bold text-white shadow-sm">
                        {{ $profile['initials'] }}
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-on-surface">{{ $profile['name'] }}</h3>
                        <p class="mt-1 text-sm text-on-surface-variant">{{ $profile['role'] }} • {{ $profile['department'] }}</p>
                    </div>
                </div>

                <div class="mt-6 rounded-2xl border border-outline-variant bg-surface-container-low p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Account Status</p>
                    <div class="mt-3">
                        <x-status-badge status="active" />
                    </div>
                </div>
            </article>

            <article class="space-y-6">
                <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                    <div class="flex items-center gap-2 border-b border-outline-variant pb-4">
                        <span class="material-symbols-outlined text-primary">person</span>
                        <h3 class="text-base font-semibold text-on-surface">Personal Information</h3>
                    </div>

                    <form class="mt-5 space-y-4">
                        <label class="block space-y-2">
                            <span class="text-sm font-semibold text-on-surface">Full Name</span>
                            <input type="text" value="{{ $profile['name'] }}" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                        </label>

                        <label class="block space-y-2">
                            <span class="text-sm font-semibold text-on-surface">Email</span>
                            <input type="email" value="{{ $profile['email'] }}" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                        </label>

                        <label class="block space-y-2">
                            <span class="text-sm font-semibold text-on-surface">WhatsApp Number</span>
                            <input type="text" value="{{ $profile['phone'] }}" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                        </label>
                    </form>
                </section>

                <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
                    <div class="flex items-center gap-2 border-b border-outline-variant pb-4">
                        <span class="material-symbols-outlined text-primary">lock</span>
                        <h3 class="text-base font-semibold text-on-surface">Security Preferences</h3>
                    </div>

                    <div class="mt-5 grid gap-4 md:grid-cols-2">
                        <div class="rounded-2xl border border-outline-variant bg-surface-container-low p-4">
                            <p class="text-sm font-semibold text-on-surface">Password</p>
                            <p class="mt-2 text-sm text-on-surface-variant">Last changed 28 days ago</p>
                        </div>
                        <div class="rounded-2xl border border-outline-variant bg-surface-container-low p-4">
                            <p class="text-sm font-semibold text-on-surface">Reminder Channel</p>
                            <p class="mt-2 text-sm text-on-surface-variant">WhatsApp enabled for daily notifications</p>
                        </div>
                    </div>
                </section>
            </article>
        </section>
    </div>
@endsection
