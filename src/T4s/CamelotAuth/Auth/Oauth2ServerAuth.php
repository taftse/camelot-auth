<?php namespace T4s\CamelotAuth\Auth;


use T4s\CamelotAuth\Event\DispatcherInterface;
use T4s\CamelotAuth\Session\SessionInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;
use T4s\CamelotAuth\Config\ConfigInterface;
use T4s\CamelotAuth\Database\DatabaseInterface;
use T4s\CamelotAuth\Messaging\MessagingInterface;

use T4s\CamelotAuth\Models\AccountInterface;


class Oauth2ServerAuth extends AbstractAuth implements AuthInterface{

	public function __construct($provider,ConfigInterface $config,SessionInterface $session,CookieInterface $cookie,DatabaseInterface $database,MessagingInterface $messaging,$path)
	{
			parent::__construct($provider,$config,$session,$cookie,$database,$messaging,$path);

			$this->applicationProvider = $this->database->loadRepository('Oauth2ServerApplication',$this->config->get('oauth2camelotserver.application_model'));
			$this->sessionProvider = $this->database->loadRepository('Oauth2ServerSession',$this->config->get('oauth2camelotserver.session_model'));

			
	}

	

	public function authenticate(array $credentials = null ,$remember = false, $login = true)
	{
		return $this->index($credentials);
	}


	public function index(array $credentials)
	{
		

		if(!isset($credentials['client_id']))
		{
			throw new \Exception("No client_id", 1);
		}	

		if(!isset($credentials['redirect_uri']))
		{
			throw new \Exception("no redirect_uri", 1);
		}

		if(!isset($credentials['response_type']) ||
			!in_array($credentials['response_type'], $this->config->get('oauth2camelotserver.response_type')))
		{
			throw new \Exception("missing or incorrect response_type", 1);
		}

		if(!$clientDetails = $this->applicationProvider->validateClient($credentials['client_id'],null,$credentials['redirect_uri']))
		{
			throw new Exception("un authorized client", 1);
		}
		
		$this->session->put($clientDetails,'oauth2_client_details');


		if(!isset($credentials['scope']))
		{
			throw new \Exception("missing parameter scope", 1);
			
		}
		
		$credentials['scope'] = explode(',', $credentials['scope']);
		
		if(count($credentials['scope']) >0)
		{
			$scopes = $this->config->get('oauth2camelotserver.scopes');
			foreach ($credentials['scope'] as $key) {
				if(!isset($scopes[$key]))
				{
					throw new \Exception("incorect scope perameter", 1);
				}
			}
		}
		


		if(!isset($credentials['state']))
		{
			$credentials['state'] = null;
		}

		$this->session->put($credentials,'oauth2_request_params');
		

		if($this->check(true))
		{
			return $this->redirectURI($this->config->get('oauth2camelotserver.authorize_uri'));
		}
	}

	public function authorize(array $credentials)
	{
		// is the user logged in
		$this->check(true);
		

		$client = $this->session->get('oauth2_client_details');
		$params	= $this->session->get('oauth2_request_params');
		
		if(is_null($client) && is_null($params))
		{
			throw new \Exception("no client details", 1);
		}

		if(isset($credentials['doauth']))
		{
			if($credentials['doauth'] == 'Deny')
			{

				$errorParameters['error'] = 'access_denied';
				$errorParameters['error_message'] = 'The resource owner or authorization server denied the request';
				if($params['state']){ $errorParameters['state']=$params['state'];}

				$this->session->forget('oauth2_request_params');
				$this->session->forget('oauth2_client_details');
				return $this->redirectURL($client['redirect_uri'],$errorParameters);
			}
			
			return $this->newRequest($this->user(),$client,$params);
		}
		
		if(($session = $this->validateAccessToken($this->user(),$client) )|| $client['auto_aprove'] == true)
		{
			
			if(!isset($session['access_token']))
			{
				$session['access_token'] = null;
			}
			return $this->newRequest($this->user(),$client,$params,$session['access_token']);
			
		}

		$view_data['name'] = $client['name'];
		$view_data['scopes'] = $this->getRequestedScopes($params['scope']);
		$view_data['post_uri'] = $this->config->get('oauth2camelotserver.authorize_uri');
		return $view_data;
	}

	private function newRequest(AccountInterface $account,$client,$parameters,$accessToken = null)
	{
		
		$params['code'] = $this->sessionProvider->createAuthCode($account->id,$client,$parameters['redirect_uri'],$parameters['scope'],$accessToken);
		$params['state']= $parameters['state'];
		return $this->redirectURL($parameters['redirect_uri'],$params);
	}	

	private function validateAccessToken(AccountInterface $account,$client)
	{
		$session = $this->sessionProvider->validateAccessToken($account->id,$client['client_id']);
		if(is_null($session))
			return false;

		var_dump($session);
		var_dump(\DB::getQueryLog());
		exit;
	}

	private function getRequestedScopes(array $scopes)
	{
		$scopesToReturn = array();
		$globalScopes = $this->config->get('oauth2camelotserver.scopes');
		foreach ($scopes as $key) {
			$scopesToReturn[$key] = $globalScopes[$key];
		}
		return $globalScopes;
	}
}