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
                    <td>
                        <form action="{{ route('cars.destroy', $car->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-warning btn-sm">Verwijderen</button>
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