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
                    <th>Status</th>
                    <th>Views</th>
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

                    {{-- STATUS --}}
                    <td>
                        @if($car->status === 'sold')
                            <span class="badge bg-danger">Verkocht</span>
                        @else
                            <span class="badge bg-success">Te koop</span>
                        @endif
                    </td>

                    {{-- VIEWS --}}
                    <td>{{ $car->views ?? 0 }}</td>

                    <td class="d-flex gap-2">

                        {{-- VERKOCHT / TERUG TE KOOP --}}
                        <form action="{{ route('cars.toggleStatus', $car->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-sm btn-info">
                                {{ $car->status === 'sold' ? 'Terug zetten' : 'Verkocht' }}
                            </button>
                        </form>

                        {{-- VERWIJDEREN --}}
                        <form action="{{ route('cars.destroy', $car->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-warning btn-sm">
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