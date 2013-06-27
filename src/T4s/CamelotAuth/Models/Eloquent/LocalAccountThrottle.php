<?php namespace T4s\CamelotAuth\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use T4s\CamelotAuth\Models\LocalAccountThrotelleInterface;

class LocalAccountThrotelle extends Model implements LocalAccountThrotelleInterface
{
	protected $table = 'local_account_throttle'; 

	public function getByCredentials(array $credentials)
	{
		
	}
}

