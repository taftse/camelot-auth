<?php namespace TwswebInt\CamelotAuth\Auth;

use TwswebInt\CamelotAuth\Session\SessionInterface;
use TwswebInt\CamelotAuth\Cookie\CookieInterface;
use TwswebInt\CamelotAuth\Database\DatabaseInterface;
use TwswebInt\CamelotAuth\Throteller\ThrotteleProviderInterface;
// exceptions
use TwswebInt\CamelotAuth\Auth\Local\Exceptions\LoginRequiredException;
use TwswebInt\CamelotAuth\Auth\Local\Exceptions\UserNotFoundException;
use TwswebInt\CamelotAuth\Auth\Local\Exceptions\PasswordRequiredException;
use TwswebInt\CamelotAuth\Auth\Local\Exceptions\PasswordIncorrectException;

class LocalAuth extends AbstractAuth{

	/**
	* The throttle provider
	*
	* @var TwswebInt\CamelotAuth\Throteller\ThrotteleProviderInterface
	*/
	protected $throteller;

	public function authenticate(array $credentials = array(),$remember = false, $login = true)
	{
			// check that the required fields have been filled in 
				// if not all required fields returned return logonFieldRequired exception
			// check if a throteller has been enabled 
				// if the account is locked
			// check if the username exists in the db 
				// if no account throw usernameorPassword Incorrect exception
			// check passwords
				// if password incorrect throw usernameorPassword Incorrect exception
			// check if the account is active
				// if not active return account not activated exception
			// run createSession function to generate a new session

		// if the login attribute is sent then we are trying to login
		if(isset($credentials['login'])){

			if($this->events)
			{
				$this->event->fire('camelot.auth.attempt',array_values(compact('credentials','remember','login')));
			}

			//check that the required fields have been filled in 
			if(!(isset($credentials['username'])|| isset($credentials['email'])))
			{
				throw new LoginRequiredException(" username or email attribute is required");
			}
			if(!isset($credentials['password']))
			{
				throw new PasswordRequiredException('a password attribute is required.');
			}

			//check if a throteller has been enabled 
			if($this->throteller)
			{
				// will throw an exception if user is susspeneded 
				$this->throteller->check($credentials);
			}


			if(isset($credentials['username']))
			{
				$query = $this->database->createModel('LocalUser')->newQuery();
				$query->where('username','=',$credentials['username'])->with('account');

				if(!$localUser = $query->first())
				{
					if($this->throteller)
					{
						$this->throteller->addLoginAttempt();
					}

					throw new UserNotFoundException("no user found with the given username");
				}
			}
			else if(isset($credentials['email']))
			{
				$query = $this->database->createModel('Account')->newQuery();
				$query->where('email','=',$credentials['email']);
				if(!$account = $query->first())
				{
					if($this->throteller)
					{
						$this->throteller->addLoginAttempt();
					}

					throw new UserNotFoundException("no user found with the given email address");
				}
			

				$localUser = $this->database->createModel('LocalUser')->findByAccountID($account->id);
			}

			if(crypt($credentials['password'], $localUser->password_hash) !== $localUser->password_hash)
			{
				if($this->throteller)
				{
						$this->throteller->addLoginAttempt();
				}
				throw new PasswordIncorrectException("The provided password does not mach the account password");
			}

			

			if(!$localUser->Account->isActive())
			{
				throw new AccountNotActiveException("This account is not active");
			}

			return $this->createSession($localUser->Account);
			}
	}


	public function register(array $userDetails = array())
	{

	}
}