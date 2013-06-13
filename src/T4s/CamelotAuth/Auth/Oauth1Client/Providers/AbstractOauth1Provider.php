<?php namespace T4s\CamelotAuth\Auth\Oauth1Client\Providers;

use T4s\CamelotAuth\Session\SessionInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;
use T4s\CamelotAuth\Database\DatabaseInterface;
use T4s\CamelotAuth\Auth\Oauth1Client\Requests\AbstractRequest;

abstract class AbstractOauth1Provider
{

		/** 
		 * Protocol Version
		 *
		 * @var string
		 */
		public $version = '1.0';

		/**
		 * the name of the identity provider
		 *
		 * @var string
		 */
		public $name;

		/**
    	* The Session Driver used by Camelot
    	*
    	* @var use T4s\CamelotAuth\Session\SessionInterface;
    	*/
   		protected $session;
	
		/**
		* The Cookie Driver used by Camelot
		*
		* @var use T4s\CamelotAuth\Cookie\CookieInterface;
		*/
		protected $cookie;

		/**
		* signature type
		* @var string 
		*/
		protected $signature = 'HMAC-SHA1';

		/**
		 * all the requested scopes
		 *
		 * @var array | string
		 */

		protected $scopes = array();

		/**
		 * the scope seperator that should be used (specified by the provider)
		 *
	 	 * @var  string  
	 	 */
		protected $scopeSeperator = ',';

		/**
		 * any addtional parameters to be used for remote request
		 *
		 * @var array
		 */
		protected $params = array();

		/**
		 * the method used to request tokens (default GET)
		 *
		 * @var string
		 */
		protected $method = 'GET';

		/**
		 * an array used to map the recieved data to the accepted camelot data
		 *
		 * @var array
		 */
		protected $userDataMap = array();

		protected $clientID ='';

		protected $clientSecret ='';

		public function __construct(SessionInterface $session,CookieInterface $cookie,DatabaseInterface $database,array $settings,$httpPath)
		{
			$this->session = $session;
			$this->cookie = $cookie;

			if(!$this->name)
			{
				$this->name = strtolower(substr(join('',array_slice(explode('\\', get_class($this)), -1)),0,-strlen('oauth1provider')));//strtolower(substr(get_class($this), strlen('oauth2provider')));
			}

			if (empty($settings['clientID']))
			{
				throw new \Exception('Required option not provided: clientID');
			}

			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

			$this->callbackUrl = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$this->callbackUrl = rtrim($this->callbackUrl , '/');
			if(strpos($this->callbackUrl,'?')!== false)
			{
				$this->callbackUrl = substr($this->callbackUrl, 0, strrpos($this->callbackUrl, '?'));
				
			}
			
			foreach ($settings as $setting => $value) {
            	if (isset($this->{$setting})) {
              		$this->{$setting} = $value;
            	}
        	}

		}


		protected function loadSignature($signatureName,AbstractRequest $request)
		{
			$signatureName = str_replace('-', '', $signatureName);

			$signatureFile = __DIR__.'/../Signatures/'.$signatureName.'Signature.php';
			if(!file_exists($signatureFile))
			{
				throw new \Exception("Cannot Find the ".$signatureName." Signer file");
			}
			include_once $signatureFile;

			$signatureClass = 'T4s\CamelotAuth\Auth\Oauth1Client\Signatures\\'.$signatureName.'Signature';
			if(!class_exists($signatureClass,false))
			{
				throw new \Exception("Cannot Find the Signature class (".$signatureName."Signature)");
			}

			return new $signatureClass($request , $this->clientSecret);				
		}

		protected function newRequest($requestName,$method,$url,array $parameters = array())
		{
			$requestFile = __DIR__.'/../Requests/'.$requestName.'Request.php';
			if(!file_exists($requestFile))
			{
				throw new \Exception("Cannot Find the ".$requestName." Request file");
			}
			include_once $requestFile;

			$requestClass = 'T4s\CamelotAuth\Auth\Oauth1Client\Requests\\'.$requestName.'Request';
			if(!class_exists($requestClass,false))
			{
				throw new \Exception("Cannot Find the Request class (".$requestName."Request)");
			}

			return new $requestClass($method,$url,$parameters);	
		}
		/**
		 * Returns the Request Token URL for the provider.
		 *
		 * @return string
		 */
		abstract public function requestTokenUrl();

		/**
		 * Returns the authorization URL for the provider.
		 *
		 * @return string
		 */
		abstract public function authorizeUrl();


		/**
         * Returns the access token endpoint for the provider.
		 *
		 * @return string
		 */
		abstract public function accessTokenUrl();

		public function requestToken()
		{
				
				$request = $this->newRequest('RequestToken','GET',$this->requestTokenUrl(),array(
						'oauth_consumer_key' => $this->clientID,
						//'oauth_callback' => $this->callbackUrl,
						  //'scope'=>is_array($this->scopes) ? implode($this->scopeSeperator, $this->scopes) : $this->scopes,
						  ));

				$signature = $this->loadSignature('HMAC-SHA1',$request);

				$request->sign($signature);

				$request->execute();
			

			/*
			$request = new Oauth1Request('GET',$this->requestTokenUrl(),
				array(
					'oauth_consumer_key'=>$this->clientID,
					'oauth_callback'=>$this->callbackUrl,
					'scope'=>$this->scopes,
					));

			$request->sign($this->signature);*/
		}



		/**
		 * returns a users details as registred on the identity provider
		 * 
		 * @param T4s\CamelotAuth\Auth\Oauth2Driver\AccessToken
		 * 
		 * @return array
		 */
		abstract public function getUserInfo(AccessToken $token);

	}