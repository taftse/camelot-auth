<?php namespace T4s\CamelotAuth\Database;


class nativeDatabase implements DatabaseInterface
{


	protected $config;


	public function __constructor($config)
	{
		$this->config = $config;
	}
	

	public function loadRepository($repository,$model = null)
	{

		$class = 'T4s\CamelotAuth\Repositories\Native\\'.ltrim($repository,'\\').'provider';

		return new $class($model);
	}
	
}