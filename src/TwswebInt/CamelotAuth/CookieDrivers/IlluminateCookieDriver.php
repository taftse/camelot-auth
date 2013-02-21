<?php namespace TwswebInt\CamelotAuth\CookieDrivers;

use Illuminate\Container\Container;
use Illuminate\Cookie\CookieJar;
use Symfony\Component\HttpFoundation\Cookie;

class IlluminateCookieDriver implements CookieDriverInterface
{
	protected $key = "cammelot-auth";

	protected $cookieJar;

	protected $cookie;

	public function __construct(CookieJar $cookieJar,$key = "cammelot-auth")
	{
		$this->cookieJar = $cookieJar;
		$this->key = $key;
	}

	public function getCookieKey()
	{
		return $this->key;
	}

	public function put($value,$minutes)
	{
		$this->cookie = $this->cookieJar->make($this->key,$value,$minutes);
	}

	public function putForever($value)
	{
		$this->cookie = $this->cookieJar->forever($this->key,$value);
	}

	public function get()
	{
		return $this->cookieJar->get($this->key);
	}

	public function remove()
	{
		$this->cookie = $this->cookieJar->forget($this->key);
	}

	public function getCookie()
	{
		return $this->cookie;
	}
}