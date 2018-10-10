<?php

namespace App\Providers;

use App\Gestion;
use App\Periodo;
use App\Rciva;
use App\Laboral;
use App\Patronal;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\Resource;
//use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Resource::withoutWrapping();
        //Schema::defaultStringLength(191);

        /*Periodo::updated(function($periodo) {
            if ($periodo->cierre == 1) {
                $periodo->cierre_ufv = 24.54;
            } else {
                $periodo->cierre_ufv = 0;
            }
            $periodo->save();
        });*/
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
