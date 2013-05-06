<?php namespace TwswebInt\CamelotAuth\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use TwswebInt\CamelotAuth\Models\Oauth2UserInterface;
use TwswebInt\CamelotAuth\Models\Eloquent\Account;

use TwswebInt\CamelotAuth\Auth\Local\Exceptions\UserNotFoundException;
class LocalUser extends Model 
{
	protected $table = 'local_account';
	
	protected $fillable = array('username', 'password_hint','security_question', 'security_answer');

	protected $hidden = array('password_hash');
	
	public function Account()
	{
		return $this->belongsTo('TwswebInt\CamelotAuth\Models\Eloquent\Account');
	}

	public function findByAccountID($accountId)
	{
		$query = $this->newQuery()->where('account_id','=',$accountId)->with('account');
		if($user = $query->first())
		{
			return $user;
		}
		throw new UserNotFoundException("no user found with the given account id");		
	}
}