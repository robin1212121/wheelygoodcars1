<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class CarController extends Controller
{
    public function index()
    {
        // 👇 alleen beschikbare auto's op publieke site
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

        // IMAGE UPLOAD
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

            // ✔ FIX mileage veilig
            'mileage' => (isset($carData['tellerstand']) && is_numeric($carData['tellerstand']))
                ? (int) $carData['tellerstand']
                : 0,

            'seats' => $carData['aantal_zitplaatsen'] ?? null,
            'doors' => $carData['aantal_deuren'] ?? null,
            'weight' => $carData['massa_rijklaar'] ?? null,
            'color' => $carData['eerste_kleur'] ?? null,

            'image' => $imageUrl,

            'views' => 0,
            'status' => 'available',
        ]);

        session()->forget(['car_api_data', 'license_plate']);

        return redirect()
            ->route('cars.my')
            ->with('success', 'Auto toegevoegd!');
    }

    public function update(Request $request, Car $car)
    {
        // 🔒 alleen eigenaar mag aanpassen
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

    public function toggleStatus(Car $car)
    {
        if ($car->user_id !== auth()->id()) {
            abort(403);
        }

        $car->update([
            'status' => $car->status === 'sold' ? 'available' : 'sold'
        ]);

        return back();
    }
}