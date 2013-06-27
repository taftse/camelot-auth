<?php namespace T4s\CamelotAuth\Database;


interface DatabaseInterface{

	public function newModel($modelName,$options = null);


	public function getByID($accountID);
}