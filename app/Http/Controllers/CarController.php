<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class CarController extends Controller
{
    public function index()
    {
        // 🔥 ALLEEN LADEN (NIET incrementen!)
        $cars = Car::with('user')
            ->latest()
            ->get();

        return view('cars.index', compact('cars'));
    }

    // 🔥 NIEUW: detail pagina (hier komt views)
    public function show(Car $car)
    {
        // 👀 views tellen per auto BEZOEK
        $car->increment('views');

        $car->load('user');

        return view('cars.show', compact('car'));
    }

    public function myCars()
    {
        $cars = Car::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('cars.my-cars', compact('cars'));
    }

    public function enterLicensePlate()
    {
        return view('cars.enter-license');
    }

    public function checkLicensePlate(Request $request)
    {
        $request->validate([
            'license_plate' => 'required|string|max:20'
        ]);

        $licensePlate = strtoupper(str_replace('-', '', $request->license_plate));

        $url = "https://opendata.rdw.nl/resource/m9d7-ebf2.json?kenteken={$licensePlate}";
        $response = @file_get_contents($url);

        if (!$response) {
            return back()->withErrors([
                'license_plate' => 'RDW API niet bereikbaar'
            ]);
        }

        $data = json_decode($response, true);

        if (empty($data) || !isset($data[0])) {
            return back()->withErrors([
                'license_plate' => 'Geen voertuig gevonden'
            ]);
        }

        session([
            'car_api_data' => $data[0],
            'license_plate' => $licensePlate
        ]);

        return redirect()->route('cars.create');
    }

    public function create()
    {
        $carData = session('car_api_data');

        if (!$carData) {
            return redirect()->route('cars.enterLicensePlate');
        }

        return view('cars.create', compact('carData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $carData = session('car_api_data');

        if (!$carData) {
            return redirect()->route('cars.enterLicensePlate')
                ->withErrors(['error' => 'Geen RDW data gevonden']);
        }

        $imageUrl = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            if ($file->isValid()) {

                $targetDir = public_path('img/cars');

                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0755, true);
                }

                $filename = uniqid('car_', true) . '.' . $file->getClientOriginalExtension();

                $file->move($targetDir, $filename);

                $imageUrl = '/img/cars/' . $filename;
            }
        }

        Car::create([
            'user_id' => auth()->id(),
            'license_plate' => session('license_plate'),

            'brand' => $carData['merk'] ?? 'Onbekend',
            'model' => $carData['handelsbenaming'] ?? 'Onbekend',

            'production_year' => isset($carData['datum_eerste_toelating'])
                ? substr($carData['datum_eerste_toelating'], 0, 4)
                : null,

            'price' => $request->price,

            'mileage' => 0,
            'seats' => $carData['aantal_zitplaatsen'] ?? null,
            'doors' => $carData['aantal_deuren'] ?? null,
            'weight' => $carData['massa_rijklaar'] ?? null,
            'color' => $carData['eerste_kleur'] ?? null,

            'image' => $imageUrl,

            'views' => 0,
        ]);

        session()->forget([
            'car_api_data',
            'license_plate'
        ]);

        return redirect()->route('cars.my')
            ->with('success', 'Auto toegevoegd!');
    }

    public function destroy(Car $car)
    {
        $car->delete();

        return redirect()->route('cars.my')
            ->with('success', 'Auto verwijderd!');
    }
}