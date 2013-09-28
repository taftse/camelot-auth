<?php namespace T4s\CamelotAuth\Repositories;


interface UserProviderInterface
{
	/**
	 * gets the user by the unique identifier
	 *
	 * @param mixed $identifier 
	 * @return T4s\CamelotAuth\Models\UserInterface|null
	 */

	public function getByID($identifier);

	/**
	 * gets the user by the users accounts unique identifier
	 *
	 * @param mixed $accountIdentifier 
	 * @return T4s\CamelotAuth\Models\AccountInterface|null
	 */

	public function getByAccountID($accountIdentifier);

	/**
	 * gets the Account by the unique identifier
	 *
	 * @param mixed $identifier 
	 * @return T4s\CamelotAuth\Models\AccountInterface|null
	 */
	//public function getAccount($identifier);


	public function getByCredentials(array $credentials);

	//public function validateCredentials(UserProviderInterface $user,array $credentials);
	
}