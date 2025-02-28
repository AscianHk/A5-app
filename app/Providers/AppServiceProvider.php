<?php

namespace App\Providers;

use App\Models\Fichero;
use App\Policies\FicheroPolicy;
use Illuminate\Support\ServiceProvider;

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
        //
    }

    protected $policies = [
        Fichero::class => FicheroPolicy::class,
    ];    


}

