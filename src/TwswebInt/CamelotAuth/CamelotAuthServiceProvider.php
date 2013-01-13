<?php namespace TwswebInt\CamelotAuth;

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
		$this->package('twsweb-int/camelot-auth');
	}

	/**
	 * Register the {{full_package}} service provider.
	 *
	 * @return void
	 */
	public function register()
	{

		$this->app['camelot'] = $this->app->share(function($app)
		{
			return new Camelot();
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