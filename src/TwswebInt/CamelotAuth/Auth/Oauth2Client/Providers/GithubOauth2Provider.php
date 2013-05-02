<?php namespace TwswebInt\CamelotAuth\Auth\Oauth2Client\Providers;

use TwswebInt\CamelotAuth\Session\SessionInterface;
use TwswebInt\CamelotAuth\Cookie\CookieInterface;
use TwswebInt\CamelotAuth\Database\DatabaseInterface;
use TwswebInt\CamelotAuth\Auth\Oauth2Client\AccessToken;

class GithubOauth2Provider extends AbstractOauth2Provider
{
	/**
	 * the name used for the experation time used by the identity provider in the auth_token
	 *
	 * @var string 
	 */
	protected $tokenExpires = null;

	/**
	 * an array used to map the recieved data to the accepted camelot data
	 *
	 * @var array
	 */
	protected $userDataMap = array(
		'user_id'=>'id',
		'username'=>'login',
		'first_name' =>'name',
		'last_name'=>null,
		'email' =>'email',
		'email_verified'=>null,
		'address_1' => null,
		'address_2'=> null,
		'city'=> 'location',
		'zip_code'=> null,
		'state_code'=> null,
		'country_iso'=> null,
		'dob'=>null,
		'phone'=> null,
		'status'=>'active',
		'gender' =>null,
		'language_iso'=> null,
		);


public function __construct(SessionInterface $session,CookieInterface $cookie,DatabaseInterface $database,array $settings,$httpPath)
	{	

			$scopes = array('user','user:email');
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
		return 'https://github.com/login/oauth/authorize';
	}

	/**
     * Returns the access token endpoint for the provider.
	 *
	 * @return string
	 */
	public function accessTokenUrl()
	{
		return 'https://github.com/login/oauth/access_token';
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
	 	$url = 'https://api.github.com/user?'.http_build_query(array('access_token' => $token->accessToken));
	 	
		$opts = array(
		  'http'=>array(
		    'method'=>"GET",
		    'header'=>"Accept-language: en\r\n" .
		             "User-Agent:Taftse/Camelot-Auth Host ".$this->callbackUrl." \r\n"
		  )
		);
		$context = stream_context_create($opts);

	 	$userData = json_decode(file_get_contents($url,false,$context));
			
	 		return $this->parseUserData($userData,$token);
			
	 }

}
  