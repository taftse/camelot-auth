<?php namespace TwswebInt\CamelotAuth\Models;

use TwswebInt\CamelotAuth\UserInterface;
use TwswebInt\CamelotAuth\Models;
use Illuminate\Database\Eloquent\Model;

class Oauth2CamelotModel extends Model implements UserInterface{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'oauth2_account';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password_hash');


	public function account()
	{
		return $this->belongsTo('TwswebInt\CamelotAuth\Models\CamelotAccount','account_id');
	}

	public function getAuthIdentifier()
	{
		return "account_id";
	}

	public function getAuthPassword()
	{
		return $this->password_hash;
	}
}