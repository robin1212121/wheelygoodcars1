@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Auto toevoegen</h1>

    <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Kenteken</label>
            <input type="text" class="form-control"
                   value="{{ session('license_plate') }}" readonly>
        </div>

        <div class="mb-3">
            <label>Merk</label>
            <input type="text" class="form-control"
                   value="{{ $carData['merk'] ?? '' }}" readonly>
        </div>

        <div class="mb-3">
            <label>Model</label>
            <input type="text" class="form-control"
                   value="{{ $carData['handelsbenaming'] ?? '' }}" readonly>
        </div>

        <div class="mb-3">
            <label>Bouwjaar</label>
            <input type="text" class="form-control"
                   value="{{ substr($carData['datum_eerste_toelating'] ?? '', 0, 4) }}" readonly>
        </div>

        <div class="mb-3">
            <label>Prijs</label>
            <input type="number" name="price" class="form-control" required>
        </div>

        <!-- 🔥 FOTO UPLOAD TOEGEVOEGD -->
        <div class="mb-3">
            <label>Foto van de auto</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <small class="text-muted">JPG, PNG of WEBP (max 4MB)</small>
        </div>

        <button class="btn btn-success">Opslaan</button>
    </form>
</div>
@endsection