@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <section class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-secondary">User Management</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-on-surface">Edit User</h2>
                <p class="mt-2 max-w-2xl text-sm text-on-surface-variant">{{ $pageLead }}</p>
            </div>

            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant px-4 py-3 text-sm font-semibold text-on-surface transition hover:bg-surface-container">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                Back to Users
            </a>
        </section>

        @if (session('error'))
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                Please fix the highlighted fields below.
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
            @csrf
            @method('PUT')

            <div class="grid gap-5 md:grid-cols-2">
                <label class="space-y-2">
                    <span class="text-sm font-semibold text-on-surface">Name</span>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" required>
                    @error('name')
                        <p class="text-sm text-error">{{ $message }}</p>
                    @enderror
                </label>

                <label class="space-y-2">
                    <span class="text-sm font-semibold text-on-surface">Email</span>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" required>
                    @error('email')
                        <p class="text-sm text-error">{{ $message }}</p>
                    @enderror
                </label>

                <label class="space-y-2">
                    <span class="text-sm font-semibold text-on-surface">Role</span>
                    <select name="role" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" required>
                        <option value="">Select role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role }}" @selected(old('role', $user->role) === $role)>{{ ucfirst($role) }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <p class="text-sm text-error">{{ $message }}</p>
                    @enderror
                </label>

                <label class="space-y-2">
                    <span class="text-sm font-semibold text-on-surface">WhatsApp Number</span>
                    <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $user->whatsapp_number) }}" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                    @error('whatsapp_number')
                        <p class="text-sm text-error">{{ $message }}</p>
                    @enderror
                </label>

                <label class="space-y-2">
                    <span class="text-sm font-semibold text-on-surface">New Password</span>
                    <input type="password" name="password" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                    @error('password')
                        <p class="text-sm text-error">{{ $message }}</p>
                    @enderror
                </label>

                <label class="space-y-2">
                    <span class="text-sm font-semibold text-on-surface">Confirm New Password</span>
                    <input type="password" name="password_confirmation" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                </label>
            </div>

            <div class="mt-6 flex flex-wrap items-center justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant px-4 py-3 text-sm font-semibold text-on-surface transition hover:bg-surface-container">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                    <span class="material-symbols-outlined text-[20px]">save</span>
                    Update User
                </button>
            </div>
        </form>
    </div>
@endsection
