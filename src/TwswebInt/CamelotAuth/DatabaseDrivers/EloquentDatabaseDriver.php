<?php namespace TwswebInt\CamelotAuth\DatabaseDrivers;

use TwswebInt\CamelotAuth\Models as Models;

class EloquentDatabaseDriver implements DatabaseDriverInterface
{
	/**
	 * The eloquent user model
	 *
	 */
	protected $model;


	public function __construct($app,$authDriver)
	{
		$modelClass  = 'TwswebInt\CamelotAuth\Models\\'.ltrim($authDriver.'CamelotModel','\\');

		$this->model = new $modelClass;
	}	

	public function getByID($identifier)
	{
		return $this->model->newQuery()->find($identifier);
	}

	public function getByCredentials(array $credentials)
	{
		$query = $this->model->newQuery();

		foreach ($credentials as $key => $value) {
			if(!str_contains($key,'password'))
			{
				$query->where($key,$value);
			}
		}
		return $query->with('account')->first();
	}
}