<?php

namespace matyre73\LaravelApiExceptionHandler;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use matyre73\LaravelApiExceptionHandler\Exceptions\ApiExceptionHandler;

class ServiceProvider extends BaseServiceProvider
{
	/**
	 * [boot description]
	 * @return [type] [description]
	 */
    public function boot()
    {
    	parent::boot();

    	$this->publishes([realpath(__DIR__.'/../../config/exceptions.php') => config_path('exceptions.php')]);
    	$this->publishes([realpath(__DIR__.'/../../resources/lang/en/messages.php') => config_path('exceptions.php')]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    	$this->registerConfig();
    	$this->registerExceptionHandler();
    }

    /**
     * Register the configuration.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(realpath(__DIR__.'/../../config/exceptions.php'), 'exceptions');
    }

    /**
     * Register the exception handler.
     *
     * @return void
     */
    protected function registerExceptionHandler()
    {
        $this->app->singleton('api.exception', function ($app) {
            return (new ApiExceptionHandler($app['Illuminate\Contracts\Container\Container']))
                ->setExceptionConfigs(config('exceptions'));
        });
    }
}
