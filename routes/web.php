<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\VehicleAssignmentController;
use App\Http\Controllers\FuelRecordController;
use App\Http\Controllers\ReportController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('vehicles', VehicleController::class);
Route::resource('drivers', DriverController::class);
Route::resource('assignments', VehicleAssignmentController::class);
Route::resource('fuels', FuelRecordController::class);
Route::get('/reports/fuel', [ReportController::class, 'fuelReport'])->name('reports.fuel');

Route::get('/dashboard', function () {
return "Welcome to Dashboard";
})->middleware('auth.custom');

