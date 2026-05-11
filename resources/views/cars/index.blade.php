@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Alle auto's</h1>
    <div class="row">
        @foreach($cars as $car)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    @if($car->photo)
                        <img src="{{ asset('storage/' . $car->photo) }}" class="card-img-top" alt="{{ $car->brand }} {{ $car->model }}">
                    @else
                        <img src="{{ asset('images/default-car.jpg') }}" class="card-img-top" alt="Geen afbeelding">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $car->brand }} {{ $car->model }}</h5>
                        <p class="card-text">Kenteken: {{ $car->license_plate }}</p>
                        <p class="card-text fw-bold">€ {{ number_format($car->price, 2) }}</p>
                        @auth
                            @if($car->user_id === auth()->id())
                                <form action="{{ route('cars.destroy', $car->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-warning btn-sm w-100">Verwijderen</button>
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