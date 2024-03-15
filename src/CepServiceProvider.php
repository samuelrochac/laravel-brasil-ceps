<?php

namespace Samuelrochac\LaravelBrasilCeps;

use Illuminate\Support\ServiceProvider;

class CepServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('cepservice', function ($app) {
            return new CepService();
        });

        $this->commands([
            \Samuelrochac\LaravelBrasilCeps\Console\Commands\ImportAllData::class,
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Carregar rotas
        $this->loadRoutesFrom(__DIR__.'/Routes/api.php');

        // Se você tiver migrations
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');

        $this->mergeConfigFrom(
            __DIR__.'/Config/configs.php', 'brasil_ceps'
        );

        $this->publishes([
            __DIR__.'/config/configs.php' => config_path('brasil_ceps.php'),
        ], 'config');

    }
}
