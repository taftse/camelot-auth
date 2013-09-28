<?php namespace T4s\CamelotAuth\Repositories;

use T4s\CamelotAuth\Models\AccountInterface;

interface AccountProviderInterface
{
	public function getByID($account_ID);
}