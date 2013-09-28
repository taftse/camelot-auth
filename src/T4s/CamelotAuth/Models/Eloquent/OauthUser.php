<?php namespace T4s\CamelotAuth\Models\Eloquent;

use T4s\CamelotAuth\Models\Eloquent\User;

class OauthUser extends User implements UserInterface
{
	/**
	 * The Database table used by the model
	 * 
	 * @var string
	 */

	protected $table = 'account';

	public function account()
	{
		return $this->belongsTo($this->accountModel);
	}
	
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	public function getAccountID()
	{
		return $this->attributes['account_id'];
	}
}