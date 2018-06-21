<?php

namespace matyre73\LaravelApiExceptionHandler;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use matyre73\LaravelApiExceptionHandler\Exceptions\ApiExceptionHandler;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Publish config and resource files.
         */
        $this->publishes([
            realpath(__DIR__ . '/config//exceptions.php') => config_path('exceptions.php'),
            realpath(__DIR__ . '/resources/lang/en/messages.php') => resource_path('lang/en/messages.php')
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
            ApiExceptionHandler::class
        );
    }
}
