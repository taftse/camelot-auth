<?php namespace TwswebInt\CamelotAuth\AuthDrivers\Oauth2Driver\Providers;

use TwswebInt\CamelotAuth\SessionDrivers\SessionDriverInterface;
use TwswebInt\CamelotAuth\CookieDrivers\CookieDriverInterface;
use TwswebInt\CamelotAuth\DatabaseDrivers\DatabaseDriverInterface;
use TwswebInt\CamelotAuth\AuthDrivers\Oauth2Driver\AccessToken;

class GoogleOauth2Provider extends AbstractOauth2Provider
{
	/**
	 * the method used to request tokens 
	 *
	 * @var string
	 */
	public $method = 'POST';

	/**
	 * the scope seperator that should be used (specified by the provider)
	 *
	 * @var  string  
	 */
	protected $scopeSeperator = ' '; 

	public function __construct(SessionDriverInterface $session,CookieDriverInterface $cookie,DatabaseDriverInterface $database,array $settings,$httpPath)
	{	

			$scopes = array(
				'https://www.googleapis.com/auth/userinfo.profile',
				'https://www.googleapis.com/auth/userinfo.email');
			if(is_string($settings['scopes']))
			{
				$settings['scopes'] = explode(',',$settings['scopes']);
			}

			$settings['scopes'] = $settings['scopes'] + $scopes;	
			parent::__construct($session,$cookie,$database,$settings,$httpPath);
	}

	/**
	 * Returns the authorization URL for the provider.
	 *
	 * @return string
	 */
	public function authorizeUrl()
	{
		return 'https://accounts.google.com/o/oauth2/auth';
	}

	/**
     * Returns the access token endpoint for the provider.
	 *
	 * @return string
	 */
	public function accessTokenUrl()
	{
		return 'https://accounts.google.com/o/oauth2/token';
	}


	/**
	 * returns a users details as registred on the identity provider
	 * 
	 * @param TwswebInt\CamelotAuth\AuthDrivers\Oauth2Driver\AccessToken
	 * 
	 * @return array
	 */
	 public function getUserInfo(AccessToken $token)
	 {
	 	$url = 'https://www.googleapis.com/oauth2/v1/userinfo?alt=json&'.http_build_query(array('access_token' => $token->accessToken));

	 	$userdata = json_decode(file_get_contents($url));
			
			return $userdata;
			/*
			 "id": "",
			 "email": "",
			 "verified_email": true,
			 "name": "Timothy Seebus",
			 "given_name": "Timothy",
			 "family_name": "Seebus",
			 "link": "",
			 "gender": "male",
			 "birthday": "",
			 "locale": "en"
			*/
	 }


	 
}
