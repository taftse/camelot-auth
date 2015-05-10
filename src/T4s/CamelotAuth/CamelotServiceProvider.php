<?php namespace T4s\CamelotAuth;

use Illuminate\Support\ServiceProvider;

class CamelotServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
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
            return new CamelotManager($app['request']->path());
        });
	}

}
