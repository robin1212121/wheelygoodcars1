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
                    <th>Status</th>
                    <th>Acties</th>
                </tr>
            </thead>

            <tbody>
                @foreach($cars as $car)
                <tr>

                    <td>{{ $car->license_plate }}</td>
                    <td>{{ $car->brand }}</td>
                    <td>{{ $car->model }}</td>

                    {{-- ✔ prijs (bewerkbaar) --}}
                    <td>
                        <form action="{{ route('cars.update', $car) }}" method="POST" class="d-flex gap-1">
                            @csrf
                            @method('PUT')

                            <input type="number"
                                   name="price"
                                   value="{{ $car->price }}"
                                   class="form-control form-control-sm"
                                   style="width:100px;">

                    </td>

                    <td>{{ $car->color ?? '-' }}</td>
                    <td>{{ $car->production_year ?? '-' }}</td>
                    <td>{{ $car->mileage ?? 0 }}</td>

                    {{-- ✔ status --}}
                    <td>
                        <span class="badge {{ $car->status === 'sold' ? 'bg-danger' : 'bg-success' }}">
                            {{ $car->status === 'sold' ? 'Verkocht' : 'Te koop' }}
                        </span>
                    </td>

                    {{-- ACTIES --}}
                    <td class="d-flex gap-2">

                        {{-- OPSLAAN (prijs + status) --}}
                        <select name="status" class="form-select form-select-sm">
                            <option value="available" @selected($car->status=='available')>Te koop</option>
                            <option value="sold" @selected($car->status=='sold')>Verkocht</option>
                        </select>

                        <button class="btn btn-primary btn-sm">
                            Opslaan
                        </button>
                        </form>

                        {{-- PDF --}}
                        <a href="{{ route('cars.pdf', $car) }}" class="btn btn-secondary btn-sm">
                            PDF
                        </a>

                        {{-- VERWIJDEREN --}}
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