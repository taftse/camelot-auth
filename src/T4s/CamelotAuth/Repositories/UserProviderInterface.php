<?php namespace T4s\CamelotAuth\Repositories;


interface UserProviderInterface
{
	public function getByID($identifier);

	public function getByAccountID($accountIdentifier);

	public function getByCredentials(array $credentials);

	public function validateCredentials(UserProviderInterface $user,array $credentials);
	
}