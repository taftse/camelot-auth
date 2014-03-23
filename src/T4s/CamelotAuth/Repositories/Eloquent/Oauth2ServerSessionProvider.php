<?php namespace T4s\CamelotAuth\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use T4s\CamelotAuth\Repositories\Eloquent\EloquentProvider;


class Oauth2ServerSessionProvider extends EloquentProvider 
{
	public function __construct($config, $model = null)
	{
		parent::__construct($config,$model);
	}

	

	


	public function validateClient($clientId, $clientSecret = null, $redirectUrl)
	{
		return $this->createModel()->validateClient($clientId,$clientSecret,$redirectUrl);
	}





	public function createModel()
	{
		$class = '\\'.ltrim($this->model,'\\');
		
		return new $class();
	}

	//public function validateCredentials(UserProviderInterface $user,array $credentials);
}