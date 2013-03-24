<?php namespace TwswebInt\CamelotAuth\AuthDrivers;

use TwswebInt\CamelotAuth\AuthDrivers\Oauth2Driver\ProviderInterface;

class Oauth2AuthDriver extends AuthDriver{

	/**
	* The Oauth 2 Provider 
	*
	* @var use TwswebInt\CamelotAuth\AuthDrivers\Oauth2Driver\ProviderInterface;
	*/
	protected $provider;

	public function __construct(SessionDriverInterface $session,CookieDriverInterface $cookie,DatabaseDriverInterface $database,$providerName,array $settings)
	{
		parent::__construct($session,$cookie,$database,$providerName,$settings);

		// load the provider here 
	}

	public function authenticate()
	{

	}

	public function register()
	{
		
	}
}