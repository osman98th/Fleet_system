<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use App\Models\FuelRecord;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Blade component registration
        Blade::component('layouts.app-layout', 'app-layout');

        // View composer to share totalExpense with all views
        View::composer('*', function ($view) {
            $totalExpense = FuelRecord::sum('cost'); // FuelRecord এর total cost
            $view->with('totalExpense', $totalExpense);
        });
    }
}
