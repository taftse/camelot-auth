<?php namespace T4s\CamelotAuth\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use T4s\CamelotAuth\Models\OauthUserInterface;
use T4s\CamelotAuth\Models\Eloquent\Account;

class OauthUser extends Model implements OauthUserInterface
{
	protected $table = 'oauth_users';
	
	protected $fillable = array('provider', 'user_id', 'username');
	
	public function Account()
	{
		return $this->belongsTo('T4s\CamelotAuth\Models\Eloquent\Account');
	}
}