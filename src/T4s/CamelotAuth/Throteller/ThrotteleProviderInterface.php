<?php namespace T4s\CamelotAuth\Throteller

interface ThrotteleProviderInterface
{

	/**
	* Get the current amount of attempts.
	*
	* @return int
	*/
	public function getLoginAttempts();

	/**
	* Add a new login attempt.
	*
	* @return void
	*/
	public function addLoginAttempt();

	/**
	* Clear all login attempts
	*
	* @return void
	*/
	public function clearLoginAttempts();

	/**
	* Suspend the user associated with the throttle
	*
	* @return void
	*/
	public function suspend();

	/**
	* Unsuspend the user.
	*
	* @return void
	*/
	public function unsuspend();

	/**
	* Check if the user is suspended.
	*
	* @return bool
	*/
	public function isSuspended();

	/**
	* Ban the user.
	*
	* @return bool
	*/
	public function ban();

	/**
	* Unban the user.
	*
	* @return void
	*/
	public function unban();

	/**
	* Check if user is banned
	*
	* @return void
	*/
	public function isBanned();

	/**
	* Check user throttle status.
	*
	* @var 	  array
	* @return bool
	* @throws T4s\CamelotAuth\Throteller\Exceptions\UserBannedException
	* @throws T4s\CamelotAuth\Throteller\Exceptions\UserSuspendedException
	*/
	public function check(array $credentials);

	/**
	* Saves the throttle.
	*
	* @return bool
	*/
	public function save();

}