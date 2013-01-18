<?php namespace TwswebInt\CamelotAuth\Drivers;

use Config;
use Input;
use Validator;
use Request;
use TwswebInt\CamelotAuth\UserInterface as UserInterface;

class LocalCamelotDriver extends CamelotDriver
{

	public function authenticate()
	{
		$userIdentifierField = Config::get('camelot-auth::localcamelot.userIdentifierField');
		$userPasswordField = Config::get('camelot-auth::localcamelot.userPasswordField');
		$loginSubmitField = Config::get('camelot-auth::localcamelot.loginSubmitField');
		
		if(Request::getMethod() == 'POST')
		{
			$inputs = array(
				$userIdentifierField => Input::get($userIdentifierField),
				$userPasswordField =>Input::get($userPasswordField),
				);


			$rules = array(
				$userIdentifierField =>'min:5|required',
				$userPasswordField =>'min:5|required',
				);
			$validation = Validator::make($inputs,$rules);

			if ($validation->passes())
			{
	   		 // The given data passed validation
				$user = $this->database->getByCredentials(array('Local_User_Username'=>$inputs[$userIdentifierField]));	
				// get model by username
				//var_dump($user);
				if($user instanceof UserInterface)
				{	
					//var_dump($user->local_user_account_id);
					if($user->getAuthPassword() === crypt($inputs[$userPasswordField],$user->getAuthPassword()))
					{
						//var_dump(\DB::connection('mysql')->getQueryLog());
						var_dump($user->account->get());
						$this->createSession($user->account());
						return true;
					}
					
				}

			// create session
			}
			$this->errors = $validation->messages();
			return false;
		}
	}
}