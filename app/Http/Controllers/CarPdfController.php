<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CarPdfController extends Controller
{
    public function download(Request $request, Car $car)
    {
        abort_unless($car->user_id === $request->user()->id, 403);

        $pdf = Pdf::loadView('pdf.car', [
            'car' => $car,
            'user' => $request->user(),
        ]);

        return $pdf->download('car-' . $car->id . '.pdf');
    }
}