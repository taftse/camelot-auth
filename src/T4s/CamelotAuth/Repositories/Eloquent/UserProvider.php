<?php namespace T4s\CamelotAuth\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use T4s\CamelotAuth\Repositories\UserRepositoryInterface;

class UserProvider extends EloquentProvider implements UserProviderInterface
{
	
	public function getByID($identifier)
	{
		return $this->createModel()->newQuery()->find($identifier);
	}

	public function getByAccountID($accountIdentifier)
	{
		return $this->createModel->newQuery()->getByAccountID($accountIdentifier);
	}
}