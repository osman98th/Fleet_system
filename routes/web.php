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
use App\Http\Controllers\CostController;

// Public Welcome Page
Route::get('/', fn() => view('welcome'));

// Protected Routes
Route::middleware(['auth', 'verified'])->group(function () {

    /** --------------------------------
     * Dashboard
     * --------------------------------*/
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/filter-fuel', [DashboardController::class, 'filterFuel'])->name('dashboard.filterFuel');
    Route::get('/dashboard/filter-cost', [DashboardController::class, 'filterCost'])->name('dashboard.filterCost');

    /** --------------------------------
     * Resource Controllers
     * --------------------------------*/
    Route::resources([
        'vehicles'    => VehicleController::class,
        'drivers'     => DriverController::class,
        'assignments' => AssignmentController::class,
        'fuels'       => FuelController::class,
        'costs'       => CostController::class,
        'bookings'    => BookingController::class,
    ]);

    /** --------------------------------
     * Booking Extra Routes
     * --------------------------------*/
    Route::get('bookings/{booking}/invoice', [BookingController::class, 'invoice'])->name('bookings.invoice');
    Route::get('bookings/{booking}/download', [BookingController::class, 'downloadPDF'])->name('bookings.downloadPDF');
    Route::get('/bookings/get-fare', [BookingController::class, 'getFare'])->name('bookings.getFare');

    /** --------------------------------
     * Reports
     * --------------------------------*/
    // Fuel Reports
    Route::get('/reports/fuel', [ReportController::class, 'fuelReport'])->name('reports.fuel');
    Route::get('/reports/fuel/pdf', [ReportController::class, 'fuelReportPdf'])->name('reports.fuel.pdf');

    // Total Expense Reports
    Route::get('/reports/total-expense', [ReportController::class, 'totalExpense'])->name('reports.total_expense');
    Route::get('/reports/total-expense/pdf', [ReportController::class, 'totalExpensePdf'])->name('reports.total_expense.pdf');

    /** --------------------------------
     * Costs Extra Routes
     * --------------------------------*/
    Route::get('/cost-report/pdf', [CostController::class, 'pdf'])->name('costs.pdf');
    Route::get('/cost-chart', [CostController::class, 'chart'])->name('costs.chart');

    // Vehicle Profit Dashboard
    Route::get('/costs/vehicle-profit', [CostController::class, 'vehicleProfitDashboard'])
        ->name('costs.vehicleProfitDashboard');
    Route::get('/costs/vehicle-profit/pdf', [CostController::class, 'vehicleProfitPdf'])
        ->name('costs.vehicleProfitPdf');

    /** --------------------------------
     * Profile
     * --------------------------------*/
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth routes
require __DIR__ . '/auth.php';
