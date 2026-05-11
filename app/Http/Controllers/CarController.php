<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class CarController extends Controller
{
    // Publiek overzicht van auto's
    public function index()
    {
        $cars = Car::all();
        return view('cars.index', compact('cars'));
    }

    // Overzicht van ingelogde gebruiker
    public function myCars()
    {
        $cars = Car::where('user_id', auth()->id())->get();
        return view('cars.my-cars', compact('cars')); // check: bestand = my-cars.blade.php
    }

    // Stap 1: Kenteken invoeren
    public function enterLicensePlate()
    {
        return view('cars.enter-license');
    }

    // Stap 2: Kenteken checken + RDW info ophalen
    public function checkLicensePlate(Request $request)
    {
        $request->validate([
            'license_plate' => 'required|string|max:20'
        ]);

        $licensePlate = strtoupper(str_replace('-', '', $request->license_plate));

        // RDW API ophalen
        $url = "https://opendata.rdw.nl/resource/m9d7-ebf2.json?kenteken={$licensePlate}";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if (empty($data)) {
            return back()->withErrors(['license_plate' => 'Kenteken niet gevonden in RDW']);
        }

        $carData = $data[0];

        $brand = $carData['merk'] ?? 'Onbekend';
        $model = $carData['handelsbenaming'] ?? 'Onbekend';
        $year = isset($carData['datum_eerste_toelating']) && !empty($carData['datum_eerste_toelating'])
            ? substr($carData['datum_eerste_toelating'], 0, 4)
            : 'Onbekend';

        return view('cars.create', compact('licensePlate', 'brand', 'model', 'year'));
    }

    // Opslaan van auto
    public function store(Request $request)
    {
        $request->validate([
            'license_plate' => 'required|string|max:20',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        Car::create([
            'user_id' => auth()->id(),
            'license_plate' => strtoupper($request->license_plate),
            'brand' => $request->brand,
            'model' => $request->model,
            'price' => $request->price,
        ]);

        return redirect()->route('cars.my')->with('success', 'Auto succesvol toegevoegd!');
    }

    // Auto verwijderen
    public function destroy(Car $car)
    {
        $this->authorize('delete', $car); // optioneel: check dat de ingelogde gebruiker eigenaar is
        $car->delete();
        return redirect()->route('cars.my')->with('success', 'Auto verwijderd!');
    }
}