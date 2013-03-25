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

	public function put($value,$key=null)
	{
		if(is_null($key)){
			$key = $this->key;
		}
		
		$this->store->put($key,$value);
	}

	public function get($key = null)
	{
		if(is_null($key))
		{
			$key = $this->key;
		}
		return $this->store->get($key);
	}

	public function forget($key = null)
	{
		if(is_null($key))
		{
			$key = $this->key;
		}
		$this->store->forget($key);
	}
}