<?php namespace TwswebInt\CamelotAuth\AuthDrivers;

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
				$user = $this->database->getByCredentials(array('username'=>$inputs[$userIdentifierField]));	
				
				// get model by username
				
				if($user instanceof UserInterface)
				{	
					//var_dump($user->account_id);
					if($user->getAuthPassword() === crypt($inputs[$userPasswordField],$user->getAuthPassword()))
					{

						if(Config::get('camelot-auth::localcamelot.accountStatus') && $user->account->status != 'active')
						{
							$this->returnResponse('error','Your account is not active ',array('status'=>$user->account->status));
						}
						if(Config::get('camelot-auth::localcamelot.maxPasswordAge') >0 && (strtotime("+".Config::get('camelot-auth::localcamelot.maxPasswordAge')." day",$user->password_set_timestamp) <= time()))
						{
							$responseType ='warning';
							if(Config::get('camelot-auth::localcamelot.enforcePasswordRules')){
								$responseType = 'error';
							}
							$this->returnResponse($responseType,'Your Password has expired please change it ',array('dateSet'=>$user->password_set_timestamp,'expireData'=>strtotime("+".Config::get('camelot-auth::localcamelot.maxPasswordAge')." day",$user->password_set_timestamp)));
						}
						if(!isset($this->errors['error'])){
							$this->createSession($user->account);
							return true;
						}else{
							return false;
						}
					}
					
				}

			// create session
			}
			$this->returnResponse('validation',$validation->messages());
			return false;
		}
	}
}