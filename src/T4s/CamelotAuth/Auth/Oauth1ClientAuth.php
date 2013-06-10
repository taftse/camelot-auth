<?php namespace T4s\CamelotAuth\Auth;

use T4s\CamelotAuth\Session\SessionInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;
use T4s\CamelotAuth\Database\DatabaseInterface;


class Oauth1ClientAuth extends AbstarctAuth{

	/**
	* The Oauth 2 Provider 
	*
	* @var use T4s\CamelotAuth\Auth\Oauth1Driver\ProviderInterface;
	*/
	protected $provider;

	public function __construct(SessionInterface $session,CookieInterface $cookie,DatabaseInterface $database,$providerName,array $settings,$httpPath)
	{
		parent::__construct($session,$cookie,$database,$providerName,$settings,$httpPath);

		// load the provider here 
		if(isset($providerName)){
			$this->provider = $this->loadProvider($providerName);
		}
	}

	protected function loadProvider($providerName)
	{
		$providerFile = __DIR__.'/Oauth1Client/Providers/'.ucfirst($providerName).'Oauth1Provider.php';
		if(!file_exists($providerFile))
		{
			throw new \Exception("Cannot Find the ".ucfirst($providerName)." Oauth1 provider");
		}

		include_once $providerFile;

		$providerClass = 'T4s\CamelotAuth\Auth\Oauth2Client\Providers\\'.ucfirst($providerName).'Oauth1Provider';
		if(!class_exists($providerClass,false))
		{
			throw new \Exception("Cannot Find the Provider class (".$providerName."Oauth1Provider)");
		}

		return $provider = new $providerClass(
				$this->session,
                $this->cookie,
                $this->database,
                $this->settings,
                $this->httpPath
                );
	}

	public function authenticate(array $credentials = array(),$redirect_to = null,$remember = false, $login = true)
	{
		
	}


}