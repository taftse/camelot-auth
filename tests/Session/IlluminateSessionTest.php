<?php namespace T4s\CamelotAuth\Tests\Session;
use Mockery as m;
use T4s\CamelotAuth\Session\IlluminateSession;
use PHPUnit_Framework_TestCase;
use Hamcrest;

class IlluminateSessionTest extends PHPUnit_Framework_TestCase
{
	protected $mock;
	protected $session;
	
	public function tearDown()
	{
		m::close();
	}
	
	public function setUp()
	{
		$this->store = m::mock('Illuminate\Session\Store');
		$this->session = new IlluminateSession($this->store);
	}
	
	public function testKeyDefaultsToCamelotAuth() 
	{	
		$this->assertEquals('camelot-auth',$this->session->getKey());	
	}
	
	public function testKeyCanBeChangedOnConstruct()
	{
		$this->session = new IlluminateSession($this->store,'Foo');
		
		$this->assertEquals('Foo',$this->session->getKey());
	}
	
	public function testStoreReceivesPutWithDefaultKey()
	{
		$this->store->shouldReceive('put')->once()->with('camelot-auth','value');
		
		$this->session->put('value');
	}
	public function testStoreReceivesPutWithCustomKey()
	{
		$this->store->shouldReceive('put')->once()->with('Foo','value');
		$this->session = new IlluminateSession($this->store,'Foo');
		
		$this->session->put('value');
	}
	
	public function testStoreReceivesGetWithDefaultKey()
	{
		$this->store->shouldReceive('get')->once()->with('camelot-auth',null)->andReturn('Bar');
		
		$result = $this->session->get();
		
		assertThat($result,is('Bar'));
		
	}
	public function testStoreReceivesGetWithCustomKey()
	{
		$this->store->shouldReceive('get')->once()->with('Foo',null)->andReturn('Bar');
		
		$result = $this->session->get('Foo');
		
		assertThat($result,is('Bar'));
	}
	public function testStoreReceivesGetWithCustomKeyAndDefault()
	{
		$this->store->shouldReceive('get')->once()->with('Foo','Bar')->andReturn('Bar');
		$this->session = new IlluminateSession($this->store,'Foo');
		
		$result = $this->session->get('Foo','Bar');
		
		assertThat($result,is('Bar'));
	}
	
	public function testStoreReceivesForgetWithDefaultKey()
	{
		$this->store->shouldReceive('forget')->once()->with('camelot-auth');
		
		$this->session->forget();
	}
	
	public function testStoreReceivesForgetWithCustomKey()
	{
		$this->store->shouldReceive('forget')->once()->with('Foo');
		
		$this->session->forget('Foo');
		
	}
}
