<?php namespace T4s\CamelotAuth\Database;


class EloquentDatabase implements DatabaseInterface
{

	protected $config;


	public function __construct($config)
	{
		$this->config = $config;

	}

	public function loadRepository($repository,$model = null)
	{

		$class = 'T4s\CamelotAuth\Repositories\Eloquent\\'.ltrim($repository,'\\').'Provider';

		return new $class($this->config,$model);
	}
	
}