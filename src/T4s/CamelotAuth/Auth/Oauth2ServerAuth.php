<?php namespace T4s\CamelotAuth\Auth;


use T4s\CamelotAuth\Event\DispatcherInterface;
use T4s\CamelotAuth\Session\SessionInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;
use T4s\CamelotAuth\Config\ConfigInterface;
use T4s\CamelotAuth\Database\DatabaseInterface;
use T4s\CamelotAuth\Messaging\MessagingInterface;


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
				return 'request denied';
			}
			$this->
			$this->newRequest($client,$params);
		}
	}

	private function newRequest()
	{
		//create new auth code
		/*client_id,
		account_id
		redirect_uri,
		scope*/

	}	
}