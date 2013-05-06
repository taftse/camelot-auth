<?php namespace TwswebInt\CamelotAuth\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use TwswebInt\CamelotAuth\Models\LocalAccountThrotelleInterface;

class LocalAccountThrotelle extends Model implements LocalAccountThrotelleInterface
{
	protected $table = 'local_account_throttle'; 

	public function getByCredentials(array $credentials)
	{
		
	}
}

