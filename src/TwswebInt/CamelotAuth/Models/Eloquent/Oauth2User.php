<?php namespace TwswebInt\CamelotAuth\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use TwswebInt\CamelotAuth\Models\Oauth2UserInterface;
use TwswebInt\CamelotAuth\Models\Eloquent\Account;

class Oauth2User extends Model implements Oauth2UserInterface
{
	protected $table = 'oauth_users';
	
	protected $fillable = array('provider', 'user_id', 'username');
	
	public function Account()
	{
		return $this->belongsTo('TwswebInt\CamelotAuth\Models\Eloquent\Account');
	}
}