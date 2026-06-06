@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="mb-3">Alle auto's</h1>

    {{-- 🔍 LIVE SEARCH --}}
    <div class="mb-4">
        <livewire:car-search />
    </div>

    @php
        // check of er gezocht wordt via Livewire state (fallback veilig)
        $isSearching = request()->has('search');
        
        $carsCollection = $cars ?? collect();

        // Hot cars (top 3 op views)
        $hotCars = $carsCollection->sortByDesc('views')->take(3);

        // normale cars zonder hot duplicates
        $normalCars = $carsCollection->whereNotIn('id', $hotCars->pluck('id'));
    @endphp

    {{-- 🔥 HOT CARS --}}
    @if(!$isSearching && $hotCars->count())
        <h3 class="mb-3">🔥 Hot auto's</h3>

        <div class="row mb-4">
            @foreach($hotCars as $car)
                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-lg border border-danger"
                         onclick="window.location='{{ route('cars.show', $car) }}'"
                         style="cursor:pointer;">

                        <img src="{{ $car->image ?: asset('img/default-car.jpg') }}"
                             class="card-img-top"
                             style="height:200px; object-fit:cover;">

                        <div class="card-body">
                            <h5>
                                {{ $car->brand }} {{ $car->model }}
                                <span class="badge bg-danger">🔥 Hot</span>
                            </h5>

                            <p>€ {{ number_format($car->price, 2) }}</p>
                            <p><strong>Views:</strong> {{ $car->views }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif


    {{-- 🚗 NORMALE AUTO'S --}}
    <h3 class="mb-3">Alle auto's</h3>

    <div class="row">
        @foreach($normalCars as $car)
            <div class="col-md-4 mb-4">

                <div class="card h-100"
                     onclick="window.location='{{ route('cars.show', $car) }}'"
                     style="cursor:pointer;">

                    <img src="{{ $car->image ?: asset('img/default-car.jpg') }}"
                         class="card-img-top"
                         style="height:200px; object-fit:cover;">

                    <div class="card-body">

                        <h5>{{ $car->brand }} {{ $car->model }}</h5>

                        <p>Kenteken: {{ $car->license_plate }}</p>
                        <p>Prijs: € {{ number_format($car->price, 2) }}</p>
                        <p><strong>Views:</strong> {{ $car->views }}</p>

                        <p class="text-muted">
                            {{ $car->user->name ?? 'Onbekend' }}
                        </p>

                    </div>
                </div>

            </div>
        @endforeach
    </div>

    {{-- 📄 PAGINATION --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $cars->links() }}
    </div>

</div>
@endsection