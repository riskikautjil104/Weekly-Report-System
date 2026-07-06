@extends('layouts.app')

@section('content')
<div class="container p-4">
    <h1 class="text-2xl font-semibold mb-4">Buat Weekly Plan</h1>

    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul>
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php $plan = null; @endphp
    <form action="{{ route('admin.weekly-plans.store') }}" method="POST">
        @include('admin.weekly_plans._form')
    </form>
</div>
@endsection
