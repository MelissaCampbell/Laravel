<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FormatTimeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //hay que modificar esta funcion para que este servicio pueda cargar un helper
        //'/Helpers/FormatTime.php' es la ruta del helper que tiene que cargar
        require_once app_path().'/Helpers/FormatTime.php';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
