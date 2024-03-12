<?php

namespace App\Providers;

use App\Services\BarangService;
use App\Services\BarangServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    // auto dependency injection
    public $bindings = [
        BarangServiceInterface::class => BarangService::class,
    ];
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
        //
    }
}
