<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', fn() => view('welcome'))->name('home');

// Publieke pagina: overzicht auto’s
Route::get('/cars', [CarController::class, 'index'])->name('cars.index');

Route::middleware('auth')->group(function () {

    // Mijn aanbod
    Route::get('/my-cars', [CarController::class, 'myCars'])->name('cars.my');

    // Stap 1: Kenteken invoeren
    Route::get('/cars/create', [CarController::class, 'enterLicensePlate'])->name('cars.enterLicensePlate');

    // RDW API ophalen + doorgaan naar invulformulier
    Route::post('/cars/check-license', [CarController::class, 'checkLicensePlate'])->name('cars.checkLicensePlate');

    // Auto opslaan
    Route::post('/cars', [CarController::class, 'store'])->name('cars.store');

    // Auto verwijderen
    Route::delete('/cars/{car}', [CarController::class, 'destroy'])->name('cars.destroy');

    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

require __DIR__.'/auth.php';