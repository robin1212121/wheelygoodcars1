@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Auto toevoegen</h1>

    <div class="progress-container mb-4">
        <div class="progress-info">
            <span id="stepText"></span>
        </div>

        <div class="progress-bar-bg">
            <div id="progressBar" class="progress-bar"></div>
        </div>
    </div>

    <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @php
            $carData = session('car_api_data', []);
        @endphp

        <div class="mb-3">
            <label>Kenteken</label>
            <input type="text" class="form-control"
                   value="{{ session('license_plate') ?? '' }}" readonly>
        </div>

        <div class="mb-3">
            <label>Merk</label>
            <input type="text" class="form-control"
                   value="{{ $carData['merk'] ?? 'Onbekend' }}" readonly>
        </div>

        <div class="mb-3">
            <label>Model</label>
            <input type="text" class="form-control"
                   value="{{ $carData['handelsbenaming'] ?? 'Onbekend' }}" readonly>
        </div>

        <div class="mb-3">
            <label>Bouwjaar</label>
            <input type="text" class="form-control"
                   value="{{ isset($carData['datum_eerste_toelating']) ? substr($carData['datum_eerste_toelating'], 0, 4) : '' }}"
                   readonly>
        </div>

        <div class="mb-3">
            <label>Prijs</label>
            <input type="number" name="price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Kilometerstand</label>
            <input type="number" name="mileage" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Foto van de auto</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <button class="btn btn-success">Opslaan</button>
    </form>

</div>

<script>
let currentStep = 2;
let totalSteps = 2;

function updateProgress() {
    let percentage = (currentStep / totalSteps) * 100;

    document.getElementById('progressBar').style.width = percentage + '%';
    document.getElementById('stepText').innerText =
        'Stap ' + currentStep + ' van ' + totalSteps;
}

updateProgress();
</script>

@endsection