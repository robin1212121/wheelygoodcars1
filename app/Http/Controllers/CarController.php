<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::with('user')
            ->where('status', 'available')
            ->latest()
            ->get();

        return view('cars.index', compact('cars'));
    }

    public function myCars()
    {
        $cars = Car::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('cars.my-cars', compact('cars'));
    }

    public function show(Car $car)
    {
        $car->increment('views');

        return view('cars.show', compact('car'));
    }

    public function enterLicensePlate()
    {
        return view('cars.enter-license-plate');
    }

    public function checkLicensePlate(Request $request)
    {
        $request->validate([
            'license_plate' => 'required|string|max:20'
        ]);

        $licensePlate = strtoupper(str_replace(['-', ' '], '', $request->license_plate));

        try {
            $url = "https://opendata.rdw.nl/resource/m9d7-ebf2.json?kenteken={$licensePlate}";
            $response = @file_get_contents($url);

            if (!$response) {
                return back()->withErrors([
                    'license_plate' => 'RDW API niet bereikbaar'
                ]);
            }

            $data = json_decode($response, true);

            if (empty($data)) {
                return back()->withErrors([
                    'license_plate' => 'Kenteken niet gevonden'
                ]);
            }

            session([
                'license_plate' => $licensePlate,
                'car_api_data' => $data[0]
            ]);

            return redirect()->route('cars.create');

        } catch (\Exception $e) {
            return back()->withErrors([
                'license_plate' => 'Er ging iets mis met de RDW API'
            ]);
        }
    }

    public function create()
    {
        $carData = session('car_api_data', []);
        return view('cars.create', compact('carData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
            'mileage' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $carData = session('car_api_data');

        if (!$carData) {
            return redirect()->route('cars.enterLicensePlate')
                ->withErrors(['error' => 'Geen RDW data gevonden']);
        }

       
        $mileage = preg_replace('/[^0-9]/', '', $request->mileage);
        $mileage = $mileage !== '' ? (int)$mileage : 0;

      
        $imageUrl = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            if ($file->isValid()) {
                $filename = uniqid('car_', true) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img/cars'), $filename);

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
            'mileage' => $mileage,

            'seats' => $carData['aantal_zitplaatsen'] ?? null,
            'doors' => $carData['aantal_deuren'] ?? null,
            'weight' => $carData['massa_rijklaar'] ?? null,
            'color' => $carData['eerste_kleur'] ?? null,

            'image' => $imageUrl,

            'views' => 0,
            'status' => 'available',
        ]);

        session()->forget(['car_api_data', 'license_plate']);

        return redirect()->route('cars.my')
            ->with('success', 'Auto toegevoegd!');
    }

    
    public function update(Request $request, Car $car)
    {
        if ($car->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,sold',
        ]);

        $car->update([
            'price' => $request->price,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Auto bijgewerkt!');
    }

    public function destroy(Car $car)
    {
        if ($car->user_id !== auth()->id()) {
            abort(403);
        }

        $car->delete();

        return back()->with('success', 'Auto verwijderd!');
    }
}