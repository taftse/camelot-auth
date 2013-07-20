<?php namespace T4s\CamelotAuth\Auth\Oauth2Client\Providers;

use T4s\CamelotAuth\Session\SessionInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;
use T4s\CamelotAuth\Database\DatabaseInterface;
use T4s\CamelotAuth\Auth\Oauth2Client\AccessToken;

class LinkedinOauth2Provider extends AbstractOauth2Provider
{

	/**
	 * the method used to request tokens 
	 *
	 * @var string
	 */
	public $method = 'POST';

	/**
	 * the name used for the experation time used by the identity provider in the auth_token
	 *
	 * @var string 
	 */
	protected $tokenExpires = 'expires_in';

	/**
	 * an array used to map the recieved data to the accepted camelot data
	 *
	 * @var array
	 */
	protected $userDataMap = array(
		'user_id'=>'id',
		'username'=>'formatted-name',
		'first_name' =>'first-name',
		'last_name'=>'last-name',
		'email' =>'email-address',
		'email_verified'=>null,
		'address_1' =>'main-address',
		'address_2'=> null,
		'city'=> null,
		'zip_code'=> null,
		'state_code'=> null,
		'country_iso'=> null,
		'dob'=>'date-of-birth',
		'phone'=> null,
		'status'=>'active',
		'gender' =>'gender',
		'language_iso'=> 'locale',
		);

	public function __construct(SessionInterface $session,CookieInterface $cookie,DatabaseInterface $database,array $settings,$httpPath)
	{	

			$scopes = array('r_basicprofile','r_emailaddress','r_contactinfo');

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
		return 'https://www.linkedin.com/uas/oauth2/authorization';
	}

	/**
     * Returns the access token endpoint for the provider.
	 *
	 * @return string
	 */
	public function accessTokenUrl()
	{
		return 'https://www.linkedin.com/uas/oauth2/accessToken';
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
	 	$url = 'https://api.linkedin.com/v1/people/~?'.http_build_query(array('oauth2_access_token' => $token->accessToken));

	 	$userData = json_decode(file_get_contents($url));
			

	 		return $this->parseUserData($userData,$token);
			
	 }	 
}
