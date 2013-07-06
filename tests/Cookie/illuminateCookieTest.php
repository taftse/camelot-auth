<?php namespace T4s\CamelotAuth\Tests\Cookie;

use Mockery as m;
use T4s\CamelotAuth\Cookie\IlluminateCookie;
use PHPUnit_Framework_TestCase;

class IlluminateCookieTest extends PHPUnit_Framework_TestCase
{
	protected $cookieJar;

	protected $cookie;

	public function setUp()
	{
		$this->cookieJar = m::mock('Illuminate\Cookie\CookieJar');
		$this->cookie = new IlluminateCookie($this->cookieJar,"camelot-auth-cookie");
	}

	public function tearDown()
	{
		m::close();
	}

	public function testPut()
	{
		$this->cookieJar->shouldReceive('make')->with('camelot-auth-cookie','cookie','123')->once();
		$this->cookie->put('cookie','123');
	}

	public function testForever()
	{
		$this->cookieJar->shouldReceive('forever','cookie')->once();
		$this->cookie->forever('cookie');
	}
}