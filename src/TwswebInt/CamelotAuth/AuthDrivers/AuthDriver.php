<?php namespace TwswebInt\CamelotAuth\AuthDrivers;

use TwswebInt\CamelotAuth\SessionDrivers\SessionDriverInterface;
use TwswebInt\CamelotAuth\CookieDrivers\CookieDriverInterface;
use TwswebInt\CamelotAuth\DatabaseDrivers\DatabaseDriverInterface;

abstract class AuthDriver{
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
	* The name of the authentication provider
	*
	*/
	protected $providerName;

	protected $settings = array();

	public function __construct(SessionDriverInterface $session,CookieDriverInterface $cookie,DatabaseDriverInterface $database,$providerName,array $settings)
	{
		$this->session = $session;
		$this->cookie = $cookie;
		$this->database = $database;
		$this->providerName = $providerName;
	}

	public function check()
	{
		return !is_null($this->user());
	}

	public function user()
	{
		if(!is_null($this->user))
		{
			return $this->user;
		}

		$id= $this->session->get();

		$user = null;

		if(!is_null($id))
		{
			return $this->user = $this->database->getByID($id);
		}

		$id = $this->cookie->get();

		if(!is_null($id))
		{
			return $this->user = $this->database->getByID($id);
		}

		return null;
	}

	/*protected function createAccount($accountModel)
	{

	}*/

	protected function createSession($account,$remember = false)
	{
		$id = $account->id;

		$this->session->put($id);

		if($remember)
		{
			$this->cookie->forever($id);
		}

		$this->user = $account;
	}

	abstract function authenticate();

	abstract function register();

	public function logout()
	{
		$this->user = null;
		$this->session->forget();
		$this->cookie->forget();
	}
}