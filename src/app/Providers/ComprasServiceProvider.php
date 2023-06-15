<?php

namespace Liffe\Compras\App\Providers;

use Illuminate\Support\ServiceProvider;
use Liffe\Compras\Console\InstallCommand;
use Liffe\Compras\Console\UninstallCommand;
use Liffe\Compras\Console\UpdateCommand;

class ComprasServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->register(RouteServiceProvider::class);

        $this->publishes([
            __DIR__ . '/../../public/assets' => public_path('vendor/compras')
        ], 'compras-assets');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            InstallCommand::class,
            UpdateCommand::class,
            UninstallCommand::class,
        ]);
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'compras');
    }

}
