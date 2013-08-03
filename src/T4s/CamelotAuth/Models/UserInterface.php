<?php namespace T4s\CamelotAuth\Models;

interface UserInterface
{
	public function Account();

	public function getAuthIdentifier();
	
	//public function getByAccountID($accountIdentifier);

}