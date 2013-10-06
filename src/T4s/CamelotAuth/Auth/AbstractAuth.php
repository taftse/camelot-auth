<?php namespace T4s\CamelotAuth\Auth;

use T4s\CamelotAuth\Database\DatabaseInterface;
use T4s\CamelotAuth\Config\ConfigInterface;
use T4s\CamelotAuth\Session\SessionInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;
use T4s\CamelotAuth\Messaging\MessagingInterface;
use T4s\CamelotAuth\Events\DispatcherInterface;

use T4s\CamelotAuth\Models\AccountInterface;

use T4s\CamelotAuth\Exceptions\UserNotFoundException;
use T4s\CamelotAuth\Exceptions\AccountPendingActivationException;
use T4s\CamelotAuth\Exceptions\AccountSuspendedException;
use T4s\CamelotAuth\Exceptions\AccountNotActiveException;

abstract class AbstractAuth{

	/**
	 * The currentley authenticated user Account
	 *
	 * @var \T4s\CamelotAuth\AccountInterface 
	*/
	protected $account;

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
	protected $accountProvider;

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

	protected $provider;

	/**
	 * Indicated if the logout method has been called
	 *
	 * @var bool
	 */
	protected $loggedOut = false;

	public function __construct($provider,ConfigInterface $config,SessionInterface $session,CookieInterface $cookie,DatabaseInterface $database,MessagingInterface $messaging,$path)
	{
		$this->provider 	= $provider; // auth provider (string)
		$this->config 		= $config;
		$this->session 		= $session;
		$this->cookie 		= $cookie;
		$this->database 	= $database;
		$this->messaging	= $messaging;
		$this->path 		= $path;

		// load the account repository 
		$this->accountProvider =  $this->database->loadRepository('Account',$this->config->get('camelot.model'));
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
			//return Camelot::redirect($this->config->get('login_uri'));
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

		if(!is_null($this->account))
		{
			return $this->account;
		}

		$id = $this->session->get();

		if(!is_null($id))
		{
			return $this->account = $this->accountProvider->getByID($id);
		}

	}


	protected function createSession(AccountInterface $account,$remember = false)
	{
		if(!$account->isActive())
		{
			switch ($account->getStatus()) {
				case 'pending':
					$exception = new AccountPendingActivationException("account_activation_required");
					break;
				case 'suspended':
					$exception = new AccountSuspendedException("account_suspended");
					break;
				default:
					$exception = new AccountNotActiveException("account_not_active");
					break;
			}
					
			// check if a event dispatcher instance exists
			if(isset($this->dispatcher))
			{
				// fire off a warning shot
				$this->dispatcher->fire('camelot.auth.failed',array_values(compact('credentials','remember','login',$exception->toString())));
			}

			throw $exception;
					
		}

		$id = $account->getID();

		$this->session->put($id);

		if($remember)
		{
			$this->cookie->forever($id);
		}

		if(isset($this->dispatcher))
		{
			$this->dispatcher->dispatch('camelot.auth.'.$this->provider.'.loggedin',array($this->user(),$remember));
		}
		$account->updateLastLogin();
		return $this->account = $account;
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
		return true;
	}

	public function setEventDispatcher(DispatcherInterface $dispatcher)
	{
		$this->dispatcher = $dispatcher;
	}
}