@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mijn aanbod</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($cars->count())
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Kenteken</th>
                    <th>Merk</th>
                    <th>Model</th>
                    <th>Prijs</th>
                    <th>Kleur</th>
                    <th>Bouwjaar</th>
                    <th>Km</th>
                    <th>Acties</th>
                </tr>
            </thead>

            <tbody>
                @foreach($cars as $car)
                <tr>
                    <td>{{ $car->license_plate }}</td>
                    <td>{{ $car->brand }}</td>
                    <td>{{ $car->model }}</td>
                    <td>€ {{ number_format($car->price, 2) }}</td>

                    <td>{{ $car->color ?? '-' }}</td>
                    <td>{{ $car->production_year ?? '-' }}</td>
                    <td>{{ $car->mileage ?? 0 }}</td>

                    <td class="d-flex gap-2">

                        {{-- PDF --}}
                        <a href="{{ route('cars.pdf', $car) }}" class="btn btn-primary btn-sm">
                            PDF
                        </a>

                        {{-- VERWIJDEREN (FIXED + duidelijker) --}}
                        <form action="{{ route('cars.destroy', $car->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Weet je zeker dat je deze auto wilt verwijderen?')">
                                Verwijderen
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    @else
        <p>Je hebt nog geen auto’s toegevoegd.</p>
    @endif
</div>
@endsection