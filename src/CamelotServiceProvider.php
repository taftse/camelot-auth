<?php namespace T4S\CamelotAuth;

use Illuminate\Support\ServiceProvider;
use T4S\CamelotAuth\Config\IlluminateConfig;
use T4S\CamelotAuth\Cookie\IlluminateCookie;
use T4S\CamelotAuth\Session\IlluminateSession;

class CamelotServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
        $this->publishes([
            __DIR__.'/../config/' => config_path(),
        ],'config');

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('/migrations')
        ], 'migrations');
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('camelot', function($app)
        {
            // Once the authentication service has actually been requested by the developer
            // we will set a variable in the application indicating such. This helps us
            // know that we need to set any queued cookies in the after event later.
            $app['camelot.loaded'] = true;
            return new CamelotManager(
                new IlluminateConfig($app['config']),
                New IlluminateCookie($app['request'],$app['cookie']),
                new IlluminateSession($app['session.store']),
                $app['request']->path()
            );
        });
	}

}
