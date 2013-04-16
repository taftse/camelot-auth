<?php namespace TwswebInt\CamelotAuth\Database;


interface DatabaseInterface{

	public function newModel($modelName,$options = null);


	public function getByID($accountID);
}