<?php namespace T4s\CamelotAuth\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use T4s\CamelotAuth\Repositories\UserRepositoryInterface;

class LocalUserRepository implements UserRepositoryInterface
{
	protected $model;

	public function __construct(Model $userModel)
	{
		$this->model = $userModel;
	}

	public function Account()
	{
		return $this->model->Account();
	}

	
}