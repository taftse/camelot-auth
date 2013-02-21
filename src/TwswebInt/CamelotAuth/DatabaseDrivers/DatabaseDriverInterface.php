<?php namespace TwswebInt\CamelotAuth\DatabaseDrivers;


interface DatabaseDriverInterface {
	
	/**
	 * Get the user by their unique id 
	 * @param mixed 
	 * @return 
	 */ 
	public function getByID($ID);

}