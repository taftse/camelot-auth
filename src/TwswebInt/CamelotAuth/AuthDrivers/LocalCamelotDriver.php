<?php namespace TwswebInt\CamelotAuth\AuthDrivers;

use Config;
use Input;
use Validator;
use Request;
use TwswebInt\CamelotAuth\UserInterface as UserInterface;

use TwswebInt\CamelotAuth\Exceptions\UserNotFoundException;

class LocalCamelotDriver extends CamelotDriver
{

	protected $providerModel = 'TwswebInt\CamelotAuth\Models\LocalCamelotModel';
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
				try{
					$user = $this->database->getByCredentials(array('username'=>$inputs[$userIdentifierField]));	
				
				
				// get model by username
				
					if($user instanceof UserInterface)
					{	
						//var_dump($user->account_id);
						if($user->getAuthPassword() === crypt($inputs[$userPasswordField],$user->getAuthPassword()))
						{
							var_dump($user);
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
								$user->clearPasswordReset();
								$this->createSession($user->account);
								return true;
							}else{
								return false;
							}
						}

						
					}
				}
				catch(UserNotFoundException $exception)
				{
					throw $exception;
				}

			// create session
			}
			$this->returnResponse('validation',$validation->messages());
			return false;
		}
	}

	public function register()
	{

		// check if a session exists with account_id if yes then add these credentials to account
		$accountDetails['email'] = 'test@test.test';
		$accountID = $this->createAccount($accountDetails);
		// get input data 
		// validate input data
			$credentials['username'] = 'timmy';
			$credentials['password_hash'] = 'taftse';
			$credentials['account_id'] = $accountID;
			// if exception is thrown add a new record with the credential details to the database
		try{
			$user = $this->createModel()->findByCredentials($credentials);

			echo 'user account already registered ';
		}
		catch(UserNotFoundException $exception)
		{
			$user = null;
			$user = $this->createModel();
			return $user->create($credentials);
		}


		/*$userIdentifierField = Config::get('camelot-auth::localcamelot.userIdentifierField');
		$userPasswordField = Config::get('camelot-auth::localcamelot.userPasswordField');
		$registerSubmitField = Config::get('camelot-auth::localcamelot.registerSubmitField');
*/

	}
}