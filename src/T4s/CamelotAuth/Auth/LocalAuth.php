<?php namespace T4s\CamelotAuth\Auth;

use T4s\CamelotAuth\Auth\LocalAuth;
use T4s\CamelotAuth\Auth\LocalAuth\Throttler;
use T4s\CamelotAuth\Event\DispatcherInterface;
use T4s\CamelotAuth\Session\SessionInterface;
use T4s\CamelotAuth\Cookie\CookieInterface;
use T4s\CamelotAuth\Config\ConfigInterface;
use T4s\CamelotAuth\Database\DatabaseInterface;
use T4s\CamelotAuth\Messaging\MessagingInterface;

use T4s\CamelotAuth\Models\UserInterface;

use T4s\CamelotAuth\Auth\LocalAuth\Exceptions\LoginRequiredExeption;
use T4s\CamelotAuth\Auth\LocalAuth\Exceptions\PasswordRequiredExeption;
use T4s\CamelotAuth\Auth\LocalAuth\Exceptions\IncorrectPasswordException;
use T4s\CamelotAuth\Exceptions\UserNotFoundException;
use T4s\CamelotAuth\Exceptions\AccountPendingActivationException;
use T4s\CamelotAuth\Exceptions\AccountSuspendedException;
use T4s\CamelotAuth\Exceptions\AccountNotActiveException;



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



		public function __construct($provider,ConfigInterface $config,SessionInterface $session,CookieInterface $cookie,DatabaseInterface $database,MessagingInterface $messaging,$path)
		{
			parent::__construct($provider,$config,$session,$cookie,$database,$messaging,$path);

			$this->userProvider =  $this->database->loadRepository('User',$this->config->get('localcamelot.model'));

			$this->hasher = $this->loadHasher($this->config->get('localcamelot.hasher'));
			//$this->throttler  = $this->database->loadRepository('Throttler',$this->config->get('localcamelot.throttler_model'));
			

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

				if($this->config->get('localcamelot.userIdentifier') =='both' || $this->config->get('localcamelot.userIdentifier') =='username')
				{
					$user = $this->userProvider->getByCredentials($credentials);
					
				}

				if((is_null($user) && $this->config->get('localcamelot.userIdentifier') =='both' )|| $this->config->get('localcamelot.userIdentifier') =='email' )
				{
					$account = $this->accountProvider->getByFields('email',$credentials[$this->config->get('localcamelot.username_field')]);
					if(!is_null($account))
					{
						$user =  $this->userProvider->getByAccountID($account->id);
					}
				}
				//*/
				//$user = $this->userProvider->getByCredentials($credentials);
				
				if(!$user instanceof UserInterface)
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
				if(!$this->hasher->checkHash($password,$user->getPassword()))
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
								
				if($login) 
				{
					return $this->createSession($account,$remember);
				}	
				return false; 			
			}	
		}

		public function register(array $accountDetails = array())
		{

		}


		protected function loadHasher($hasher)
		{
			$hasher = '\\'.ltrim($hasher);

			return new $hasher;
		}
}