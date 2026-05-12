@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="row align-items-stretch">

        {{-- AFBEELDING --}}
        <div class="col-md-6 mb-4">

            <div class="card shadow-sm h-100">

                <img 
                    src="{{ $car->image ? $car->image : asset('img/default-car.jpg') }}" 
                    style="height:100%; width:100%; object-fit:cover;"
                >

            </div>

        </div>

        {{-- INFO --}}
        <div class="col-md-6 mb-4">

            <div class="card shadow-sm h-100 p-4 d-flex flex-column justify-content-between">

                <div>

                    <h2 class="mb-2">
                        {{ $car->brand }} {{ $car->model }}
                    </h2>

                    <h4 class="text-primary mb-3">
                        € {{ number_format($car->price, 2) }}
                    </h4>

                    <p><strong>Kenteken:</strong> {{ $car->license_plate }}</p>
                    <p><strong>Kleur:</strong> {{ $car->color ?? '-' }}</p>
                    <p><strong>Bouwjaar:</strong> {{ $car->production_year ?? '-' }}</p>
                    <p><strong>Kilometerstand:</strong> {{ $car->mileage ?? 0 }}</p>
                    <p><strong>Stoelen:</strong> {{ $car->seats ?? '-' }}</p>
                    <p><strong>Deuren:</strong> {{ $car->doors ?? '-' }}</p>
                    <p><strong>Gewicht:</strong> {{ $car->weight ?? '-' }}</p>

                    <hr>

                    <p><strong>Views:</strong> {{ $car->views }}</p>

                    <p>
                        <strong>Status:</strong>
                        @if($car->status === 'sold')
                            <span class="badge bg-danger">Verkocht</span>
                        @else
                            <span class="badge bg-success">Te koop</span>
                        @endif
                    </p>

                    <p class="text-muted">
                        Aanbieder: {{ $car->user->name ?? 'Onbekend' }}
                    </p>

                </div>

                {{-- knop onderaan --}}
                <div class="mt-3">
                    <a href="{{ route('cars.index') }}" class="btn btn-secondary w-100">
                        ← Terug naar overzicht
                    </a>
                </div>

            </div>

        </div>

    </div>

</div>
@endsection