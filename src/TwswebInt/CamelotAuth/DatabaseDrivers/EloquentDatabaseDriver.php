<?php namespace TwswebInt\CamelotAuth\DatabaseDrivers;

use TwswebInt\CamelotAuth\Models as Models;

class EloquentDatabaseDriver implements DatabaseDriverInterface
{
	/**
	 * The eloquent user model
	 *
	 */
	protected $model;


	public function __construct($authDriverName)
	{
		$modelClass  = '\\TwswebInt\CamelotAuth\Models\\'.ltrim($authDriverName.'CamelotModel','\\');

		$this->model = new $modelClass;
	}	

	public function getByID($identifier)
	{
		
		return $this->model->newQuery()->with('account')->where('account_id','=',$identifier)->first();
	}

	public function getByCredentials(array $credentials)
	{
		return  $this->model->findByCredentials($credentials);
	}
}