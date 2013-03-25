<?php namespace TwswebInt\CamelotAuth\CookieDrivers;

use Illuminate\Container\Container;
use Illuminate\Cookie\CookieJar;
use Symfony\Component\HttpFoundation\Cookie;

class IlluminateCookieDriver implements CookieDriverInterface
{
	protected $key = "camelot-auth";

	protected $cookieJar;

	protected $cookie;

	public function __construct(CookieJar $cookieJar,$key = "camelot-auth")
	{
		$this->cookieJar = $cookieJar;
		$this->key = $key;
	}

	public function getKey()
	{
		return $this->key;
	}

	public function put($value,$minutes,$key= null)
	{
		if(is_null($key))
		{
			$key = $this->getKey();
		}
		$this->cookie = $this->cookieJar->make($key,$value,$minutes);
	}

	public function forever($value)
	{
		$this->cookie = $this->cookieJar->forever($this->getKey(),$value);
	}

	public function get($key= null)
	{
		if(is_null($key))
		{
			$key = $this->getKey();
		}
		return $this->cookieJar->get($key);
	}

	public function forget($key= null)
	{
		if(is_null($key))
		{
			$key = $this->getKey();
		}
		$this->cookie = $this->cookieJar->forget($key);
	}

	public function getCookie()
	{
		return $this->cookie;
	}
}