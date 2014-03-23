<?php namespace T4s\CamelotAuth\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

use T4s\CamelotAuth\Models\UserInterface;

class Oauth2ServerApplication extends Model 
{

	/**
	 * The Database table used by the model
	 * 
	 * @var string
	 */

	protected $table = 'oauth2_applications';

	/**
	 * The attributes excluded from the json form 
	 *
	 * @var array
	 */

	protected $hidden = array();

	public $timestamps = true;
	
	public function getByClientID($clientId)
	{
		return $this->where('client_id',$clientId)->first();
	}

	public function validateClient($clientId,$clientSecret,$redirectUrl)
	{

		$query = $this->select('name', 'client_id','auto_aprove');

		$query->where('client_id','=',$clientId);
		if(!is_null($clientSecret))
		{
			$query->where('client_secret','=',$clientSecret);
		}

		if(!is_null($redirectUrl))
		{
			$query->where('redirect_uri','=',$redirectUrl);
		}

		return $query->first();
	}
}