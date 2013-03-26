<?php namespace TwswebInt\CamelotAuth\AuthDrivers;

use TwswebInt\CamelotAuth\SessionDrivers\SessionDriverInterface;
use TwswebInt\CamelotAuth\CookieDrivers\CookieDriverInterface;
use TwswebInt\CamelotAuth\DatabaseDrivers\DatabaseDriverInterface;

use TwswebInt\CamelotAuth\AuthDrivers\Oauth2ClientDriver\AbstractOauth2Provider;

class Oauth2ClientAuthDriver extends AbstractAuthDriver{

	/**
	* The Oauth 2 Provider 
	*
	* @var use TwswebInt\CamelotAuth\AuthDrivers\Oauth2Driver\ProviderInterface;
	*/
	protected $provider;

	public function __construct(SessionDriverInterface $session,CookieDriverInterface $cookie,DatabaseDriverInterface $database,$providerName,array $settings,$httpPath)
	{
		parent::__construct($session,$cookie,$database,$providerName,$settings,$httpPath);

		// load the provider here 
		$this->provider = $this->loadProvider($providerName);
	}

	protected function loadProvider($providerName)
	{
		$providerFile = __DIR__.'/Oauth2ClientDriver/providers/'.ucfirst($providerName).'Oauth2Provider.php';
		if(!file_exists($providerFile))
		{
			throw new \Exception("Cannot Find the ".ucfirst($providerName)." Oauth2 provider");
		}

		include_once $providerFile;

		$providerClass = 'TwswebInt\CamelotAuth\AuthDrivers\Oauth2ClientDriver\providers\\'.ucfirst($providerName).'Oauth2Provider';
		if(!class_exists($providerClass,false))
		{
			throw new \Exception("Cannot Find the Provider class (".$providerName."Oauth2Provider)");
		}

		return $provider = new $providerClass(
				$this->session,
                $this->cookie,
                $this->database,
                $this->settings,
                $this->httpPath
                );
	}

	public function authenticate()
	{
		if(strpos($this->httpPath,"callback")=== false)
		{
			return $this->provider->authorize();
		}else{
			$token = $this->provider->callback();
			$userData = $this->provider->getUserInfo($token);

			$userData['IDProvider'] = $this->provider->name;
			return $this->validateUser($userData);
		}
	}

	public function register()
	{
		return $this->authenticate();
	}

	protected function validateUser($userData)
	{
		
	}
}