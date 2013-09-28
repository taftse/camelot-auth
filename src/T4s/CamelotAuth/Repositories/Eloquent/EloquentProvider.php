<?php namespace T4s\CamelotAuth\Repositories\Eloquent;


class EloquentProvider
{

	protected $model;

	protected $config;

	public function __construct($config,$model = null)
	{
		
		if(!is_null($model))
		{
			$this->model = $model;
		}

		$this->config = $config;
	}

	public function createModel()
	{
		$class = '\\'.ltrim($this->model,'\\');
				
		return new $class;
	}
}