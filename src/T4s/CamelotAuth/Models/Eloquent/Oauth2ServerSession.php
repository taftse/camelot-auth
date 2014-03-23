<?php namespace T4s\CamelotAuth\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

use T4s\CamelotAuth\Models\UserInterface;

class Oauth2ServerSession extends Model 
{

	/**
	 * The Database table used by the model
	 * 
	 * @var string
	 */

	protected $table = 'oauth2_sessions';

	/**
	 * The attributes excluded from the json form 
	 *
	 * @var array
	 */

	protected $hidden = array();



	public function validateClient($clientId,$clientSecret,$redirectUrl)
	{
		$this->select('name', 'client_id','auto_aprove');

		$this->where('client_id','=',$clientId);
		if(!is_null($clientSecret))
		{
			$this->where('client_secret','=',$clientSecret);
		}

		if(!is_null($redirectUrl))
		{
			$this->where('redirect_url','=',$redirectUrl);
		}

		return $this->first();
	}
}