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

	
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

}