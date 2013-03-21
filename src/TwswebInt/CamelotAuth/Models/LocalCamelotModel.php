<?php namespace TwswebInt\CamelotAuth\Models;

use TwswebInt\CamelotAuth\UserInterface;
use TwswebInt\CamelotAuth\Models;
use Illuminate\Database\Eloquent\Model;

use TwswebInt\CamelotAuth\Exceptions\UserNotFoundException;

class LocalCamelotModel extends CamelotBaseModel implements UserInterface{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'local_account';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array(
		'password_hash',
		'password_hint',
		'security_question',
		'security_answer',
	);
	/**
	 * attributes that need to be hashed
	 *
	 * @var array
	 */
	protected $hashable = array(
		'password_hash',
	);

	public static $rules = array(
		''=>'',
			);

	public function save()
	{
		$this->validate();
		return parent::save();
	}



	public function findByCredentials(array $credentials)
	{
		$query = new LocalCamelotModel();
		$query	 = $query->with('account');
		$hashedCredentials  = array();
		foreach ($credentials as $credential => $value) {
			if(in_array($credential, $this->hashable))
			{
				$hashedCredentials = array_merge($hashedCredentials,array($credential=>$value));
			}else{
				$query = $query->where($credential,$value);
			}
		}
		if(!$user = $query->first())
		{
			throw new UserNotFoundException("no user found with the given credentials");
		}
		
		foreach ($hashedCredentials as $credential => $value) {
			
			if(!$this->checkHash($value,$user->{$credential}))
			{
				throw new UserNotFoundException("hashed credential [$credential] did not match for this user.");	
			}
		}
		return $user;
	}

	public function setAttribute($key,$value)
	{
		if(in_array($key,$this->hashable) && !empty($value))
		{
			$value = $this->hash($value);
		}
		return parent::setAttribute($key,$value);
	}

	public function hash($value)
	{
		$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$salt =  substr(str_shuffle(str_repeat($pool, 5)), 0, 16);
		return crypt($value,'$2a$'.str_pad(8, 2, '0', STR_PAD_LEFT).'$'.$salt.'$');
	}

	public function checkHash($string,$hashedString)
	{
		return crypt($string,$hashedString)===$hashedString;
	}

	public function account()
	{
		return $this->belongsTo('\TwswebInt\CamelotAuth\Models\CamelotAccount','account_id');
	}

	public function getAuthIdentifier()
	{
		return "account_id";
	}

	public function getAuthPassword()
	{
		return $this->password_hash;
	}

/*****

Need to clean up password reset functions

	*/

	public function getPasswordResetCode()
	{
		//$this->password_reset_code = 
	}
	public function validatePasswordResetCode($resetCode)
	{
		return($this->password_reset ==$resetCode);
	}

	public function attemptPasswordReset($resetCode,$newPasswordDetails)
	{
		if($this->validatePasswordResetCode($resetCode))
		{
			$this->resetPassword($newPasswordDetails);
		}
	}

	public function clearPasswordReset()
	{
		if($this->password_reset)
		{
			$this->password_reset = null;
			$this->save();
		}
	}

	protected function changePassword(array $passwordDetails)
	{
		/*password_hint,
		security_question,
		security_answer,*/
	}
}