        <?php
public function checkLicensePlate(Request $request)
{
    $request->validate([
        'license_plate' => 'required|string|max:20'
    ]);

    $licensePlate = strtoupper(str_replace('-', '', $request->license_plate));

    $url = "https://opendata.rdw.nl/resource/m9d7-ebf2.json?kenteken={$licensePlate}";
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if (empty($data)) {
        return back()->withErrors(['license_plate' => 'Kenteken niet gevonden in RDW']);
    }

    
    session([
        'car_api_data' => $data[0],
        'license_plate' => $licensePlate
    ]);

    return redirect()->route('cars.create');
}