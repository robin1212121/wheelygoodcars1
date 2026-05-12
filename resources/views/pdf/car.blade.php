<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Auto PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #111;
        }
        h1 {
            margin-bottom: 10px;
        }
        .box {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <h1>{{ $car->brand }} {{ $car->model }}</h1>

    <div class="box">
        <p><strong>Kenteken:</strong> {{ $car->license_plate }}</p>
        <p><strong>Prijs:</strong> € {{ number_format($car->price, 2) }}</p>
        <p><strong>Kleur:</strong> {{ $car->color ?? '-' }}</p>
        <p><strong>Bouwjaar:</strong> {{ $car->production_year ?? '-' }}</p>
        <p><strong>Kilometerstand:</strong> {{ $car->mileage ?? '-' }}</p>
    </div>

    <div class="box">
        <p><strong>Aanbieder:</strong> {{ $user->name }}</p>
    </div>

</body>
</html>