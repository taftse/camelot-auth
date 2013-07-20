<?php namespace T4s\CamelotAuth\Auth\Oauth2Client\Providers;

use T4s\CamelotAuth\Session\SessionInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;
use T4s\CamelotAuth\Database\DatabaseInterface;
use T4s\CamelotAuth\Auth\Oauth2Client\AccessToken;

class FacebookOauth2Provider extends AbstractOauth2Provider
{

	/**
	 * the name used for the experation time used by the identity provider in the auth_token
	 *
	 * @var string 
	 */
	protected $tokenExpires = 'expires';

	/**
	 * an array used to map the recieved data to the accepted camelot data
	 *
	 * @var array
	 */
	protected $userDataMap = array(
		'user_id'=>'id',
		'username'=>'username',
		'first_name' =>'first_name',
		'last_name'=>'last_name',
		'email' =>'email',
		'email_verified'=>'verified',
		'address_1' => null,
		'address_2'=> null,
		'city'=> array('hometown','name'),
		'zip_code'=> null,
		'state_code'=> null,
		'country_iso'=> null,
		'dob'=>'birthday',
		'phone'=> null,
		'status'=>'active',
		'gender' =>'gender',
		'language_iso'=> 'locale',
		);

	public function __construct(SessionInterface $session,CookieInterface $cookie,DatabaseInterface $database,array $settings,$httpPath)
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
	 * @param T4s\CamelotAuth\Auth\Oauth2Driver\AccessToken
	 * 
	 * @return array
	 */
	 public function getUserInfo(AccessToken $token)
	 {
	 	$url = 'https://graph.facebook.com/me?'.http_build_query(array('access_token' => $token->accessToken));

	 	$userData = json_decode(file_get_contents($url));
			

	 		return $this->parseUserData($userData,$token);
			
	 }	 
}
