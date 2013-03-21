<?php namespace TwswebInt\CamelotAuth;

interface UserInterface {

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier();

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword();


	//public function getAuthInternalID();

}