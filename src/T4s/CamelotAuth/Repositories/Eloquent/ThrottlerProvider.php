<?php namespace T4s\CamelotAuth\Repositories\Eloquent;

use T4s\CamelotAuth\Repositories\Eloquent\EloquentProvider;

class ThrottlerProvider extends EloquentProvider implements ThrottlerProviderInterface
{

	protected $model = "T4s\CamelotAuth\Models\Eloquent\Throttler";

	protected $ipAddress = '0.0.0.0';

	public function __construct($model = null)
	{
		parent::__construct($model);

		$this->ipAddress = $_SERVER['REMOTE_ADDR'];
	}
}