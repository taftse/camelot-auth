<?php namespace T4s\CamelotAuth\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use T4s\CamelotAuth\Models\Oauth2UserInterface;
use T4s\CamelotAuth\Models\Eloquent\Account;

class Oauth2User extends Model implements Oauth2UserInterface
{
	protected $table = 'oauth_users';
	
	protected $fillable = array('provider', 'user_id', 'username');
	
	public function Account()
	{
		return $this->belongsTo('T4s\CamelotAuth\Models\Eloquent\Account');
	}
}