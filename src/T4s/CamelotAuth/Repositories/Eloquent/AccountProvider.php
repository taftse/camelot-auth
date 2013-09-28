<?php namespace T4s\CamelotAuth\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use T4s\CamelotAuth\Repositories\Eloquent\EloquentProvider;
use T4s\CamelotAuth\Repositories\AccountProviderInterface;

class AccountProvider extends EloquentProvider implements AccountProviderInterface
{
	
	public function __construct($config,$model = null)
	{
		
		parent::__construct($config,$model);
	}

	public function getByID($identifier)
	{
		return $this->createModel()->newQuery()->find($identifier);
	}

	public function getByFields($keys,$operator= null,$value = null)
	{
		$query = $this->createModel()->newQuery();
		// if there is a value then there is also a operator so its a single request
		if(!is_null($value))
		{
			return $query->where($keys,$operator,$value)->first();
		}
		// if operator is set then we have a key value pair
		else if(!is_null($operator))
		{
			return $query->where($keys,$operator)->first();
		}

		foreach ($keys as $key => $value) 
		{
			// if the key contains the word password then skip it
			if(!str_contains($key,'password'))
			{
				$query->where($key,$value);
			}
		}
		return $query->first();
	}
}