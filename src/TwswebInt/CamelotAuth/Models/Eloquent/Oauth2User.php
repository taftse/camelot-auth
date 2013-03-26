<?php namespace TwswebInt\CamelotAuth\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use TwswebInt\CamelotAuth\Models\Oauth2UserInterface;

class Oauth2User extends Model implements Oauth2UserInterface
{
	protected $table = 'oauth_users';
	
	public function Account()
	{
		return $this->belongsTo('Account');
	}
}