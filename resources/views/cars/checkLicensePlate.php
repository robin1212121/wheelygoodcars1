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

        $licensePlate = strtoupper(str_replace(['-', ' '], '', $request->license_plate));

        try {
            $url = "https://opendata.rdw.nl/resource/m9d7-ebf2.json?kenteken={$licensePlate}";
            $response = file_get_contents($url);

            if (!$response) {
                return back()->withErrors([
                    'license_plate' => 'RDW API niet bereikbaar'
                ]);
            }

            $data = json_decode($response, true);

            if (empty($data)) {
                return back()->withErrors([
                    'license_plate' => 'Kenteken niet gevonden in RDW'
                ]);
            }

            $carData = $data[0];

            // veilige mapping (RDW kan velden missen)
            $brand = $carData['merk'] ?? 'Onbekend';
            $model = $carData['handelsbenaming'] ?? 'Onbekend';

            $year = isset($carData['datum_eerste_toelating'])
                ? substr($carData['datum_eerste_toelating'], 0, 4)
                : null;

            // BELANGRIJK: ook andere data meenemen voor later gebruik
            session([
                'license_plate' => $licensePlate,
                'car_api_data' => $carData
            ]);

            return view('cars.create', compact(
                'licensePlate',
                'brand',
                'model',
                'year'
            ));

        } catch (\Exception $e) {
            return back()->withErrors([
                'license_plate' => 'Er ging iets mis met de RDW API'
            ]);
        }
    }
}