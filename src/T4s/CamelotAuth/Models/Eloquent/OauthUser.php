<?php namespace T4s\CamelotAuth\Models\Eloquent;


class OauthUser extends Model implements UserInterface
{
	/**
	 * The Database table used by the model
	 * 
	 - @var string
	 */

	protected $table = 'account';

	
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	public function isActive()
	{
		
	}
}