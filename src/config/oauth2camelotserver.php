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

	'application_model' => 'T4s\CamelotAuth\Models\Eloquent\Oauth2ServerApplication',

	'session_model' => 'T4s\CamelotAuth\Models\Eloquent\Oauth2ServerSession',


	/// list of accepted response types
	'response_type' => ['code'],

	'authorize_uri' => 'api/oauth2/authorize',

	'scopes' =>	[
					'user'		 =>['name'=>'User','description'=>'gets all the user infomation'],
					'user::email'=>['name'=>'User Email','description'=>'gets the users email'],
				],
	);