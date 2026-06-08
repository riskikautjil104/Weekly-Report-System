@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <section class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-secondary">User Management</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-on-surface">Manage Access & Roles</h2>
                <p class="mt-2 max-w-2xl text-sm text-on-surface-variant">{{ $pageLead }}</p>
            </div>

            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                <span class="material-symbols-outlined text-[20px]">person_add</span>
                Add New User
            </a>
        </section>

        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800">
                {{ session('error') }}
            </div>
        @endif

        <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
            <form method="GET" action="{{ route('admin.users.index') }}" class="grid gap-4 lg:grid-cols-[1.3fr_0.7fr_0.7fr_auto]">
                <label class="space-y-2">
                    <span class="text-sm font-semibold text-on-surface">Search User</span>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                        <input
                            type="text"
                            name="search"
                            value="{{ $filters['search'] ?? '' }}"
                            placeholder="Search by name, email, or WhatsApp..."
                            class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 pl-10 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
                        >
                    </div>
                </label>

                <label class="space-y-2">
                    <span class="text-sm font-semibold text-on-surface">Role</span>
                    <select name="role" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                        @foreach ($filters['roles'] as $role)
                            <option value="{{ $role }}" @selected(($filters['role'] ?? 'all') === $role)>
                                {{ ucfirst($role) }}
                            </option>
                        @endforeach
                    </select>
                </label>

                <label class="space-y-2">
                    <span class="text-sm font-semibold text-on-surface">Status</span>
                    <select name="status" class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                        @foreach ($filters['statuses'] as $status)
                            <option value="{{ $status }}" @selected(($filters['status'] ?? 'all') === $status)>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </label>

                <div class="flex items-end gap-3">
                    <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                        <span class="material-symbols-outlined text-[20px]">filter_alt</span>
                        Filter
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm font-semibold text-secondary transition hover:bg-surface-container-high">
                        Reset
                    </a>
                </div>
            </form>
        </section>

        <section class="rounded-2xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary">Users Table</p>
                    <h3 class="mt-1 text-xl font-bold text-on-surface">Daftar Anggota</h3>
                </div>
                <span class="rounded-full bg-surface-container px-3 py-1 text-xs font-semibold text-primary">{{ count($users) }} users</span>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-0">
                    <thead>
                        <tr class="text-left text-xs uppercase tracking-[0.18em] text-secondary">
                            <th class="border-b border-outline-variant px-4 py-3">Name</th>
                            <th class="border-b border-outline-variant px-4 py-3">Email</th>
                            <th class="border-b border-outline-variant px-4 py-3">Role</th>
                            <th class="border-b border-outline-variant px-4 py-3">WhatsApp</th>
                            <th class="border-b border-outline-variant px-4 py-3">Status</th>
                            <th class="border-b border-outline-variant px-4 py-3">Last Seen</th>
                            <th class="border-b border-outline-variant px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        @forelse ($users as $user)
                            <tr class="align-top hover:bg-surface-container transition-colors">
                                <td class="px-4 py-4 text-sm font-medium text-on-surface">{{ $user['name'] }}</td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $user['email'] }}</td>
                                <td class="px-4 py-4"><x-status-badge :status="$user['role']" /></td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $user['whatsapp_number'] }}</td>
                                <td class="px-4 py-4"><x-status-badge :status="$user['status']" /></td>
                                <td class="px-4 py-4 text-sm text-on-surface-variant">{{ $user['last_seen'] }}</td>
                                <td class="px-4 py-4 text-right">
                                    <div class="inline-flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.users.edit', $user['id']) }}" class="rounded-lg p-1.5 text-outline transition-colors hover:bg-primary-fixed hover:text-primary" aria-label="Edit user">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </a>

                                        <form method="POST" action="{{ route('admin.users.destroy', $user['id']) }}" onsubmit="return confirm('Hapus user ini?')" class="m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg p-1.5 text-outline transition-colors hover:bg-error-container hover:text-error" aria-label="Delete user">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-sm text-on-surface-variant">
                                    Tidak ada user yang cocok dengan filter saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
