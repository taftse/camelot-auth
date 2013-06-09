<?php namespace T4s\CamelotAuth\Auth;

use T4s\CamelotAuth\Session\SessionInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;
use T4s\CamelotAuth\Database\DatabaseInterface;

use T4s\CamelotAuth\Auth\Oauth2Client\AbstractOauth2Provider;

use T4s\CamelotAuth\Auth\Local\Exceptions\AccountNotActiveException;
class Oauth2ClientAuth extends AbstractAuth{

	/**
	* The Oauth 2 Provider 
	*
	* @var use T4s\CamelotAuth\Auth\Oauth2Driver\ProviderInterface;
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
		$providerFile = __DIR__.'/Oauth2Client/Providers/'.ucfirst($providerName).'Oauth2Provider.php';
		if(!file_exists($providerFile))
		{
			throw new \Exception("Cannot Find the ".ucfirst($providerName)." Oauth2 provider");
		}

		include_once $providerFile;

		$providerClass = 'T4s\CamelotAuth\Auth\Oauth2Client\Providers\\'.ucfirst($providerName).'Oauth2Provider';
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

	public function authenticate(array $credentials = array(),$redirect_to = null,$remember = false, $login = true)
	{
		if(strpos($this->httpPath,"callback")=== false)
		{
			return $this->provider->authorize();
		}else{
			$token = $this->provider->callback();
			$userData = $this->provider->getUserInfo($token);

			$userData['provider'] = $this->provider->name;
			$user = $this->validateUser($userData,$remember);
			
		}
	}

	public function register(array $userDetails = array())
	{
		return $this->authenticate($userDetails);
	}

	protected function validateUser($userData,$remember = false)
	{
		//echo '<pre>';
		//var_dump($userData);
		// check to see if the oauth details match a db record
		$oauthUser = $this->database->createModel('oauth2User')->newQuery();
		$user = $oauthUser->where('provider','=',$userData['provider'])
				  ->where('user_id','=',$userData['user_id'])
				  ->where('username','=',$userData['username'])
				  ->with('account')->first();
	
		
		// if true create a new session 
		if(!is_null($user))
		{
			if(!$user->Account->isActive())
			{
				throw new AccountNotActiveException("This account is not active");
			}

			// update token 
			return $this->createSession($user->Account);
		}
		// else lets register a account
		else
		{
		
			$newOauthUser = $this->database->createModel('oauth2User');
			$newOauthUser->provider = $userData['provider'];
			$newOauthUser->username = $userData['username'];
			$newOauthUser->user_id = $userData['user_id'];
			$newOauthUser->token = $userData['token']->accessToken;
			
			// lets first check if the user is already logged in
			// and we just want to add this authentication method to the account
			if($this->check())
			{
				$newOauthUser->account_id = $this->user()->id;
				$newOauthUser->save();
				return $this->user();
			}else{
				
				// lets check if a user with the same email exists if yes throw exception
				if(!is_null($this->database->createModel('account')->where('email','=',$userData['email'])->first()))
				{
					// throw new user exists error
					throw new \Exception("a user with email address ".$userData['email']." already exists", 1);
				}
				

				$newUser = $this->database->createModel('account');
				$newUser->fill($userData);
				$newUser->save();

				$newOauthUser->account_id = $newUser->id;
				$newOauthUser->save();

				return $this->createSession($newUser);
			}

		}

	}

	public function getLoginButton()
	{
		
		return $this->provider->getLoginButton();
	}


}
