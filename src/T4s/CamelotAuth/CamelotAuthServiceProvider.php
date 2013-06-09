<?php namespace T4s\CamelotAuth;

use T4s\CamelotAuth\Session\IlluminateSession;
use T4s\CamelotAuth\Cookie\IlluminateCookie;
use Illuminate\Support\ServiceProvider;

class CamelotAuthServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;
	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('t4s/camelot-auth');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//$this->app['config']->package('twsweb-int/camelot-auth', __DIR__.'/../../config');
		//$app = $this->app;
		$this->app['camelot'] = $this->app->share(function($app)
		{
			return new Camelot(
				new IlluminateSession($app['session']),
				new IlluminateCookie($app['cookie']),
				$app['config']['camelot-auth::camelot'],
				$app['request']->path()
				);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('camelot');
	}

}