<?php namespace T4s\CamelotAuth\Auth;


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
	 * @var \T4s\CamelotAuth\repository\RepositoryInterface
	 */
	protected $repository;

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

	public function __construct(ConfigInterface $config,SessionInterface $session,CookieInterface $cookie,RepositoryInterface $repository)
	{
		$this->config 		= $config;
		$this->session 		= $session;
		$this->cookie 		= $cookie;
		$this->repository 	= $repository;
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
		
	}

}