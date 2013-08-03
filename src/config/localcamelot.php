<?php 

return array(



	/*
	|--------------------------------------------------------------------------
	| Authentication Model
	|--------------------------------------------------------------------------
	|
	| When using the "Eloquent" authentication driver, we need to know which
	| Eloquent model should be used to retrieve your users. Of course, it
	| is often just the "User" model but you may use whatever you like.
	|
	*/

	'model' => 'T4s\CamelotAuth\Models\Eloquent\LocalUser',

	/*
	|--------------------------------------------------------------------------
	| UserName form Field Name
	|--------------------------------------------------------------------------
	| 
	| The name used for the login forms username field
	|
	*/

	'username_field'=>'username',

	/*
	|--------------------------------------------------------------------------
	| Password form field Name
	|--------------------------------------------------------------------------
	|
	| The name used for the login forms password field
	|
	*/

	'password_field'=>'password',

	/*
	|-------------------------------------------------------------------------
	| Submit button name
	|-------------------------------------------------------------------------
	|
	| The name of the submit button which will trigger the login 
	|
	*/

	'login_button' => 'login',


	/*
	|-------------------------------------------------------------------------
	| User Identifier 
	|-------------------------------------------------------------------------
	|
	| This option tells camelot what table field it should check for the users  
	| identifier
	| 
	| the three possible options are username,email or both
	*/
	'userIdentifier' =>'username',





	// set the name of the forms login button
	'loginSubmitField'=>'login',


	/*
	|--------------------------------------------------------------------------
	| Throttler Model
	|--------------------------------------------------------------------------
	| 
	| The name used for the throttler model 
	|
	*/

	'throttler_model' =>'T4s\CamelotAuth\Models\Eloquent\Throttler',

/*

	// should we check to see if the status of the account
	'accountStatus'=> true,
	// should we check the password rules?
	'enforcePasswordRules'=>true,
	// set the maximum age of a password (in days) before it needs to be changed (0 for no maximum)
	'maxPasswordAge' =>0,*/


	);