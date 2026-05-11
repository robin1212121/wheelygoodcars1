@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Auto gegevens toevoegen</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cars.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Kenteken:</label>
            <input type="text" name="license_plate" class="form-control" value="{{ $licensePlate }}" readonly>
        </div>

        <div class="form-group mt-2">
            <label>Merk:</label>
            <input type="text" name="brand" class="form-control" required>
        </div>

        <div class="form-group mt-2">
            <label>Model:</label>
            <input type="text" name="model" class="form-control" required>
        </div>

        <div class="form-group mt-2">
            <label>Prijs (€):</label>
            <input type="number" name="price" class="form-control" required>
        </div>

        <button class="btn btn-success mt-3">Opslaan</button>
    </form>
</div>
@endsection