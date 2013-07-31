<?php namespace T4s\CamelotAuth\Models\Eloquent;


class LocalUser extends Model implements UserInterface
{
	/**
	 * The Database table used by the model
	 * 
	 - @var string
	 */

	protected $table = 'local_account';


	protected $hidden = array('password_hash');

	public function Account()
	{

	}
	
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	
}