<?php namespace T4s\CamelotAuth\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use T4s\CamelotAuth\Repositories\Eloquent\EloquentProvider;
use T4s\CamelotAuth\Repositories\UserProviderInterface;

class UserProvider extends EloquentProvider implements UserProviderInterface
{
	public function __construct($config, $model = null)
	{
		parent::__construct($config,$model);
	}

	public function getByID($identifier)
	{
		return $this->createModel()->newQuery()->find($identifier);
	}

	public function getByAccountID($accountIdentifier)
	{
		return $this->createModel()->getByAccountID($accountIdentifier);
	}

	public function getByCredentials(array $credentials)
	{
			$query = $this->createModel()->newQuery();
			foreach ($credentials as $key => $value) 
			{
				// if the key contains the word password then skip it
				if(!str_contains($key,'password'))
				{
					$query->where($key,$value);
				}
			}

			return $query->first();
	}


	public function createModel()
	{
		$class = '\\'.ltrim($this->model,'\\');
		
		return new $class();
	}

	//public function validateCredentials(UserProviderInterface $user,array $credentials);
}