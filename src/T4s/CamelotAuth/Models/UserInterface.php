<?php namespace T4s\CamelotAuth\Models;

interface UserInterface
{
	public function getAuthIdentifier();
	
	public function getByAccountID($accountIdentifier);

	public function getByCredentials($credentials);

	//public function getAccountID();
}