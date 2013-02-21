<?php namespace TwswebInt\CamelotAuth\AuthDrivers;

use Illuminate\Session\Store as SessionStore;
use Illuminate\Foundation\Application;
use TwswebInt\CamelotAuth\UserInterface;
use TwswebInt\CamelotAuth\DatabaseDrivers\DatabaseDriverInterface as DatabaseDriverInterface;
abstract class CamelotDriver{

	/**
	 * The application instance.
	 *
	 * @var Illuminate\Foundation\Application
	 */
	protected $app;

	/**
	 * The currently authenticated user.
	 *
	 * @var User
	 */
	protected $user;

	/**
	 * The Authentication provider
	 *
	 * @var string
	 */
	protected $provider;

	/**
	 * The Database Driver
	 *
	 * @var TwswebInt\CamelotAuth\DatabaseDrivers\DatabaseDriverInterface
	 */
	protected $database;

	/**
	 * The errors generated
	 *
	 * @var array
	 */
	public $errors = array();

	public function __construct(Application $app,DatabaseDriverInterface $database,$provider)
	{
		$this->app = $app;
		$this->database = $database;
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
		$id = $this->app['session']->get($this->getSessionID());

		$user = null;

		if(!is_null($id))
		{
			$user = $this->database->getByID($id);
		}

		if(is_null($user) && !is_null($cookieID = $this->getCookieID()))
		{
			$user = $this->database->getByID($cookieID);
		}

		return $this->user = $user->account;
	}

	abstract function authenticate();


	protected function login()
	{

	}

	protected function createSession($account,$remember = false)
	{
		//var_dump($account);
		$id = $account->getAuthIdentifier();

		$this->app['session']->put($this->getSessionID(),$id);

		if($remember)
		{
			$this->app['cookie']->forever($this->getCookieID(),$id);
		}
		$this->user = $account;
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
}