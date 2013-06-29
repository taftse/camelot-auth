<?php namespace T4s\CamelotAuth\Auth;

use T4s\CamelotAuth\Session\SessionInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;
use T4s\CamelotAuth\Database\DatabaseInterface;
use T4s\CamelotAuth\Events\DispatcherInterface;

abstract class AbstractAuth{
	/**
	 * The currently authenticated user.
	 *
	 * @var T4s\CamelotAuth\User\UserInterface
	 */
	protected $user;

	/**
	* The Session Driver used by Camelot
	*
	* @var use T4s\CamelotAuth\Session\SessionInterface;
	*/
	protected $session;

	/**
	* The Cookie Driver used by Camelot
	*
	* @var use T4s\CamelotAuth\Cookie\CookieInterface;
	*/
	protected $cookie;

	/**
	* The event dispatcher instance.
	*
	* @var T4s\CamelotAuth\Events\DispatcherInterface;
	*/
	protected $events;

	/**
	* The name of the authentication provider
	*
	*/
	protected $providerName;

	protected $settings = array();

	protected $config = array();

	protected $httpPath = '';

	public function __construct(SessionInterface $session,CookieInterface $cookie,DatabaseInterface $database,$providerName,array $config,$httpPath)
	{
		$this->session = $session;
		$this->cookie = $cookie;
		$this->database = $database;
		$this->providerName = $providerName;
		$this->config = $config;
		$this->settings = $config['provider_routing'][ucfirst($providerName)]['config'];
		$this->httpPath = $httpPath;
	}



	public function check($redirect = false)
	{
		if(!is_null($this->user()))
		{

			return true;
		}
		else if($redirect)
		{
			// set return url
			$this->session->put($this->httpPath,'return_uri');
			//redirect to login page
			return $this->redirect($this->config['login_uri']);
		}
		return false;
	}

	public function user()
	{
		if(!is_null($this->user))
		{
			return $this->user;
		}

		$id= $this->session->get();

		$user = null;

		if(!is_null($id))
		{
			return $this->user = $this->database->getByID($id);
		}

		$id = $this->cookie->get();

		if(!is_null($id))
		{
			return $this->user = $this->database->getByID($id);
		}

		return null;
	}

	protected function createSession($account,$remember = false)
	{
		$id = $account->id;

		$this->session->put($id);

		if($remember)
		{
			$this->cookie->forever($id);
		}
		if(isset($this->events))
		{
			$this->events->fire('CamelotAuth.login',array($account,$remember));
		}
		return $this->user = $account;
	}

	abstract function authenticate(array $credentials = array(),$redirect_to = null,$remember = false, $login = true);

	abstract function register(array $userDetails = array());

	public function logout()
	{
		

		if(isset($this->events))
		{
			$this->events->fire('CamelotAuth.logout',array($this->user()));
		}
		$this->session->forget();
		$this->cookie->forget();

		$this->user = null;
	}

	public function redirect($to = null,$force = false)
	{
		/*var_dump($this->session->get('current_url'));
		var_dump($this->session->get('previous_url'));
		var_dump($this->session->get('redirect_url'));*/
		if(is_null($to))
		{

			$to = $this->session->get('redirect_url',$this->config['login_success_route']);
		}

		if($this->httpPath != $to)
		{

			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

			$host  = $_SERVER['HTTP_HOST'];
			$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
			$uri = str_replace($this->httpPath, '', $_SERVER['REQUEST_URI']);
			
			header("Location: ".$protocol.$host.$uri.$to);
			exit;
		}

		/*	1. check if a to route has been set in session
			2. check if a redirect to uri has been provided
			3. else send to default route
		*/	
		
			
	}
	/**
    * Get the event dispatcher instance.
    *
    * @return T4s\CamelotAuth\Events\DispatcherInterface
    */
    public function getEventDispatcher()
    {
        return $this->events;
    }

    /**
    * Set the event dispatcher instance.
    *
    * @param T4s\CamelotAuth\Events\DispatcherInterface
    */
    public function setEventDispatcher(DispatcherInterface $events)
    {
        $this->events = $events;
    }   
}