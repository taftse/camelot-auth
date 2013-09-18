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
		
		
	}

	public function tearDown()
	{
		m::close();
	}
	public function setCamelot()
	{
		$this->camelot = new Camelot($this->session,$this->cookie,$this->config,$this->messaging,$this->path);
	}
	
	
	
	public function testDetectAuthDriverDefaultsToCorrectDefaultDriver() {
		$mock = m::mock("\T4s\CamelotAuth\Camelot[loadAuthDriver,detectProviderFromSegments,getDriver,checkForAlias]", 
						array($this->session, $this->cookie, $this->config, $this->messaging, $this->path));
		$mock->shouldReceive('detectProviderFromSegments')->once()
			 ->andReturn(null);
		$mock->shouldReceive('getDriver')->once()->with(null)->andReturn(null);
		
		$this->config->shouldReceive('get')->once()
			         ->with('camelot.default_provider')
			         ->andReturn('Foo');
		$mock->shouldReceive('getDriver')->once()->with('Foo')->andReturn('foobar');
		$mock->shouldReceive('checkForAlias')->once()->with('Foo')->andReturn('Foo');
		$mock->shouldReceive('loadAuthDriver')->once()->with('foobar','Foo');
			 
			         
		$mock->detectAuthDriver();
		
	}
	public function testDetectAuthDriverGetsDriverFromPath() {
		$this->path = 'login/foo';
		$mock = m::mock("\T4s\CamelotAuth\Camelot[loadAuthDriver,detectProviderFromSegments,getDriver,checkForAlias]", 
						array($this->session, $this->cookie, $this->config, $this->messaging, $this->path));
		$mock->shouldReceive('detectProviderFromSegments')->once()->andReturn('Bar');
		$mock->shouldReceive('getDriver')->once()->with('Bar')->andReturn('barfoo');
		
		$this->config->shouldReceive('get')->never()->with('camelot.default_provider')->andReturn('Foo');
		$mock->shouldReceive('getDriver')->never()->with('Foo')->andReturn('foobar');
		
		$mock->shouldReceive('checkForAlias')->once()->with('Bar')->andReturn('Bar');
		$mock->shouldReceive('loadAuthDriver')->once()->with('barfoo','Bar');
			
			         
		$mock->detectAuthDriver();
		
	}
	
	
	// test detectProviderFromSegments method
	
	public function testDetectsProviderIfDetectionIsTurnedOn()
	{
		$this->path = 'login/Foo/';
		$this->config->shouldReceive('get')->once()
					 ->with('camelot.detect_provider')
					 ->andReturn(true);
		$this->config->shouldReceive('get')->once()
					 ->with('camelot.route_location')
					 ->andReturn(2);
		$this->setCamelot();
		
		$result = $this->camelot->detectProviderFromSegments();
		
		
		assertThat($result, is('Foo'));	
	}
	public function testDetectProviderReturnsNullIfDetectionIsTurnedOff()
	{
		$this->path = 'login/Foo/';
		$this->config->shouldReceive('get')->once()
					 ->with('camelot.detect_provider')
					 ->andReturn(false);
		$this->config->shouldReceive('get')->never()
					 ->with('camelot.route_location')
					 ->andReturn(2);
		$this->setCamelot();
		
		$result = $this->camelot->detectProviderFromSegments();
		
		
		assertThat($result, is(null));
	}
	public function testDetectProviderReturnsNullIfSegmentIsNotSet()
	{
		$this->path = 'login';
		$this->config->shouldReceive('get')->once()
					 ->with('camelot.detect_provider')
					 ->andReturn(false);
		$this->config->shouldReceive('get')->never()
					 ->with('camelot.route_location')
					 ->andReturn(2);
		$this->setCamelot();
		
		$result = $this->camelot->detectProviderFromSegments();
		
		
		assertThat($result, is(null));
	}
	
	
	// testing the getDriver Method
	public function testGetDriverForGivenProvider(){
		$this->setCamelot();
		$provider = 'Foo';
		
		$result = $this->camelot->getDriver($provider);
		
		assertThat($result, is('bar'));
	}
	public function testGetDriverGivesNullForWrongProvider()
	{
		$this->setCamelot();
		$provider = 'Beer';
		
		$result = $this->camelot->getDriver($provider);
		
		assertThat($result, is(null));
	}
	public function testGetDriverGivesNullForNoProvider()
	{
		$this->setCamelot();
		
		$result = $this->camelot->getDriver();
		
		assertThat($result, is(null));
	}
	
	
	// testing the checkForAlias method
	
	public function testCheckForAliasReturnsCurrentProviderIfNoAliasIsSet()
	{
		$this->setCamelot();
		$provider = 'Foo';
		
		$result = $this->camelot->checkForAlias($provider);
		
		assertThat($result, is('Foo'));		
	}
	public function testCheckForAliasReturnsAliasIfSet()
	{	
		$this->setCamelot();
		$provider = 'Foobar';
		
		$result = $this->camelot->checkForAlias($provider);
		
		assertThat($result, is('Foo'));
	}
	public function testCheckForNestedAliases()
	{
		$this->setCamelot();
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

