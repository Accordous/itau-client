<?php

namespace Itau;

use Illuminate\Support\ServiceProvider;
use Itau\Http\ItauClient;

class ItauServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/itau.php', 'itau'
        );

        $this->app->singleton(ItauClient::class, function ($app) {
            return new ItauClient(config('itau'));
        });
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/itau.php' => config_path('itau.php'),
            ], 'config');
        }
    }
} 