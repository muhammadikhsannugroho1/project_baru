<?php

namespace Modules\Auth\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider{
    protected string $name = 'Auth';

    public function boot(): void{
        parent::boot();
    }

    /**
     * Define the routes for the application.
     */
    public function map(): void{
        $this->mapApiRoutes();
    }

    protected function mapApiRoutes(): void{
        Route::middleware('api')->prefix('api/v1')->name('api.v1.')->group(module_path($this->name, '/routes/api.php'));
    }
}
