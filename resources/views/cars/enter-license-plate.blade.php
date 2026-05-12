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

    <form action="{{ route('cars.checkLicensePlate') }}" method="POST" class="mt-4">
        @csrf

        <label class="mb-3">Kenteken</label>

        
        <div style="
            display:flex;
            align-items:center;
            width:520px;
            height:120px;
            border:4px solid #000;
            border-radius:14px;
            overflow:hidden;
            font-weight:bold;
            box-shadow:0 4px 12px rgba(0,0,0,0.2);
        ">

        
            <div style="
                width:90px;
                height:100%;
                background:#003399;
                color:white;
                display:flex;
                flex-direction:column;
                align-items:center;
                justify-content:center;
                font-size:14px;
            ">
                NL
                <span style="font-size:22px;">🇪🇺</span>
            </div>

            <div style="
                flex:1;
                height:100%;
                background:#f1c40f;
                display:flex;
                align-items:center;
                justify-content:center;
            ">
                <input type="text"
                       name="license_plate"
                       required
                       placeholder="AB123CD"
                       style="
                           width:100%;
                           height:100%;
                           border:none;
                           background:transparent;
                           text-align:center;
                           font-size:44px;
                           letter-spacing:8px;
                           font-weight:bold;
                           outline:none;
                           text-transform:uppercase;
                       ">
            </div>

        </div>

        <button type="submit" class="btn btn-primary mt-4">
            Volgende
        </button>
    </form>
</div>
@endsection