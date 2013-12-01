<?php namespace T4s\CamelotAuth\Cookie;

use Illuminate\Container\Container;
use Illuminate\Cookie\CookieJar;
use Symfony\Component\HttpFoundation\Cookie;

class IlluminateCookie implements CookieInterface
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
		$this->cookieJar->queue($this->cookie);
	}

	public function forever($value)
	{
		$this->cookie = $this->cookieJar->forever($this->getKey(),$value);
		$this->cookieJar->queue($this->cookie);
	}

	public function get($key= null)
	{
		if(is_null($key))
		{
			$key = $this->getKey();
		}
		
		$queuedCookies = $this->cookieJar->getQueuedCookies();
		if(isset($queuedCookies[$key]))
		{
			return $queuedCookies[$key];
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
		$this->cookieJar->queue($this->cookie);
	}

	public function getCookie()
	{
		return $this->cookie;
	}
}
