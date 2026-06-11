@extends('layouts.app')

@section('content')
@php
    $statusColors = [
        'draft' => 'bg-gray-100 text-gray-700 border-gray-200',
        'submitted' => 'bg-blue-50 text-blue-700 border-blue-200',
        'need_clarification' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
        'approved' => 'bg-green-50 text-green-700 border-green-200',
        'rejected' => 'bg-red-50 text-red-700 border-red-200',
    ];
@endphp

<div class="flex flex-col gap-4">
    <div>
        <h1 class="text-2xl font-bold">Requirement Gathering</h1>
        <p class="text-sm text-on-surface-variant mt-1">Kelola requirement, diskusi, dan download PDF untuk setiap request.</p>
    </div>

    @if (session('success'))
        <div class="p-3 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm">{{ session('success') }}</div>
    @endif

    <div class="flex items-center justify-between gap-3">
        <a href="{{ route('requirements.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
            <span class="material-symbols-outlined">add</span>
            Buat Requirement
        </a>
    </div>

    <div class="rounded-2xl border border-outline-variant bg-white overflow-hidden">
        <div class="p-4 border-b border-outline-variant bg-surface-container-lowest">
            <div class="text-sm font-semibold text-secondary">Daftar Requirement</div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-left">
                <thead>
                    <tr class="text-xs uppercase tracking-wide text-on-surface-variant bg-surface-container-lowest">
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Judul</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Pengusul</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($requirements as $i => $r)
                    <tr class="border-t border-outline-variant hover:bg-surface-container-lowest/60 transition">
                        <td class="px-4 py-3 text-sm text-on-surface-variant">{{ $requirements->firstItem() + $i }}</td>
                        <td class="px-4 py-3 text-sm">
                            <a class="text-primary font-semibold hover:underline" href="{{ route('requirements.show', $r) }}">{{ $r->title }}</a>
                        </td>
                        <td class="px-4 py-3 text-sm text-on-surface-variant">{{ ucfirst(str_replace('_',' ', $r->category)) }}</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold border {{ $statusColors[$r->status] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                {{ ucfirst(str_replace('_',' ', $r->status)) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-on-surface-variant">{{ $r->user?->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-on-surface-variant">{{ $r->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex items-center gap-2">
                                <a class="inline-flex items-center gap-1.5 rounded-xl border border-outline-variant bg-white px-3 py-2 font-semibold text-secondary transition hover:bg-surface-container-high" href="{{ route('requirements.edit', $r) }}">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                    Edit
                                </a>
                                <a class="inline-flex items-center gap-1.5 rounded-xl border border-outline-variant bg-white px-3 py-2 font-semibold text-secondary transition hover:bg-surface-container-high" target="_blank" href="{{ route('requirements.print', $r) }}">
                                    <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                                    Print
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-sm text-on-surface-variant">
                            Belum ada requirement. Klik <span class="font-semibold">Buat Requirement</span> untuk mulai.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4">
            {{ $requirements->links() }}
        </div>
    </div>
</div>
@endsection