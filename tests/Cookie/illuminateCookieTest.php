<?php namespace T4s\CamelotAuth\Tests\Cookie;

use Mockery as m;
use T4s\CamelotAuth\Cookie\IlluminateCookie;
use PHPUnit_Framework_TestCase;

class IlluminateCookieTest extends PHPUnit_Framework_TestCase
{
	protected $cookieJar;

	protected $cookie;

    	protected $request;

	public function setUp()
	{
		$this->cookieJar = m::mock('Illuminate\Cookie\CookieJar');
        	$this->request = m::mock('Illuminate\Http\Request');
		$this->cookie = new IlluminateCookie($this->request,$this->cookieJar,"camelot-auth-cookie");
	}

	public function tearDown()
	{
		m::close();
	}

	public function testPut()
	{
		$this->cookieJar->shouldReceive('make')->with('camelot-auth-cookie','cookie','123')->once()->andReturn('cookie');
		$this->cookieJar->shouldReceive('queue')->with('cookie')->once();
		$this->cookie->put('cookie','123');
	}

	public function testForever()
	{
		$this->cookieJar->shouldReceive('forever')->with('camelot-auth-cookie','cookie')->once()->andReturn('cookie');
		$this->cookieJar->shouldReceive('queue')->with('cookie')->once();
		$this->cookie->forever('cookie');
	}
}
