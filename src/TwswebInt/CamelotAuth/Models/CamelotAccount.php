<?php Namespace TwswebInt\CamelotAuth\Models;

use TwswebInt\CamelotAuth\UserInterface;
use Illuminate\Database\Eloquent\Model;

class CamelotAccount extends Model implements UserInterface{

		
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'account';



	protected function localAccount()
	{
		//return $this->hasOne('TwswebInt\CamelotAuth\Models\LocalCamelotModel', 'account_id');
	}
	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return '';
	}
}