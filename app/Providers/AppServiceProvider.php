<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * 說明：開發站開啟 barryvdh debugbar
         * ref：https://github.com/barryvdh/laravel-debugbar
         */
        if ($this->app->environment() == 'local') {
            $this->app->register('Barryvdh\Debugbar\ServiceProvider');
            /* 載入Monogo */
            $this->app->register('Jenssegers\Mongodb\MongodbServiceProvider');
            \DB::connection('mongodb')->enableQueryLog();
        }
    }
}
