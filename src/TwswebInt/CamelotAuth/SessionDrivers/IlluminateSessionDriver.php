<?php namespace TwswebInt\CamelotAuth\SessionDrivers;

use Illuminate\Session\Store  as SessionStore;

class IlluminateSessionDriver implements SessionDriverInterface
{

	protected $key = "camelot-auth";

	protected $store;

	public function __construct(SessionStore $store,$key = "camelot-auth")
	{
		$this->store = $store;
		$this->key = $key;
	}

	public function getKey()
	{
		return $this->key;
	}

	public function put($value)
	{
		$this->store->put($this->key,$value);
	}

	public function get()
	{
		return $this->store->get($this->key);
	}

	public function forget()
	{
		$this->store->forget($this->key);
	}
}