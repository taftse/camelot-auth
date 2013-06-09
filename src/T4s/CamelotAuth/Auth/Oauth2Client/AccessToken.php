<?php namespace T4s\CamelotAuth\Auth\Oauth2Client;

class AccessToken {

	/**
	 * The Access Token
	 *
	 * @var string
	 */
	protected $accessToken='';

	/**
	 * when the access token expires
	 *
	 * @var int
	 */
	protected $expires =0;

	/**
	 * the Refresh Token
	 *
	 * @var string
	 */
	protected $refreshToken ='';

	/**
	 * the users id
	 *
	 * @var string
	 */
	protected $uid ='';

	/**
	 * sets the token 
	 *
	 */
	 public function __construct(array $options = null)
	 {
	 		if (!isset($options['accessToken']))
			{
				throw new Exception('Required option not passed: access_token'.PHP_EOL.print_r($options, true));
			}
	
			foreach ($options as $option => $value) {
            		if (isset($this->{$option})) {
                		$this->{$option} = $value;
            		}
        		}
        	
    }

	/**
	 * Returns the token key.
	 *
	 * @return string
 	 */
	public function __toString()
	{
		return (string) $this->accessToken;
	}


	public function __ToArray()
	{
		return array(''=>$this->accessToken);
	}

		/**
		 * Return the value of any protected class variable.
		 *
		 * @param string $key variable name
		 * @return mixed
		 */
		public function __get($key)
		{
			return $this->$key;
		}	
}