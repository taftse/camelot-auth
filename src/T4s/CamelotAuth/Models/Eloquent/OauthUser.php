<?php namespace T4s\CamelotAuth\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

use T4s\CamelotAuth\Models\UserInterface;

class OauthUser extends Model implements UserInterface
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

	public function getAccountID()
	{
		return $this->attributes['account_id'];
	}
}