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





	// set the name of the forms username field
	'userIdentifierField'=>'username',
	// set the name of the forms password field
	'userPasswordField'=>'password',
	// set the name of the forms login button
	'loginSubmitField'=>'login',

	// should we check to see if the status of the account
	'accountStatus'=> true,
	// should we check the password rules?
	'enforcePasswordRules'=>true,
	// set the maximum age of a password (in days) before it needs to be changed (0 for no maximum)
	'maxPasswordAge' =>0,
	);