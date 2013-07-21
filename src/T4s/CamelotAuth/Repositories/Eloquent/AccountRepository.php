<?php namespace T4s\CamelotAuth\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use T4s\CamelotAuth\Repositories\AccountRepositoryInterface;

class AccountRepository implements AccountRepositoryInterface
{
	
	protected $model;

	public function __construct(Model $accountModel)
	{
		$this->model = $accountModel;
	}

	public function getByID($account_ID)
	{
		return $this->model->find($account_ID)->first();
	}

	public function isActive()
	{
		return $this->model->isActive();
	}
}