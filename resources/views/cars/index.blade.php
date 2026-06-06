@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Alle auto's</h1>

   
    <div class="mb-3">
        <livewire:car-search />
    </div>

    @php
        $sortedCars = $cars->sortByDesc('views');
        $hotIds = $sortedCars->take(3)->pluck('id')->all();
    @endphp

    <div class="row mt-3">

        @foreach($sortedCars as $car)

            @php
                $isHot = in_array($car->id, $hotIds);
            @endphp

            <div class="mb-4 {{ $isHot ? 'col-md-6' : 'col-md-4' }}">

                <div class="card h-100
                    {{ $isHot ? 'shadow-lg border border-dark' : '' }}"
                     onclick="window.location='{{ route('cars.show', $car) }}'"
                     style="cursor:pointer;">

                    <img 
                        src="{{ $car->image ?: asset('img/default-car.jpg') }}" 
                        class="card-img-top" 
                        style="height:200px; object-fit:cover;"
                    >

                    <div class="card-body">

                        <h5 class="card-title">
                            {{ $car->brand }} {{ $car->model }}

                            @if($isHot)
                                <span class="badge bg-danger">🔥 Hot</span>
                            @endif
                        </h5>

                        <p>Kenteken: {{ $car->license_plate }}</p>
                        <p>Prijs: € {{ number_format($car->price, 2) }}</p>
                        <p>Kleur: {{ $car->color ?? '-' }}</p>
                        <p>Bouwjaar: {{ $car->production_year ?? '-' }}</p>
                        <p>Kilometerstand: {{ $car->mileage ?? 0 }}</p>

                        <p><strong>Views:</strong> {{ $car->views }}</p>

                        <p class="text-muted">
                            Aanbieder: {{ $car->user->name ?? 'Onbekend' }}
                        </p>

                        @auth
                            @if($car->user_id === auth()->id())
                                <form action="{{ route('cars.destroy', $car->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-warning btn-sm w-100"
                                            onclick="event.stopPropagation()">
                                        Verwijderen
                                    </button>
                                </form>
                            @endif
                        @endauth

                    </div>

                </div>

            </div>

        @endforeach

    </div>

</div>
@endsection