<?php namespace T4s\CamelotAuth\Auth;

use T4s\CamelotAuth\Database\DatabaseInterface;
use T4s\CamelotAuth\Config\ConfigInterface;
use T4s\CamelotAuth\Session\SessionInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;
use T4s\CamelotAuth\Events\DispatcherInterface;

abstract class AbstractAuth{

	/**
	 * The currentley authenticated user
	 *
	 * @var \T4s\CamelotAuth\UserInterface 
	*/
	protected $user;

	/**
	 * The session store instance
	 *
	 * @var \T4s\CamelotAuth\Session\SessionInterface
	 */
	protected $session;

	/**
	 * The cookie store instance
	 *
	 * @var \T4s\CamelotAuth\Cookie\CookieInterface
	 */
	protected $cookie;

	/**
	 * The data handeler interface
	 *
	 * @var \T4s\CamelotAuth\database\databaseInterface
	 */
	protected $database;

	 /**
	 * The account handeler interface
	 *
	 * @var \T4s\CamelotAuth\repository\AccountRepositoryInterface
	 */
	protected $accountRepository;

	/**
	 * The event dispatcher instance
	 *
	 * @var \T4s\CamelotAuth\Event\DispatcherInterface
	 */
	protected $dispatcher;

	/**
	 * The requested url
	 *
	 * @var string
	 */ 
	protected $request;

	/**
	 * Indicated if the logout method has been called
	 *
	 * @var bool
	 */
	protected $loggedOut = false;

	public function __construct(ConfigInterface $config,SessionInterface $session,CookieInterface $cookie,DatabaseInterface $database)
	{
		$this->config 		= $config;
		$this->session 		= $session;
		$this->cookie 		= $cookie;
		$this->database 	= $database;

	}

	/**
	 * Determine if the current user is authenticated.
	 *
	 * @param bool redirect 
	 * @return bool
	 */
	public function check($redirect = false)
	{
		if(!is_null($this->user()))
		{
			return true;
		}
		else if($redirect)
		{
			$this->session->put($this->request,'return_url');
			return Camelot::redirect($this->config->get('login_uri'));
		}
		return false;
	}

	/**
	 * determine if the current user is a guest
	 *
	 * @return bool
	 */
	public function guest()
	{
		return is_null($this->user());
	}

	/**
	 * Get the currentley authenticated user.
	 *
	 * @return \T4s\CamelotAuth\UserInterface
	 */

	public function user()
	{
		if($this->loggedOut) return;

		if(!is_null($this->user))
		{
			return $this->user;
		}

		$id= $this->session->get();
		
		$user = null;

		if(!is_null($id))
		{
			return $this->user = $this->accountRepository->getByID($id);
		}

	}


	protected function createSession(AccountProviderInterface $account,$remember = false)
	{
		$id = $account->getID();
	}

	/**
	 * Logout the user 
	 *
	 * @return void
	 */

	public function logout()
	{
		if(isset($this->dispatcher))
		{
			$this->dispatcher->dispatch('camelot.auth.logout',array($this->user()));
		}

		$this->session->forget();
		$this->cookie->forget();

		$this->user = null;

		$this->loggedOut = true;
	}

}