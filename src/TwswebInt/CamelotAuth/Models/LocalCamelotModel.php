<?php Namespace TwswebInt\CamelotAuth\Models;

use TwswebInt\CamelotAuth\UserInterface;
use TwswebInt\CamelotAuth\Models;
use Illuminate\Database\Eloquent\Model;

class LocalCamelotModel extends Model implements UserInterface{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'auth_local_users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');


	public function account()
	{
		return $this->belongsTo('TwswebInt\CamelotAuth\Models\CamelotAccount','local_user_account_id');//getResults();
	}

	public function getAuthIdentifier()
	{
		return "Local_User_Account_ID";
	}

	public function getAuthPassword()
	{
		return $this->local_user_password_hash;
	}
}