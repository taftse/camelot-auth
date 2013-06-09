<?php namespace T4s\CamelotAuth\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use T4s\CamelotAuth\Models\Oauth2UserInterface;
use T4s\CamelotAuth\Models\Eloquent\Account;

use T4s\CamelotAuth\Auth\Local\Exceptions\UserNotFoundException;
class LocalUser extends Model 
{
	protected $table = 'local_account';
	
	protected $fillable = array('username', 'password_hint','security_question', 'security_answer');

	protected $hidden = array('password_hash');
	
	public function Account()
	{
		return $this->belongsTo('T4s\CamelotAuth\Models\Eloquent\Account');
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