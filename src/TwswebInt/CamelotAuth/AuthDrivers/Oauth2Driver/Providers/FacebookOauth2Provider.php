<?php namespace TwswebInt\CamelotAuth\AuthDrivers\Oauth2Driver\Providers;

use TwswebInt\CamelotAuth\SessionDrivers\SessionDriverInterface;
use TwswebInt\CamelotAuth\CookieDrivers\CookieDriverInterface;
use TwswebInt\CamelotAuth\DatabaseDrivers\DatabaseDriverInterface;
use TwswebInt\CamelotAuth\AuthDrivers\Oauth2Driver\AccessToken;

class FacebookOauth2Provider extends AbstractOauth2Provider
{

	/**
	 * the name used for the experation time used by the identity provider in the auth_token
	 *
	 * @var string 
	 */
	protected $tokenExpires = 'expires';

	public function __construct(SessionDriverInterface $session,CookieDriverInterface $cookie,DatabaseDriverInterface $database,array $settings,$httpPath)
	{	

			$scopes = array('email');
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
		return 'https://www.facebook.com/dialog/oauth';
	}

	/**
     * Returns the access token endpoint for the provider.
	 *
	 * @return string
	 */
	public function accessTokenUrl()
	{
		return 'https://graph.facebook.com/oauth/access_token';
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
	 	$url = 'https://graph.facebook.com/me?'.http_build_query(array('access_token' => $token->accessToken));

	 	$userdata = json_decode(file_get_contents($url));
			
			return (array)$userdata;
			/*"id": "",
   			"name": "Timothy Seebus",
   			"first_name": "Timothy",
   			"last_name": "Seebus",
   			"link": "",
   			"username": "Taftse",*/
	 }


	 
}
