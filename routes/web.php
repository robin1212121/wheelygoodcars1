<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CarPdfController;
use App\Http\Controllers\AdminController;

Route::get('/', fn() => view('welcome'))->name('home');

Route::get('/cars', [CarController::class, 'index'])->name('cars.index');

Route::middleware('auth')->group(function () {

    Route::get('/admin/tags', [AdminController::class, 'tags'])
        ->name('admin.tags');

    Route::get('/admin/suspicious', [AdminController::class, 'suspiciousUsers'])
        ->name('admin.suspicious');

    Route::view('/admin/dashboard', 'admin.dashboard')
        ->name('admin.dashboard');

    Route::get('/admin/dashboard-data', [AdminController::class, 'dashboardData'])
        ->name('admin.dashboard.data');

    Route::get('/my-cars', [CarController::class, 'myCars'])
        ->name('cars.my');

    Route::get('/cars/create', [CarController::class, 'enterLicensePlate'])
        ->name('cars.enterLicensePlate');

    Route::post('/cars/check-license', [CarController::class, 'checkLicensePlate'])
        ->name('cars.checkLicensePlate');

    Route::get('/cars/create/form', [CarController::class, 'create'])
        ->name('cars.create');

    Route::post('/cars', [CarController::class, 'store'])
        ->name('cars.store');

    Route::get('/cars/{car}', [CarController::class, 'show'])
        ->name('cars.show');

    Route::put('/cars/{car}', [CarController::class, 'update'])
        ->name('cars.update');

    Route::post('/cars/{car}/toggle-status', [CarController::class, 'toggleStatus'])
        ->name('cars.toggleStatus');

    Route::delete('/cars/{car}', [CarController::class, 'destroy'])
        ->name('cars.destroy');

    Route::get('/cars/{car}/pdf', [CarPdfController::class, 'download'])
        ->name('cars.pdf');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

require __DIR__.'/auth.php';