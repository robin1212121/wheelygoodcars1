@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Auto toevoegen</h1>

    <form action="{{ route('cars.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Kenteken</label>
            <input type="text" name="license_plate" class="form-control" value="{{ $licensePlate }}" readonly>
        </div>

        <div class="mb-3">
            <label>Merk</label>
            <input type="text" name="brand" class="form-control" value="{{ $brand }}" readonly>
        </div>

        <div class="mb-3">
            <label>Model</label>
            <input type="text" name="model" class="form-control" value="{{ $model }}" readonly>
        </div>

        <div class="mb-3">
            <label>Bouwjaar</label>
            <input type="text" name="year" class="form-control" value="{{ $year }}" readonly>
        </div>

        <div class="mb-3">
            <label>Prijs</label>
            <input type="number" name="price" class="form-control" required>
        </div>

        <button class="btn btn-success">Opslaan</button>
    </form>
</div>
@endsection