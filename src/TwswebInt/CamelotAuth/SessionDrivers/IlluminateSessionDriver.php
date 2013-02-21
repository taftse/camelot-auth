<?php namespace TwswebInt\CamelotAuth\SessionDrivers;

use Illuminate\Session\Store  as SessionStore;

class IlluminateSessionDriver implements SessionDriverInterface
{


	protected $key = "cammelot-auth";

	/**
	 * Session Store object
	 *
	 * @var Illuminate\Session\Store
	 */
	protected $session;

	public function __construct(SessionStore $session,$key = "cammelot-auth")
	{
		$this->session = $session;

		$this->key;
	}

	public function getKey()
	{
		return $this->key;
	}

	public function put($value)
	{
		$this->session->put($this->key,$value);
	}

	public function get()
	{
		return $this->session->get($this->key);
	}

	public function forget()
	{
		$this->session->forget($this->key);
	}
}