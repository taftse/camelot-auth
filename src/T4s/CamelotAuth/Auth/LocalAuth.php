<?php namespace T4s\CamelotAuth\Auth;

use T4s\CamelotAuth\Auth\LocalAuth;
use T4s\CamelotAuth\Auth\LocalAuth\Throttler;
use T4s\CamelotAuth\Event\DispatcherInterface;
use T4s\CamelotAuth\Session\SessionInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;
use T4s\CamelotAuth\Config\ConfigInterface;
use T4s\CamelotAuth\Database\DatabaseInterface;
use T4s\CamelotAuth\Messaging\MessagingInterface;

use T4s\CamelotAuth\Auth\Local\Exceptions\LoginRequiredExeption;
use T4s\CamelotAuth\Auth\Local\Exceptions\PasswordRequiredExeption;
use T4s\CamelotAuth\Auth\Local\Exceptions\IncorrectPasswordException;
use T4s\CamelotAuth\Exceptions\UserNotFoundException;

class LocalAuth extends AbstractAuth implements AuthInterface{

		/**
		 * The Throttler provider
		 *
		 * @var T4s\CamelotAuth\Auth\LocalAuth\Throttler\ThrottlerProviderInterface;
		 */
		protected $throttler;

		/**
		 * The Hashing Provder 
		 *
		 * @var T4s\CamelotAuth\Hasher\HasherInterface;
		 */
		protected $hasher;


		protected $userProvider;

		protected $accountProvider;


		public function __construct($provider,ConfigInterface $config,SessionInterface $session,CookieInterface $cookie,DatabaseInterface $database,MessagingInterface $messaging,$path)
		{
			parent::__construct($provider,$config,$session,$cookie,$database,$messaging,$path);


			$this->userProvider =  $this->database->loadRepository('User',$this->config->get('localcamelot.model'));

			$this->accountProvider =  $this->database->loadRepository('Account',$this->config->get('camelot.model'));

			//$this->throttler  = $this->database->loadRepository('Throttler',$this->config->get('localcamelot.throttler_model'));
			//$hasher = '\\'.ltrim($this->config->get('camelot'));

		}

		public function authenticate(array $credentials = null ,$remember = false, $login = true)
		{
			if(isset($credentials[$this->config->get('localcamelot.login_button')]))
			{
				// lets unset the button so it does not mess with our queries
				unset($credentials[$this->config->get('localcamelot.login_button')]);

				// check if a event dispatcher instance exists
				if($this->dispatcher)
				{
					// fire off a warning shot
					$this->dispatcher->fire('camelot.auth.attempt',array_values(compact('credentials','remember','login')));
				}


				if(!isset($credentials[$this->config->get('localcamelot.username_field')]))
				{
					throw new LoginRequiredExeption('username_required');
				}

				if(!isset($credentials[$this->config->get('localcamelot.password_field')]))
				{
					throw new PasswordRequiredExeption('password_required');
				}

				// check if the throttler is enabled 
				if(!is_null($this->throttler))
				{
					// checks if the user has been suspended or the ip is blacklisted
					//$this->throttler->blockedIp('user','');
				}

				$user = null;
				$account = null;

				if($this->config->get('localcamelot.userIdentifier') =='username' || $this->config->get('localcamelot.userIdentifier') =='both' )
				{
					$user = $this->userProvider->getByCredentials($credentials);
					
				}

				if(is_null($user)||$this->config->get('localcamelot.userIdentifier') =='email' || $this->config->get('localcamelot.userIdentifier') =='both' )
				{
					
				}

				if(!$user instanceof AccountInterface)
				{
					
					// check if the throttler is enabled 
					if(!is_null($this->throttler))
					{
						// add a failed login attempt
						$this->throttler->addLoginAttempt();
					}

					$userNotFound = new UserNotFoundException($credentials[$this->config->get('localcamelot.username_field')]);
					// check if a event dispatcher instance exists
					if($this->dispatcher)
					{
						// fire off a warning shot
						$this->dispatcher->fire('camelot.auth.failed',array_values(compact('credentials','remember','login','userNotFound')));
					}

					throw $userNotFound;
				
				}

				$password = $credentials[$this->config->get('localcamelot.password_field')];
				if(!$this->hasher->check($password,$user->getPasswordHash()))
				{

					// check if the throttler is enabled 
					if(!is_null($this->throttler))
					{
						// add a failed login attempt
						$this->throttler->addLoginAttempt();
					}

					$incorrectPassword = new IncorrectPasswordException("incorect_password");

					// check if a event dispatcher instance exists
					if($this->dispatcher)
					{
						// fire off a warning shot
						$this->dispatcher->fire('camelot.auth.failed',array_values(compact('credentials','remember','login','incorrectPassword')));
					}

					throw $incorrectPassword;
					
				}
						
				if(is_null($account))
				{
					$account = $this->accountProvider->getByID($user->getAccountID());
				}

				if(!$account->isActive())
				{
					$accountNotActive = new AccountNotActiveException("account_not_active");

					// check if a event dispatcher instance exists
					if($this->dispatcher)
					{
						// fire off a warning shot
						$this->dispatcher->fire('camelot.auth.failed',array_values(compact('credentials','remember','login','accountNotActive')));
					}

					throw $accountNotActive;
					
				}
				
				if($login) 
				{
					$this->createSession($account,$remember);
				}
				return true;
						
				
				
				
			}	
		}

		public function register(array $accountDetails = array())
		{

		}


}