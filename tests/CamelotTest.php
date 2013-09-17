<?php namespace T4s\CamelotAuth\Tests;

use Mockery as m;
use T4s\CamelotAuth\Camelot;
use PHPUnit_Framework_TestCase;
use Hamcrest;

class CamelotTest extends PHPUnit_Framework_TestCase
{
	protected $session;

	protected $cookie;
	
	protected $camelot;
	
	protected $config;
	
	protected $messaging;
	
	protected $path;

	public function setUp()
	{
		$this->session = m::mock('T4s\CamelotAuth\Session\SessionInterface');
		$this->cookie = m::mock('T4s\CamelotAuth\Cookie\CookieInterface');
		$this->config = m::mock('T4s\CamelotAuth\Config\ConfigInterface');
		$this->messaging = m::mock('T4s\CamelotAuth\Messaging\MessagingInterface');
		$this->path = m::mock(\stringValue());
		
		$this->config->shouldReceive('get')->once()->with('camelot.provider_routing')
					 ->andReturn('foo');
		$this->config->shouldReceive('get')->once()->with('camelot.database_driver')
					 ->andReturn('Eloquent');
		
		$this->camelot = new Camelot($this->session,$this->cookie,$this->config,$this->messaging,$this->path);
		
	}

	public function tearDown()
	{
		m::close();
	}

	public function getEventDispacherTest()
	{
		
	}
	
	public function testSetEventDispatcher() 
	{
		$dispatcher = m::mock('T4s\CamelotAuth\Events\DispatcherInterface');
	}
}

