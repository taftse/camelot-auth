<?php namespace T4s\CamelotAuth\Auth\Oauth2Client\Providers;

use T4s\CamelotAuth\Session\SessionInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;
use T4s\CamelotAuth\Database\DatabaseInterface;
use T4s\CamelotAuth\Auth\Oauth2Client\AccessToken;

class WindowsliveOauth2Provider extends AbstractOauth2Provider
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
		'username'=>array('emails','account'),
		'first_name' =>'first_name',
		'last_name'=>'last_name',
		'email' =>array('emails','account'),
		'email_verified'=>'verified_email',
		'address_1' => array('addresses',array('personal','street')),
		'address_2'=> array('addresses',array('personal','street_2')),
		'city'=> array('addresses',array('personal','city')),
		'zip_code'=> array('addresses',array('personal','postal_code')),
		'state_code'=> array('addresses',array('personal','state')),
		'country_iso'=> array('addresses',array('personal','region')),
		'dob'=>null,
		'phone'=> array('phones','personal'),
		'status'=>'active',
		'gender' =>'gender',
		'language_iso'=> 'locale',
		);

	public function __construct(SessionInterface $session,CookieInterface $cookie,DatabaseInterface $database,array $settings,$httpPath)
	{	

			$scopes = array(
				'wl.basic',
				'wl.emails',
				'wl.signin'
				);
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
		return 'https://login.live.com/oauth20_authorize.srf';
	}

	/**
     * Returns the access token endpoint for the provider.
	 *
	 * @return string
	 */
	public function accessTokenUrl()
	{
		return 'https://login.live.com/oauth20_token.srf';
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
	 	$url = 'https://apis.live.net/v5.0/me?'.http_build_query(array('access_token' => $token->accessToken));

	 	$userData = json_decode(file_get_contents($url));
	 		
			return $this->parseUserData($userData,$token);
	 }
}