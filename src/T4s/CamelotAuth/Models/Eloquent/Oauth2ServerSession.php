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



	public function validateAccessToken($accountId,$clientId)
	{
		
		$query =$this->where('client_id','=',$clientId);
		$query->where('type_id','=',$accountId);
		$query->where('type','=','user');
		$query->where('access_token','!=','');
		$query->where('access_token','IS NOT NULL',null);

		return $query->first();
	}

	public function createAuthCode($accountId,$client,$redirectUri,$scopes,$accessToken)
	{
		$code = md5(time().uniqid());

		$query =$this->where('client_id','=',$client['client_id']);
		$query->where('type_id','=',$accountId);
		$query->where('type','=','user');

		if(!is_null($accessToken))
		{
			$query->where('access_token','=',$accessToken);
			$updates['code'] = $code;
			$updates['stage'] ='request';
			$updates['redirect_uri'] = $redirectUri;

			$query->update($updates);
			return $code;
		}

		$query->delete();

		$insert =  ['client_id'=>$client['client_id'],
					'redirect_uri'=> $redirectUri,
					'type_id' => $accountId,
					'type'=>'user',
					'code' => $code,
					'scopes'=>serialize($scopes)
					];
		$query->insert($insert);
		return $code;
	}

	public function validateAuthCode($code,$clientId,$redirectUri)
	{
		$query= $this->where('client_id','=',$client['client_id']);
		$query->where('redirect_uri','=',$redirect_uri);
		$query->where('code','=',$code);
		return $query->first();
	}

	public function getAccessToken($sessionId)
	{
		$query= $this->where('id','=',$sessionId);
		$query->where('access_token','IS NOT NULL',null);
		$token = $query->first();
		if(!is_null($token))
		{
			$query= $this->where('id','=',$sessionId);
			$updates['code'] = '';
			$updates['stage'] ='granted';
			$query->update($updates);
		}
		return $token;
	}

	public function generateAccessToken($sessionId)
	{
		$access_token = sha1(time().uniqid());

		$query= $this->where('id','=',$sessionId);
			$updates['code'] = '';
			$updates['stage'] ='granted';
			$update['access_token'] = $access_token;
			$query->update($updates);
		return $access_token;
	}
}