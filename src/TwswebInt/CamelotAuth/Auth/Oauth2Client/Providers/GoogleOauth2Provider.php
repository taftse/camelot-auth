<?php namespace TwswebInt\CamelotAuth\Auth\Oauth2Client\Providers;

use TwswebInt\CamelotAuth\Session\SessionInterface;
use TwswebInt\CamelotAuth\Cookie\CookieInterface;
use TwswebInt\CamelotAuth\Database\DatabaseInterface;
use TwswebInt\CamelotAuth\Auth\Oauth2Client\AccessToken;

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

	/**
	 * an array used to map the recieved data to the accepted camelot data
	 *
	 * @var array
	 */
	protected $userDataMap = array(
		'user_id'=>'id',
		'username'=>'email',
		'first_name' =>'given_name',
		'last_name'=>'family_name',
		'email' =>'email',
		'email_verified'=>'verified_email',
		'address_1' => null,
		'address_2'=> null,
		'city'=> null,
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
	 * @param TwswebInt\CamelotAuth\Auth\Oauth2Driver\AccessToken
	 * 
	 * @return array
	 */
	 public function getUserInfo(AccessToken $token)
	 {
	 	$url = 'https://www.googleapis.com/oauth2/v1/userinfo?alt=json&'.http_build_query(array('access_token' => $token->accessToken));

	 	$userData = json_decode(file_get_contents($url));
	 		
			return $this->parseUserData($userData,$token);
	 }
}