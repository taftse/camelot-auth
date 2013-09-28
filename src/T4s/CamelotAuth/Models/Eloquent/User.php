<?php namespace T4s\CamelotAuth\Models\Eloquent;

use illuminate\Database\Eloquent\Model;

use T4s\CamelotAuth\Models\AccountInterface;

use T4s\CamelotAuth\Models\UserInterface;

class User extends Model
{
	protected $accountModel;


	public function __construct($accountModel)
	{

		if(is_string($accountModel))
		{
			$class = '\\'.ltrim($accountModel,'\\');

			$account = new $class;
			
			if(!$account instanceof AccountInterface)
			{
				throw new Exception("Error Processing Request", 1);
			}
			
			$this->accountModel = $accountModel;
		}
		else if(is_array($accountModel))
		{
				parent::__construct($accountModel);
		}
	}
}
