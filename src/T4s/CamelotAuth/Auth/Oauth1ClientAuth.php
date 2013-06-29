<?php namespace T4s\CamelotAuth\Auth;

use T4s\CamelotAuth\Session\SessionInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;
use T4s\CamelotAuth\Database\DatabaseInterface;


class Oauth1ClientAuth extends AbstractAuth{

	/**
	* The Oauth 2 Provider 
	*
	* @var use T4s\CamelotAuth\Auth\Oauth1Driver\ProviderInterface;
	*/
	protected $provider;

	public static $version = '1.0';

	public function __construct(SessionInterface $session,CookieInterface $cookie,DatabaseInterface $database,$providerName,array $settings,$httpPath)
	{
		parent::__construct($session,$cookie,$database,$providerName,$settings,$httpPath);

		// load the provider here 
		if(isset($providerName)){
			$this->provider = $this->loadProvider($providerName);
		}

		if(function_exists('curl_version')==false)
		{
			throw new \Exception("The Oauth1 driver requires curl please install or enabe curl and try again");
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

		$providerClass = 'T4s\CamelotAuth\Auth\Oauth1Client\Providers\\'.ucfirst($providerName).'Oauth1Provider';
		if(!class_exists($providerClass,false))
		{
			throw new \Exception("Cannot Find the Provider class (".ucfirst($providerName)."Oauth1Provider)");
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
		if(strpos($this->httpPath,"callback")===false)
		{
			$requestToken = $this->provider->requestToken();

			$this->session->put(base64_encode(serialize($requestToken)),'oauth_token');

			$this->provider->authorize($requestToken);


		}
		else
		{

			if($this->session->get('oauth_token'))
			{
				$token = unserialize(base64_decode($this->session->get('oauth_token')));
			}

			parse_str(parse_url($_SERVER['REQUEST_URI'],PHP_URL_QUERY),$get);


			if(!empty($oken) AND $token['oauth_token']!== $get['oauth_token'])
			{
				$this->session->forget('oauth_token');
				throw new \Exception("Token does not match request token");
				
			}

			$token['oauth_verifier'] = $get['oauth_verifier'];

			$accessToken = $this->provider->accessToken($token);
			$accessToken['oauth_verifier'] = $token['oauth_verifier'];
			$userData = $this->provider->getUserInfo($accessToken);
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
		if(isset($this->events))
		{
			$this->events->fire('CamelotAuth.authenticated',array($this->provider->name,$userData));
		}
		
		$oauthUser = $this->database->createModel('oauthUser')->newQuery();
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
			$newOauthUser = $this->database->createModel('oauthUser');
			$newOauthUser->provider = $userData['provider'];
			$newOauthUser->username = $userData['username'];
			$newOauthUser->user_id = $userData['user_id'];
			$newOauthUser->token = $userData['token'];
			$newOauthUser->token_verifier =$userData['token_verifier'];
			
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
				
				$userData['status'] = $this->config['default_status'];

				if(isset($this->settings['default_status']))
				{
					$userData['status'] = $this->settings['default_status'];
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
}