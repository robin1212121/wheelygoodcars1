<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CarPdfController;
Route::get('/', fn() => view('welcome'))->name('home');

// Publieke pagina: overzicht auto’s
Route::get('/cars', [CarController::class, 'index'])->name('cars.index');

Route::middleware('auth')->group(function () {

    // Mijn aanbod
    Route::get('/my-cars', [CarController::class, 'myCars'])->name('cars.my');

    /*
    |--------------------------------------------------------------------------
    | B1 FLOW (RDW API) - AANGEPAST OP JOUW STRUCTUUR
    |--------------------------------------------------------------------------
    */

    // Stap 1: Kenteken invoeren
    Route::get('/cars/create', [CarController::class, 'enterLicensePlate'])
        ->name('cars.enterLicensePlate');

    // Stap 2: RDW API call + session opslaan
    Route::post('/cars/check-license', [CarController::class, 'checkLicensePlate'])
        ->name('cars.checkLicensePlate');

    // Stap 3: formulier met RDW data tonen
    Route::get('/cars/create/form', [CarController::class, 'create'])
        ->name('cars.create');

    // Auto opslaan
    Route::post('/cars', [CarController::class, 'store'])
        ->name('cars.store');

    // Auto verwijderen
    Route::delete('/cars/{car}', [CarController::class, 'destroy'])
        ->name('cars.destroy');

    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
       

Route::get('/cars/{car}/pdf', [CarPdfController::class, 'download'])
    ->middleware('auth')
    ->name('cars.pdf');
   Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show');
});


require __DIR__.'/auth.php';