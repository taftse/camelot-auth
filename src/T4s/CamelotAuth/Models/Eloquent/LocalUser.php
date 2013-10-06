<?php namespace T4s\CamelotAuth\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

use T4s\CamelotAuth\Models\UserInterface;

class LocalUser extends Model implements UserInterface
{
	/**
	 * The Database table used by the model
	 * 
	 * @var string
	 */

	protected $table = 'local_account';

	/**
	 * The attributes excluded from the json form 
	 *
	 * @var array
	 */

	protected $hidden = array('password_hash');


	public function getByAccountID($accountID)
	{
		return $this->where('account_id',$accountID)->first();
	}
	
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}


	public function getByCredentials($credentials)
	{
		//$query = $this->newQuery();
		return $this->getAuthIdentifier();
	}
	
	public function getPassword()
	{
		return $this->attributes['password_hash'];
	}

	public function getAccountID()
	{
		return $this->attributes['account_id'];
	}
}