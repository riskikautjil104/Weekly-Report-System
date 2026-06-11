@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-4">
    <div>
        <h1 class="text-2xl font-bold">Requirement Gathering Form</h1>
        <p class="text-sm text-on-surface-variant mt-1">Isi form di bawah selengkap mungkin agar requirement jelas sejak awal.</p>
    </div>

    <form method="POST" action="{{ route('requirements.store') }}">
        @csrf

        @include('requirements._form', [
            'requirement' => null,
            'categories' => $categories,
        ])

        <div class="mt-6 flex items-center gap-3">
            <button class="inline-flex items-center gap-2 rounded-xl bg-primary px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90" type="submit">
                <span class="material-symbols-outlined">send</span>
                Kirim untuk Review
            </button>

            <a href="{{ route('requirements.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-outline-variant bg-white px-5 py-3 text-sm font-semibold text-secondary shadow-sm transition hover:bg-surface-container-high">
                <span class="material-symbols-outlined">arrow_back</span>
                Kembali
            </a>
        </div>
    </form>
</div>
@endsection