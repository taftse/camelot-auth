<?php namespace T4s\CamelotAuth\Database;


class EloquentDatabase implements DatabaseInterface
{

	public function loadRepository($repository,$model = null)
	{

		$class = 'T4s\CamelotAuth\Repositories\Eloquent\\'.ltrim($repository,'\\').'provider';

		return new $class($model);
	}
	
}