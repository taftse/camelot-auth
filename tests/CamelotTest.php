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
		$this->session = m::mock('TwswebInt\CamelotAuth\Session\SessionInterface');
		$this->cookie = m::mock('TwswebInt\CamelotAuth\CookieDrivers\CookieDriverInterface');


		$config = array(
        'database_driver' => 'eloquent',
        'model' => 'CamelotUser',
		'default_driver' => 'local',
        'detect_provider' => true,
        'route_location' => 2,
		'provider_routing' => array('Local' => array('Driver'=>'local'),
								   'Google'=> array('Driver'=>'oauth2'),
                                   'Facebook'=> array('Driver'=>'oauth2'),
                                   'Foursquare' =>array('Driver'=>'oauth2'),
                                   'Windowslive'=>array('Driver'=>'oauth2'),
                                   'Edugate' => array('Driver'=>'saml')
                                   ),
        'login_uri' => 'account/login',
        'registration_uri' => 'account/register',
        'verification_uri' => 'account/verify');


		$this->camelot = new Camelot(
				$this->session,
				$this->cookie,
				$config,
				'login/local'
				);

	}

	public function tearDown()
	{
		m::close();
	}

	public function testLoadDriverPath()
	{
		//$authDriver = m::mock('TwswebInt\CamelotAuth\AuthDriver\CamelotDriver');
		$authDriver = $this->camelot->loadDriver();
		$this->assertEquals('local',$authDriver->getProviderName());
	}

	public function testNonExistantMethod()
	{
		
	}
	/*public function testLoggingInUser()
	{
		$user = m::mock('TwswebInt\CamelotAuth\UserInterface');
		$user->shouldReceive('status')->once()->andReturn('active');
	}*/
}