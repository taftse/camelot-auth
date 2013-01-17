<?php namespace TwswebInt\CamelotAuth\Drivers;

use Illuminate\Session\Store as SessionStore;
use Illuminate\Foundation\Application;
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


	public function __construct(Application $app,$provider)
	{
		$this->app = $app;
		$this->provider = $provider;
		echo $this->provider;
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
		$id = $this->session->get($this->getSessionID());

		$user = null;

		if(!is_null($id))
		{

		}

		if(is_null($user) && !is_null($cookieID = $this->getCookieID()))
		{

		}

		return $this->user = $user;
	}

	abstract function authenticate();


	protected function login()
	{

	}

	protected function createSession($accountID)
	{

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
}