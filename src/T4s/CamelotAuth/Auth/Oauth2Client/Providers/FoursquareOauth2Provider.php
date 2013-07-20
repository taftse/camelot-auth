<?php namespace T4s\CamelotAuth\Auth\Oauth2Client\Providers;

use T4s\CamelotAuth\Session\SessionInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;
use T4s\CamelotAuth\Database\DatabaseInterface;
use T4s\CamelotAuth\Auth\Oauth2Client\AccessToken;

class FoursquareOauth2Provider extends AbstractOauth2Provider
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
	protected $scopeSeperator = ''; 

	/**
	 * an array used to map the recieved data to the accepted camelot data
	 *
	 * @var array
	 */
	protected $userDataMap = array(
		'user_id'=>'id',
		'username'=>'email',
		'first_name' =>'firstName',
		'last_name'=>'lastName',
		'email' =>array('contact','email'),
		'email_verified'=>null,
		'address_1' => null,
		'address_2'=> null,
		'city'=> 'homeCity',
		'zip_code'=> null,
		'state_code'=> null,
		'country_iso'=> null,
		'dob'=>null,
		'phone'=> null,
		'status'=>null,
		'gender' =>'gender',
		'language_iso'=> null,
		);

	public function __construct(SessionInterface $session,CookieInterface $cookie,DatabaseInterface $database,array $settings,$httpPath)
	{	


			$settings['scopes'] = '';
			parent::__construct($session,$cookie,$database,$settings,$httpPath);
	}

	/**
	 * Returns the authorization URL for the provider.
	 *
	 * @return string
	 */
	public function authorizeUrl()
	{
		return 'https://foursquare.com/oauth2/authorize';
	}

	/**
     * Returns the access token endpoint for the provider.
	 *
	 * @return string
	 */
	public function accessTokenUrl()
	{
		return 'https://foursquare.com/oauth2/access_token';
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
	 	$url = 'https://api.foursquare.com/v2/users/self?'.http_build_query(array('oauth_token' => $token->accessToken,'v'=>'20130623'));

	 	$userData = json_decode(file_get_contents($url));
	 		
			return $this->parseUserData($userData,$token);
	 }
}