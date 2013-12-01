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
	| CSRF Token name
	|-------------------------------------------------------------------------
	|
	| The name of the CSRF Token
	|
	*/

	'csrf_token' => '_token',


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
	'userIdentifier' =>'both',//'email',//'username',



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
	|--------------------------------------------------------------------------
	| Hasher
	|--------------------------------------------------------------------------
	| 
	| The hasher to be used
	|
	*/

	'hasher' =>'T4s\CamelotAuth\Hasher\BcryptHasher',



	/*

	// should we check to see if the status of the account
	'accountStatus'=> true,
	// should we check the password rules?
	'enforcePasswordRules'=>true,
	// set the maximum age of a password (in days) before it needs to be changed (0 for no maximum)
	'maxPasswordAge' =>0,*/


	);