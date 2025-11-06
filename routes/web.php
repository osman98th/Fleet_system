<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\FuelController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BookingController;

// Public Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// Protected Routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/filter-fuel', [DashboardController::class, 'filterFuel'])->name('dashboard.filterFuel');

    // Vehicles CRUD
    Route::resource('vehicles', VehicleController::class);

    // Drivers CRUD
    Route::resource('drivers', DriverController::class);

    // Assignments CRUD
    Route::resource('assignments', AssignmentController::class);

    // Fuels CRUD
    Route::resource('fuels', FuelController::class);

    // Fuel Reports
    Route::get('/reports/fuel', [ReportController::class, 'fuel'])->name('reports.fuel');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware(['auth'])->group(function() {

    // Booking CRUD
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

    // AJAX route to get fare based on car and type
    Route::get('/bookings/get-fare', [BookingController::class, 'getFare'])->name('bookings.getFare');
});


// Auth routes
require __DIR__.'/auth.php';
