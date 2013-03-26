<?php namespace TwswebInt\CamelotAuth\DatabaseDrivers;


interface DatabaseDriverInterface{

	public function newModel($modelName,$options = null);


	
}