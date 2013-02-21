<?php namespace TwswebInt\CamelotAuth\CookieDrivers;



interface CookieDriverInterface{

	/**
	 * Returnd the cookeis key.
	 *
	 * @return string
	 */
	public function getCookieKey();

	/**
	 * Put a value in the cookie.
	 *
	 * @param mixed $value
	 * @param int $time in minutes
	 * @return void
	 */
	public function put($value,$time);

	/**
	 * puts a value in the cookie forever.
	 *
	 * @param $value
	 * @return void
	 */
	public function putForever($value);

	/**
	 * gets the cookie value
	 * 
	 * @return mixed
	 */
	public function get();

	/**
	 * removes the cookie
	 *
	 * @return void
	 */
	public function remove();
}