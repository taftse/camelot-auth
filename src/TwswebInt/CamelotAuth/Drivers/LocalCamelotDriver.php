<?php namespace TwswebInt\CamelotAuth\Drivers;

use Config;
use Input;
use Validator;
use Request;

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
				
			// get model by username

			// test the password 

			// create session
			}

			return $validation->messages();
		}
	}
}