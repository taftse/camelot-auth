<?php namespace T4s\CamelotAuth\Models\Eloquent;


use T4s\CamelotAuth\Models\AccountInterface;
use illuminate\Database\Eloquent\Model;


class Account extends Model implements AccountInterface
{
	/**
	 * The Database table used by the model
	 * 
	 * @var string
	 */

	protected $table = 'account';

	protected $fillable = array('first_name', 'last_name', 'email', 
                  		'email_verified', 'address_1', 'address_2',
                   'city', 'zip_code', 'state_code', 'country_iso',
                   'dob', 'phone', 'gender', 'status'); 
	
	public $timestamps = true;


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

	public function getStatus()
	{
		return $this->attributes['status'];
	}

	public function getID()
	{
		return $this->attributes['id'];
	}

	public function updateLastLogin()
	{
		$this->attributes['last_login'] = date('Y-m-d H:i:s');
		$this->save();
	}
}