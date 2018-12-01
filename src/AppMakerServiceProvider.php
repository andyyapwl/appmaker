<?php

namespace SimpleCom\AppMaker;

use Illuminate\Support\ServiceProvider;

class AppMakerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/appmaker.php' => config_path('appmaker.php'),
        ]);

        $this->publishes([
            __DIR__ . '/stubs/' => base_path('resources/appmaker/'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands(
            'SimpleCom\AppMaker\Commands\CrudCommand',
            'SimpleCom\AppMaker\Commands\CrudControllerCommand',
            'SimpleCom\AppMaker\Commands\CrudModelCommand',
            'SimpleCom\AppMaker\Commands\CrudMigrationCommand',
            'SimpleCom\AppMaker\Commands\CrudViewCommand',
            'SimpleCom\AppMaker\Commands\CrudLangCommand',
            'SimpleCom\AppMaker\Commands\CrudApiCommand',
            'SimpleCom\AppMaker\Commands\CrudApiControllerCommand'
        );
    }
}
