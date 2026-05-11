@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Kenteken invoeren</h1>

    @if ($errors->any())
        <div class="alert alert-danger mt-2">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cars.checkLicensePlate') }}" method="POST" class="mt-3">
        @csrf
        <div class="form-group">
            <label for="license_plate">Kenteken:</label>
            <input type="text" name="license_plate" id="license_plate" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Volgende</button>
    </form>
</div>
@endsection