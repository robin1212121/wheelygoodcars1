<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class CarController extends Controller
{
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

        $brand = $carData['merk'] ?? '';
        $model = $carData['handelsbenaming'] ?? '';
        $year = isset($carData['datum_eerste_toelating']) 
            ? substr($carData['datum_eerste_toelating'], 0, 4) 
            : '';

        return view('cars.create', compact('licensePlate', 'brand', 'model', 'year'));
    }
}