<?php namespace T4s\CamelotAuth\Models\Eloquent;

use illuminate\Database\Eloquent\Model;

class Account extends Model implements AccountInterface
{
	/**
	 * The Database table used by the model
	 * 
	 * @var string
	 */

	protected $table = 'account';

	
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	public function isActive()
	{
	 	if($this->attributes['status']=='active')
	 	{
	 		return true;
	 	}
	 	return false;
	}
}