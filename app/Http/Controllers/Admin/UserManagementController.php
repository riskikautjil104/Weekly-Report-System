<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();
        $role = $request->string('role')->toString();
        $status = $request->string('status')->toString();

        $users = User::query()
            ->select(['id', 'name', 'email', 'role', 'whatsapp_number', 'email_verified_at', 'created_at', 'updated_at'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('whatsapp_number', 'like', "%{$search}%");
                });
            })
            ->when(in_array($role, ['admin', 'user'], true), fn ($query) => $query->where('role', $role))
            ->when($status === 'active', fn ($query) => $query->whereNotNull('email_verified_at'))
            ->when($status === 'pending', fn ($query) => $query->whereNull('email_verified_at'))
            ->orderBy('id')
            ->get()
            ->map(fn (User $user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'whatsapp_number' => $user->whatsapp_number ?: '-',
                'status' => $user->email_verified_at ? 'ACTIVE' : 'PENDING',
                'last_seen' => $user->updated_at?->diffForHumans() ?? '-',
            ]);

        return view('admin.users.index', [
            'pageTitle' => 'User Management',
            'pageLead' => 'Kelola akses, role, dan status anggota tim.',
            'users' => $users,
            'filters' => [
                'search' => $search,
                'role' => $role ?: 'all',
                'status' => $status ?: 'all',
                'roles' => ['all', 'admin', 'user'],
                'statuses' => ['all', 'active', 'pending'],
            ],
        ]);
    }

    public function create(): View
    {
        return view('admin.users.create', [
            'pageLead' => 'Tambahkan anggota baru dan atur hak aksesnya.',
            'roles' => ['admin', 'user'],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', Rule::in(['admin', 'user'])],
            'whatsapp_number' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User baru berhasil ditambahkan.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'pageLead' => 'Perbarui data user dan hak aksesnya.',
            'roles' => ['admin', 'user'],
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'role' => ['required', Rule::in(['admin', 'user'])],
            'whatsapp_number' => ['nullable', 'string', 'max:30'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (blank($validated['password'] ?? null)) {
            unset($validated['password']);
        }

        if ($request->user()->is($user) && $validated['role'] !== 'admin') {
            return back()
                ->withInput()
                ->with('error', 'Admin tidak bisa mengubah role akun yang sedang dipakai menjadi user.');
        }

        $user->update($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($request->user()->is($user)) {
            return back()->with('error', 'Admin tidak bisa menghapus akun yang sedang dipakai.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
