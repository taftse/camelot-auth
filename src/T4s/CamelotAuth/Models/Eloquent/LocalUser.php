<?php namespace T4s\CamelotAuth\Models\Eloquent;

use illuminate\Database\Eloquent\Model;

use T4s\CamelotAuth\Models\UserInterface;

class LocalUser extends Model implements UserInterface
{
	/**
	 * The Database table used by the model
	 * 
	 - @var string
	 */

	protected $table = 'local_account';

	/**
	 * The attributes excluded from the json form 
	 *
	 * @var array
	 */

	protected $hidden = array('password_hash');

	public function Account()
	{

	}
	
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}


	public function getByAccountID($accountIdentifier)
	{
		
	}
	
}