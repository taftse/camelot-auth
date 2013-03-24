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

	public function put($value,$minutes)
	{
		$this->cookie = $this->cookieJar->make($this->key,$value,$minutes);
	}

	public function forever($value)
	{
		$this->cookie = $this->cookieJar->forever($this->key,$value);
	}

	public function get()
	{
		return $this->CookieJar->get($this->key);
	}

	public function forget()
	{
		$this->cookie = $this->cookieJar->forget($this->key);
	}

	public function getCookie()
	{
		return $this->cookie;
	}
}