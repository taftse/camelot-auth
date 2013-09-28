<?php namespace T4s\CamelotAuth\Models;

interface AccountInterface
{
	
	public function getAuthIdentifier();
	

	public function isActive();
	
}