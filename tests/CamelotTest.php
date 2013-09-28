<?php namespace T4s\CamelotAuth\Tests;

use Mockery as m;
use T4s\CamelotAuth\Camelot;
use PHPUnit_Framework_TestCase;

class CamelotTest extends PHPUnit_Framework_TestCase
{
	protected $session;

	protected $cookie;

	public function setUp()
	{
		$this->camelot = new Camelot(
			$this->session = m::mock('T4s\CamelotAuth\Session\SessionInterface'),
			$this->cookie = m::mock('T4s\CamelotAuth\Cookie\CookieInterface'),
			$this->config = m::mock('T4s\CamelotAuth\Config\ConfigInterface')
			);
	}

	public function tearDown()
	{
		m::close();
	}

	public function getEventDispacherTest()
	{
		
	}
}

