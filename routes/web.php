<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CarPdfController;

Route::get('/', fn() => view('welcome'))->name('home');

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/cars', [CarController::class, 'index'])->name('cars.index');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | MY CARS
    |--------------------------------------------------------------------------
    */

    Route::get('/my-cars', [CarController::class, 'myCars'])->name('cars.my');

    /*
    |--------------------------------------------------------------------------
    | CREATE FLOW (RDW)
    |--------------------------------------------------------------------------
    */

    // stap 1: kenteken invoeren
    Route::get('/cars/create', [CarController::class, 'enterLicensePlate'])
        ->name('cars.enterLicensePlate');

    // stap 2: check RDW + session
    Route::post('/cars/check-license', [CarController::class, 'checkLicensePlate'])
        ->name('cars.checkLicensePlate');

    // stap 3: create form
    Route::get('/cars/create/form', [CarController::class, 'create'])
        ->name('cars.create');

    // opslaan
    Route::post('/cars', [CarController::class, 'store'])
        ->name('cars.store');

    /*
    |--------------------------------------------------------------------------
    | EDIT / UPDATE
    |--------------------------------------------------------------------------
    */

    Route::put('/cars/{car}', [CarController::class, 'update'])
        ->name('cars.update');

    Route::post('/cars/{car}/toggle-status', [CarController::class, 'toggleStatus'])
        ->name('cars.toggleStatus');

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    Route::delete('/cars/{car}', [CarController::class, 'destroy'])
        ->name('cars.destroy');

    /*
    |--------------------------------------------------------------------------
    | EXTRA
    |--------------------------------------------------------------------------
    */

    Route::get('/cars/{car}/pdf', [CarPdfController::class, 'download'])
        ->name('cars.pdf');

    Route::get('/cars/{car}', [CarController::class, 'show'])
        ->name('cars.show');

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

require __DIR__.'/auth.php';