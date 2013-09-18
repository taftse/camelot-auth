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
	
	protected $routingarray;

	public function setUp()
	{
		$this->session = m::mock('T4s\CamelotAuth\Session\SessionInterface');
		$this->cookie = m::mock('T4s\CamelotAuth\Cookie\CookieInterface');
		$this->config = m::mock('T4s\CamelotAuth\Config\ConfigInterface');
		$this->messaging = m::mock('T4s\CamelotAuth\Messaging\MessagingInterface');
		$this->path = m::mock(\stringValue());
		$this->routingarray = array(
                'Foo'         	=> array('driver'=>'bar'),
                'Foobar'   	 	=> array('driver'=>'barfoo','provider'=>'Foo'),
                'Foobarfoo'     => array('driver'=>'barfoobar','provider'=>'Foobar'),
             );

		
		$this->config->shouldReceive('get')->once()->with('camelot.provider_routing')
					 ->andReturn($this->routingarray);
		$this->config->shouldReceive('get')->once()->with('camelot.database_driver')
					 ->andReturn('Eloquent');
		
		$this->camelot = new Camelot($this->session,$this->cookie,$this->config,$this->messaging,$this->path);
		
	}

	public function tearDown()
	{
		m::close();
	}
	
	
	
	public function testDetectAuthDriverDefaultsToCorrectDefaultDriver() {
		$this->config->shouldReceive('get')->once()->with('camelot.provider_routing')
					 ->andReturn($this->routingarray);
		$this->config->shouldReceive('get')->once()->with('camelot.database_driver')
					 ->andReturn('Eloquent');
		$mock = m::mock("\T4s\CamelotAuth\Camelot[loadAuthDriver]", array($this->session, $this->cookie, $this->config, $this->messaging, $this->path));
		$mock->shouldReceive('loadAuthDriver')->once()
			 ->with('bar','Foo');
		
		$this->config->shouldReceive('get')->once()
			         ->with('camelot.detect_provider')
			         ->andReturn(false);
		$this->config->shouldReceive('get')->once()
			         ->with('camelot.default_provider')
			         ->andReturn('Foo');
			         
		$mock->detectAuthDriver();
		
	}
	

	
	
	
	public function testCheckForAliasReturnsCurrentProviderIfNoAliasIsSet()
	{
		$provider = 'Foo';
		$result = $this->camelot->checkForAlias($provider);
		
		assertThat($result, is('Foo'));		
	}
	public function testCheckForAliasReturnsAliasIfSet()
	{
		$provider = 'Foobar';
		$result = $this->camelot->checkForAlias($provider);
		
		assertThat($result, is('Foo'));
	}
	public function testCheckForNestedAliases()
	{
		$provider = 'Foobarfoo';
		$result = $this->camelot->checkForAlias($provider);
		
		assertThat($result, is('Foo'));
	}
	/*
	public function getEventDispacherTest()
	{
		
	}
	
	public function testSetEventDispatcher() 
	{
		$dispatcher = m::mock('T4s\CamelotAuth\Events\DispatcherInterface');
	}
	*/
	
}

