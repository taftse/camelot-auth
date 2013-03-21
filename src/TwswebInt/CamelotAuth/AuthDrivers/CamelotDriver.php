<?php namespace TwswebInt\CamelotAuth\AuthDrivers;


use TwswebInt\CamelotAuth\User\UserInterface;
use TwswebInt\CamelotAuth\SessionDrivers\SessionDriverInterface;
use TwswebInt\CamelotAuth\CookieDrivers\CookieDriverInterface;
//use TwswebInt\CamelotAuth\UserInterface;
use TwswebInt\CamelotAuth\DatabaseDrivers\DatabaseDriverInterface as DatabaseDriverInterface;
abstract class CamelotDriver{

	/**
	 * The currently authenticated user.
	 *
	 * @var TwswebInt\CamelotAuth\User\UserInterface
	 */
	protected $user;

	/**
	* The Session Driver used by Camelot
	*
	* @var use TwswebInt\CamelotAuth\SessionDrivers\SessionDriverInterface;
	*/
	protected $session;

	/**
	* The Cookie Driver used by Camelot
	*
	* @var use TwswebInt\CamelotAuth\CookieDrivers\CookieDriverInterface;
	*/
	protected $cookie;

	/**
	 * The Database Driver
	 *
	 * @var TwswebInt\CamelotAuth\DatabaseDrivers\DatabaseDriverInterface
	 */
	protected $database;

	/**
	 * The Authentication provider
	 *
	 * @var string
	 */
	protected $providerName;


	/**
	 * The Authentication providers model
	 *
	 * @var string
	 */
	protected $providerModel = null;

	

	/**
	 * The errors generated
	 *
	 * @var array
	 */
	public $errors = array();

	public function __construct(SessionDriverInterface $session,CookieDriverInterface $cookie,DatabaseDriverInterface $database,$providerName)
	{
		$this->session = $session;
		$this->cookie = $cookie;
		$this->database = $database;
		$this->providerName = $providerName;
	}

	public function check()
	{
		return ! is_null($this->user());
	}

	/**
	 * Gets the currently authenticated user.
	 *
	 * @return User|null
	 */
	public function user()
	{
		if(!is_null($this->user))
		{
			return $this->user;
		}
		
		$id = $this->session->get();

		$user = null;
		
		if(!is_null($id))
		{
			$user = $this->database->getByID($id);			
		}

		if(is_null($user) && !is_null($cookieID = $this->getCookieID()))
		{
			$user = $this->database->getByID($cookieID);
		}

		if(!is_null($user)){
			return $this->user = $user->account;
		}

		return null;
	}

	abstract function authenticate();

	abstract function register();



	protected function login()
	{

	}

	protected function createSession($account,$remember = false)
	{
		
		$id = $account->getAuthIdentifier();

		$this->session->put($id);

		if($remember)
		{
			$this->cookie->forever($this->getCookieID(),$id);
		}
		$this->user = $account;
	}

	// all details should be checked before this function is called
	/*protected function createAccount(array $credentials,array $accountDetails)
	{

		if($this->check())
		{
			
			// if logged in add the account_id to the credentials
			$credentials['account_id'] = $this->user->id;


		}else {
			// create a new account in the account table 
			// asuming the details in the accountDetails array have been filtered
			$account = new \TwswebInt\CamelotAuth\Models\CamelotAccount();
			$account->fill($accountDetails);
			$account->save();
			//send email activation 

			// add the returned account_id to the credentials
			
			$credentials['account_id'] = $account->id;
		}

		
		$user = $this->createModel();
		$user::create($credentials);
		//$user->save();

		return $user;
	}*/

	protected function createAccount(array $accountDetails ,$active = false)
	{
		if($this->check())
		{
			return $this->user->id;
		}else{
			$account = new \TwswebInt\CamelotAuth\Models\CamelotAccount();
			$account->fill($accountDetails);
			$account->save();
			return $account->id;
		}
	}


	public function logout()
	{
		$this->user = null;
		$this->session->forget();
		$this->cookie->forget();
	}
	/**
	 * Get a unique identifier for this auth session ID value.
	 *
	 * @return string
	 */
	public function getSessionID()
	{
		return 'sessionID_'.md5(get_class($this));
	}

	/**
	 * Get a unique identifier for this auth Cookie ID value.
	 *
	 * @return string
	 */
	public function  getCookieID()
	{
		return 'rememberMe_'.md5(get_class($this));
	}


	protected function returnResponse($responseType,$message,$details = null)
	{
		if($responseType == 'validation')
		{
			$this->errors['validation'] = $message;
		}
		else
		{
			$this->errors[$responseType][] = array('message' => $message,'details'=>$details);
		}
	}

	public function getErrors()
	{
		return $this->errors;
	}

	public function getProviderName()
	{
		return $this->providerName;
	}

	public function createModel()
	{

		$class = '\\'.ltrim($this->providerModel, '\\');

		return new $class;
	}
}