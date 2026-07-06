@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-4">
    <div>
        <h1 class="text-2xl font-bold">Weekly Plans</h1>
        <p class="text-sm text-on-surface-variant mt-1">Rencanakan kegiatan per minggu; buat jadwal harian dan waktu.</p>
    </div>

    @if(session('status'))
        <div class="p-3 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm">{{ session('status') }}</div>
    @endif

    <div class="flex items-center justify-between gap-3">
        <a href="{{ route('admin.weekly-plans.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
            <span class="material-symbols-outlined">add</span>
            Buat Weekly Plan
        </a>
    </div>

    <div class="rounded-2xl border border-outline-variant bg-white overflow-hidden">
        <div class="p-4 border-b border-outline-variant bg-surface-container-lowest">
            <div class="text-sm font-semibold text-secondary">Daftar Weekly Plan</div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-left">
                <thead>
                    <tr class="text-xs uppercase tracking-wide text-on-surface-variant bg-surface-container-lowest">
                        <th class="px-4 py-3">Week</th>
                        <th class="px-4 py-3">Day</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Waktu</th>
                        <th class="px-4 py-3">Title</th>
                        <th class="px-4 py-3">WA</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($plans as $plan)
                    <tr class="border-t border-outline-variant hover:bg-surface-container-lowest/60 transition">
                        <td class="px-4 py-3 text-sm">{{ $plan->week_start->translatedFormat('d M Y') }}</td>
                        <td class="px-4 py-3 text-sm">{{ $plan->day ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm">{{ optional($plan->tanggal)->translatedFormat('d M Y') ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm">
                            @if($plan->waktu)
                                {{ \Carbon\Carbon::parse($plan->waktu)->format('H:i') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm">{{ $plan->title ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm">
                            @if($plan->sent_to_whatsapp)
                                <span class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200">Sent</span>
                                <div class="text-xs text-on-surface-variant mt-1">{{ optional($plan->waha_sent_at)->translatedFormat('d M H:i') }}</div>
                            @elseif($plan->waha_send_error)
                                <span class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200">Error</span>
                            @else
                                <span class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex items-center gap-2">
                                <a class="inline-flex items-center gap-1.5 rounded-xl border border-outline-variant bg-white px-3 py-2 font-semibold text-secondary transition hover:bg-surface-container-high" href="{{ route('admin.weekly-plans.edit', $plan) }}">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                    Edit
                                </a>
                                <form action="{{ route('admin.weekly-plans.destroy', $plan) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl border border-outline-variant bg-white px-3 py-2 font-semibold text-secondary transition hover:bg-surface-container-high" onclick="return confirm('Hapus plan ini?')">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-sm text-on-surface-variant">Belum ada weekly plan. Klik <span class="font-semibold">Buat Weekly Plan</span> untuk mulai.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4">
            {{ $plans->links() }}
        </div>
    </div>
</div>
@endsection
