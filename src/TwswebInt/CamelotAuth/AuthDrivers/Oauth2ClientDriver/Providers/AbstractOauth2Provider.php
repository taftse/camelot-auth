<?php namespace TwswebInt\CamelotAuth\AuthDrivers\Oauth2ClientDriver\Providers;

use TwswebInt\CamelotAuth\Session\SessionInterface;
use TwswebInt\CamelotAuth\CookieDrivers\CookieDriverInterface;
use TwswebInt\CamelotAuth\DatabaseDrivers\DatabaseDriverInterface;
use TwswebInt\CamelotAuth\AuthDrivers\Oauth2ClientDriver\AccessToken as AccessToken;

abstract class AbstractOauth2Provider
{
		/**
		 * the name of the identity provider
		 *
		 * @var string
		 */
		public $name;

		/**
		 * the clients id as provider by the identity provider
		 *
		 * @var string
		 */
		protected $clientID ='';

		/**
		 * the clients secret as provider by the identity provider
		 *
		 * @var string
		 */
		protected $clientSecret = '';

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
		 * @var string
		 */
		protected $params = array();

		/**
		 * the method used to request tokens (default GET)
		 *
		 * @var string
		 */
		protected $method = 'GET';

		/**
		 * the type of grant request we are sending
		 *
		 * @var string
		 */
		protected $grantType = 'authorization_code';

		/**
		 * should we prompt for approval?
		 *
		 * @var boolean
		 */
		protected $forceApproval = 'auto';

		/**
		 * the callback url for this site (automaticaly assumed)
		 *
		 * @var string
		 */
		public $callbackUrl = null;

		/**
		 * the name used for a uid used by the identity provider in the auth_token
		 *
		 * @var string
		 */
		protected $tokenUId = 'uid';

		/**
		 * the name used for the experation time used by the identity provider in the auth_token
		 *
		 * @var string 
		 */
		protected $tokenExpires = 'expires_in';

		/**
    	* The Session Driver used by Camelot
    	*
    	* @var use TwswebInt\CamelotAuth\Session\SessionInterface;
    	*/
   		protected $session;
	
		/**
		* The Cookie Driver used by Camelot
		*
		* @var use TwswebInt\CamelotAuth\CookieDrivers\CookieDriverInterface;
		*/
		protected $cookie;

		public function __construct(SessionInterface $session,CookieDriverInterface $cookie,DatabaseDriverInterface $database,array $settings,$httpPath)
		{	
			$this->session = $session;
			$this->cookie = $cookie;

			if(!$this->name)
			{
				$this->name = strtolower(substr(join('',array_slice(explode('\\', get_class($this)), -1)),0,-strlen('oauth2provider')));//strtolower(substr(get_class($this), strlen('oauth2provider')));
			}
			
			if (empty($settings['clientID']))
			{
				throw new \Exception('Required option not provided: clientID');
			}

			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

			$this->callbackUrl = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
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

		/**
		 * returns a users details as registred on the identity provider
		 * 
		 * @param TwswebInt\CamelotAuth\AuthDrivers\Oauth2Driver\AccessToken
		 * 
		 * @return array
		 */
		abstract public function getUserInfo(AccessToken $token);


		/**
		 *
		 *
		 *
		 */
		public function authorize(array $options = array())
		{
			$state = md5(uniqid(rand(),true));
			
			$params = array(
				'client_id' => $this->clientID,
				'redirect_uri' => $this->callbackUrl.'/callback',
				'state' => $state,
				'scope'=>is_array($this->scopes) ? implode($this->scopeSeperator, $this->scopes) : $this->scopes,
				'response_type' => 'code',
				);

			$params = array_merge($params,$this->params);

			header('Location: ' . $this->authorizeUrl().'?'.http_build_query($params));
			exit;
		}

		public function callback()
		{
			parse_str(parse_url($_SERVER['REQUEST_URI'],PHP_URL_QUERY),$get);
			
			/*if(!($get['state']== $this->session->get('state')))
			{
				throw new \Exception("csrf code does not match the provided state code", 1);
			}*/

			if(isset($get['code']))
			{
				return $this->authenticate($get['code']);	
			}
		}

		public function authenticate($code)
		{
			$params = array(
				'client_id' => $this->clientID,
				'client_secret' => $this->clientSecret,
				'grant_type' =>$this->grantType
				);

			$params = array_merge($params,$this->params);

			switch ($params['grant_type']) {
				case 'authorization_code':
					$params['code'] = $code;
					$params['redirect_uri'] = $this->callbackUrl;
					break;
				
				case 'refresh_token':
					$params['refresh_token'] = $code;
					break;
			}
			$response = null;
			$url = $this->accessTokenUrl();
			switch ($this->method) {
				case 'GET':
					$url .='?'. http_build_query($params);
					$response = file_get_contents($url);
					parse_str($response,$return);
					break;
				
				case 'POST':
					$postdata = http_build_query($params);
					$options = array(
						'http' => array(
							'method'  => 'POST',
							'header'  => 'Content-type: application/x-www-form-urlencoded',
							'content' => $postdata
							)
						);
					$defaultOptions = stream_context_get_params(stream_context_get_default());
					$context = stream_context_create(array_merge_recursive($defaultOptions['options'],$options));
					
				
					$response = file_get_contents($url,false,$context);
					$return = json_decode($response,true);
					break;
				default:
					throw new OutOfBoundException("The method can only be POST or GET, ".$this->method." provided");
					break;
			}

			if(!empty($return['error']))
			{
				throw new Oauth2Exception($return['error']);
			}

			$token['accessToken'] = $return['access_token'];

			if(isset($this->tokenExpires))
			{
				$token['expires'] =time() + ((int)$return[$this->tokenExpires]);
			}

			if(isset($this->uid))
			{
				$token['uid'] = $return[$this->tokenUId];
			}	

			if(isset($return['refresh_token']))
			{
				$token['refreshToken'] = $return['refresh_token'];
			}
			return new AccessToken($token);
		}

}