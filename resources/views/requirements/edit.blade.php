@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-4">
    <div>
        <h1 class="text-2xl font-bold">Edit Requirement</h1>
        <p class="text-sm text-on-surface-variant mt-1">Lengkapi atau perbarui detail requirement.</p>
    </div>

    <form method="POST" action="{{ route('requirements.update', $requirement) }}">
        @csrf
        @method('PUT')

        @include('requirements._form', [
            'requirement' => $requirement,
            'categories' => $categories,
        ])

        {{-- Diskusi / Komentar (boleh diisi semua user) --}}
        <div class="mt-6 rounded-2xl border border-outline-variant bg-white p-6">
            <h2 class="text-lg font-bold mb-3" style="color: black">Diskusi / Catatan Tambahan</h2>
            <p>Tulis Komentas (opsional)</p>
            <x-input-label value="Tulis komentar (opsional)" />
            <textarea name="comment" rows="3" class="mt-2 w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 text-sm outline-none focus:border-primary"></textarea>
        </div>

        @if($isAdmin)
            <div class="mt-6 rounded-2xl border border-outline-variant bg-white p-6">
                <h2 class="text-lg font-bold mb-4">Status (Admin)</h2>
                <p>status</p>
                <x-input-label value="Status" />
                <select name="status" class="mt-2 w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 text-sm outline-none focus:border-primary">
                    @foreach($statuses as $s)
                        <option value="{{ $s }}" @selected(old('status', $requirement->status) === $s)>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <div class="mt-6 flex items-center gap-3">
            <button class="inline-flex items-center gap-2 rounded-xl bg-primary px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90" type="submit">
                <span class="material-symbols-outlined">save</span>
                Simpan
            </button>

            <a href="{{ route('requirements.show', $requirement) }}" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-5 py-3 text-sm font-semibold text-secondary shadow-sm transition hover:bg-surface-container-high">
                <span class="material-symbols-outlined">arrow_back</span>
                Batal
            </a>
        </div>
    </form>
</div>
@endsection