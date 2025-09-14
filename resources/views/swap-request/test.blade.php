@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Test - SwapRequest Create</h2>

    {{-- Formulario para probar el método create --}}
    <form action="{{ route('swap-request.create') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="desired_item_id" class="form-label">Desired Item ID</label>
            <input type="number" name="desired_item_id" id="desired_item_id" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-custom">
            Probar Create
        </button>
    </form>
</div>
@endsection
