<?php namespace TwswebInt\CamelotAuth;

use Illuminate\Support\ServiceProvider;
use Config;

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
			return new Camelot($this->app);
		});
		//var_dump($this->app['config']);
		var_dump(Config::get('camelot::camelot.provider_routing'));
		var_dump(Config::get('camelot::Camelot.provider_routing'));
		var_dump(Config::get('Camelot::camelot.provider_routing'));
		var_dump(Config::get('Camelot::Camelot.provider_routing'));
		var_dump(Config::get('CamelotAuth::camelot.provider_routing'));
		var_dump(Config::get('CamelotAuth::Camelot.provider_routing'));
		var_dump(Config::get('camelotauth::camelot.provider_routing'));
		var_dump(Config::get('camelotauth::Camelot.provider_routing'));

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