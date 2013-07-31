<?php namespace T4s\CamelotAuth\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use T4s\CamelotAuth\Repositories\Eloquent\EloquentProvider
use T4s\CamelotAuth\Repositories\AccountProviderInterface;

class AccountProvider extends EloquentProvider implements AccountProviderInterface
{

	public function getByID($identifier)
	{
		return $this->createModel->newQuery->find($identifier);
	}

}