<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\FuelController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// All authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Vehicles CRUD
    Route::resource('vehicles', VehicleController::class);

    // Drivers CRUD
    Route::resource('drivers', DriverController::class);

    // Assignments CRUD
    Route::resource('assignments', AssignmentController::class);

    // Fuel Records CRUD
    // Route::resource('fuels', FuelController::class);

    // Fuel Reports
    Route::get('/reports/fuel', [ReportController::class, 'fuel'])->name('reports.fuel');

    // Profile routes (default Laravel Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
