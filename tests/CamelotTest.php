<?php 


use Mockery as m;
use TwswebInt\CamelotAuth\Camelot;

class CamelotTest extends PHPUnit_Framework_TestCase {

	protected $hasher;

	protected $session;

	protected $cookie;

	protected $camelot;

	public function setUp()
	{
		//$this->hasher = m::mock('');

		$this->camelot = new Camelot();

	}

	public function tearDown()
	{
		m::close();
	}

	public function testLoggingInUser()
	{
		$user = m::mock('TwswebInt\CamelotAuth\UserInterface');
		$user->shouldReceive('status')->once()->andReturn('active');
	}
}