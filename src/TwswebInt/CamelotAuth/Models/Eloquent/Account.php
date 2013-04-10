<?php namespace TwswebInt\CamelotAuth\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use TwswebInt\CamelotAuth\Models\AccountInterface;

class Account extends Model implements AccountInterface
{
	protected $table = 'account'; 

	
	protected $fillable = array('first_name', 'last_name', 'email', 
	 							 'email_verified', 'address_1', 'address_2',
	 							 'city', 'zip_code', 'state_code', 'country_iso', 
	 							 'dob', 'phone', 'gender');

	protected $dates = array('dob');

	public function setDobAttribute($value)
	{
		$this->attributes['dob'] = \DateTime::createFromFormat('m/d/Y',$value);
	}
}